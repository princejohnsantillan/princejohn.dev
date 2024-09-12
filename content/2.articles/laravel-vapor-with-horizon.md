---
layout: article
description: I love Vapor's scale and Horizon's experience, but it's not possible... unless you really want it!
publishAt: "2024-09-12"
ogImage: true
---

Last year I started a project to migrate a vanilla PHP application into Laravel. The game plan was to start building the new Laravel app while keeping the legacy system running. I was contemplating whether we should deploy our new Laravel app using Forge or Vapor. When I looked at the existing infrastructure I saw that we were using AWS Elastic Beanstalk which allows for autoscaling when needed. So given the information I had back then I ended up deciding on Vapor.

We love our Vapor set up, it's serverless, easy to manage, and it's reliable. As we migrated more features over, more jobs needed to be run on the queue, like generating and emailing PDFs, data backfills, data syncs with third party systems, and import/export. Our experience was not bad, but it was not smooth either. We got bitten by a few Vapor queue limitations and quirks. There are 4 things we experienced that made me wish we were using Forge when dealing with queues:

- The 15 minute time limit set by AWS
- The 1000 concurrency limit also set by AWS
- Cost spikes
- Incompatibility with Laravel Horizon

This got me thinking, do we continue and just accept the nature of the beast? Or is there something we can do about it?

To make the long story short, I set off on an adventure to figure out how to make Vapor use queue workers managed by Forge. This setup would address all 4 issues while still hosting the main application on Vapor.

<br />

## 🧡 Marrying Vapor and Forge 🧡

**<u>NETWORK CONSIDERATIONS</u>**

Under the hood, this is really about making our Lambda-run application queue jobs that EC2-run workers can read and process. This means that these separate resources should be able to communicate or be in the same network. These are the resources we needed to make sure are connected:

- Vapor managed Lambda functions
- Forge managed EC2 server(s)
- Redis
  - We created this Redis instance in Vapor (under Caches) using the same VPC as our application
  - The reason we wanted to use Redis is to avoid the 15 minute time limit, 1000 concurrency limit, and of course compatibility with Horizon!
- Other resources that our jobs might use like database, cache, etc.

_You may use the VPC Vapor created when creating the Forge servers or vise versa, depending on which resource you're creating first. They can also be on separate VPCs and connected using VPC peering but do note that you'll need to ensure that they are under different CIDRs._

**<u>CODE ADJUSTMENTS</u>**

On the code side we needed to adjust a few things.

- Configuration related changes
  - Vapor auto assigns `SQS` to our `QUEUE_CONNECTION` so we needed to be explicit here that we'll want to use `redis` as the default. Alternatively, we can keep SQS as the default connection and just use the redis connection on long running jobs.
  - Since we are using redis cluster, we needed to wrap the redis prefix with curly brackets, example: `{prefix}:`. This is a known solution to a known issue. [Checkout this Github issue](https://github.com/laravel/horizon/issues/274).
- Job class or any queue-able class changes
  - We needed to ensure that the queue connection is using redis.
  - We can use both Vapor and Forge to handle jobs. If we wanted the job to be processed in Vapor, we use the `SQS` connection but if we wanted it in Forge, we use `redis`.

But eventually we decided to ditch SQS entirely and let our Forge workers process all jobs, so on our `vapor.yml` we set `queues: false`.

_Be aware though that if you decide to use both SQS and redis simultaneously, Horizon will only be able to show information about jobs queued in redis._

**<u>DEPLOYMENT CONSIDERATIONS</u>**

For our deployment, we didn't want to do separate manual deployments on Vapor and Forge because this would potentially put them in incompatible states, especially if one of them fail. So to mitigate this we created an artisan command that will programmatically deploy Forge using their SDK. This command is then registered as part of Vapor's deploy hook.

```yaml
environments:
  production:
    network: vapor-forge-vpc
    queues: false
    build:
      - "composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader"
    deploy:
      - "php artisan migrate --force"
      - "php artisan app:deploy-queue-worker 123456 --branch=main"
```

This way if Forge deployment fails, Vapor just cancels its deployment the same way it cancels the deployment if the `php artisan migrate` command fails. But if Forge deployment is successful, then Vapor deployment continues. Ideally, we put the Forge deployment command as the last deploy hook. If we really wanted to ensure that Vapor and Forge are always in compatible states where they have the same codebase, then we put our application in maintenance mode when starting our Forge deployment and only put it back live when Vapor deployment succeeds.

We added another redundancy to our setup where one Forge server contains 2 copies of our applications, called `blue` and `green` workers. These are basically just 2 separate sites in our Forge server. The artisan command will deploy on `blue` first and if succeeds it continues to deploy to `green` as well. This way if `blue` deployment fails, we still have a `green` worker that is functional that can continue to process jobs.

Here's a copy of what our Forge deployment artisan command looks like.

```php
class DeployQueueWorker extends Command
{
    protected $signature = 'app:deploy-queue-worker {server-id} {--branch=} {--api-token=}';

    protected $description = 'Deploy code changes to Forge queue worker server';

    private Forge $forge;

    private array $sites;

    private array $daemons;

    public function handle(): void
    {
        $serverId = $this->argument('server-id');

        $branch = $this->option('branch') ?? 'main';

        $apiToken = $this->option('api-token') ?? Config::string('services.forge.token');

        $this->forge = (new Forge($apiToken))->setTimeout(90);

        /** Deploy to Blue worker first */
        $this->deployWorker($serverId, 'blue', $branch);

        /**
         * We put green deployment within rescue because we don't really mind if this fails
         * since blue already works at this point.
         * We still report the issue though so we can fix it,
         * but deployment does not need to fail.
         */
        rescue(fn () => $this->deployWorker($serverId, 'green', $branch));
    }

    private function deployWorker(int $serverId, string $worker, string $branch): void
    {
        /**
         * Deployment steps:
         * 1. Update Forge site to the branch we want to deploy
         * 2. Stop/remove Horizon daemon
         * 3. Trigger Forge deployment
         * 4. Start Horizon daemon again
         */

        $site = $this->getSite($serverId, $worker);

        if($site->repositoryBranch !== $branch) {
            $branch = $this->updateSiteBranch($serverId, $site->id, $branch);
        }

        $this->stopHorizon($serverId, $worker);

        $this->forge->deploySite($serverId, $site->id);

        if (! Str::of($this->forge->siteDeploymentLog($serverId, $site->id))->contains('BW deployment success!!!')) {
            throw new RuntimeException("Worker [{$worker}] deployment failed!");
        }

        $this->startHorizon($serverId, $worker);
    }

    private function getSite(int $serverId, string $worker): Site
    {
        foreach ($this->getSites($serverId) as $site) {
            if($site->name === $worker) {
                return $site;
            }
        }

        throw new InvalidArgumentException("Worker [{$worker}] does not exist on the server.");
    }


    /** @return Site[] */
    private function getSites(int $serverId): array
    {
        return $this->sites ??= $this->forge->sites($serverId);
    }

    private function updateSiteBranch(int $serverId, int $siteId, string $branch): string
    {
        $this->forge->updateSiteGitRepository($serverId, $siteId, [
            'provider' => 'github',
            'repository' => 'organization/repository',
            'branch' => $branch,
        ]);

        sleep(5); // Allow update to propagate

        return (string) $this->forge->retry(
            $this->forge->getTimeout(),
            fn () => $this->forge->site($serverId, $siteId)->repositoryBranch === $branch ? $branch : null,
        );
    }

    /** @return Daemon[] */
    private function getDaemons(int $serverId): array
    {
        return $this->daemons ??= $this->forge->daemons($serverId);
    }

    private function stopHorizon(int $serverId, string $worker): void
    {
        foreach($this->getDaemons($serverId) as $daemon) {
            $command = $daemon->command;

            $directory = $daemon->directory;

            if($command === "php8.2 artisan horizon" && $directory === "/home/forge/{$worker}") {
                $daemon->delete();
                return;
            }
        }
    }

    private function startHorizon(int $serverId, string $worker): Daemon
    {
        $daemon = $this->forge->createDaemon($serverId, [
            'command' => 'php8.2 artisan horizon',
            'user' => 'forge',
            'directory' => "/home/forge/{$worker}",
        ]);

        return $daemon;
    }
}
```

_Depending on your subscription and setup you may also incorporate Laravel Envoyer._

I hope you enjoyed this and found this informative, or at least tickled your brain to think of new solutions.

<hr />

I'm looking to get to know more Laravel friends, say hi on [Twitter/X](https://x.com/pjsantillan)!
