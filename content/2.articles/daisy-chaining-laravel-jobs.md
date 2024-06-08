---
layout: article
description: We overcame Laravel Vapor timeout limits by implementing cursor pagination via daisy chaining jobs.
publishAt: "2024-06-08"
ogImage: true
---

So at work we needed to add Laravel scout, we decided to go with [Typesense](https://typesense.org/). <br>
This was fairly easy to set up, just follow the [docs](https://laravel.com/docs/11.x/scout#typesense).

- We tested locally, using a dockerized Typesense via Laravel Sail. Import worked, search worked! Easy! ✅
- We tested on staging, using Laravel Vapor. Import worked, search worked! Easy! ✅
- We deployed to production, using Laravel Vapor. Import... failed! ❌ 😱

## What happened?

In local we tested using <u>hundreds</u> of rows. In staging we tested using <u>thousands</u> of rows. But production had <u>millions</u> of rows!

We ran [php artisan scout:import "App\Models\Record"]{.hl} and it timed out. Ok maybe setting [SCOUT_QUEUE]{.hl} to [true]{.hl} is the only thing we need here. We changed it, redeployed, and reran the command; sadly it still timed out. Good news is we were seeing hundreds of jobs being processed, some of them successful and some failed. The errors were caused by [exceeding maximum retries]{.hl} and [database connection issues]{.hl}.

The model we were trying to import was using a view as its table so we reviewed the underlying query. We found out that it was inefficient because a couple of indexes were missing. We fixed the view and at the same time made a few Vapor config updates that we thought would help. We increased the [queue-memory]{.hl} and [queue-timeout]{.hl}, reduced the [queue-concurrency]{.hl} value to avoid maxing out our database connections, and defined a dedicated queue so we can clear it by itself when we needed to.

```yml
environments:
  production:
    queue-memory: 2048
    queue-timeout: 300
      queues:
        - default-production
        - scout-production: 50
```

Ok, hopefully this does it. Again, we pushed the changes, redeployed, and reran the command. This time around the jobs were all successful but unfortunately the artisan command still timed out and couldn't complete the import. Not there yet but it's good progress, maybe increasing the [cli-timeout]{.hl} is all we need here. We implemented the change unfortunately the command still times out. What are we doing wrong?

We found ourselves source diving the [scout:import]{.hl} command. And luckily we found the culprit for our issues. See [SearchableScope.php](https://github.com/laravel/scout/blob/49d2be17c1ff59bc26867cfc8bdafff52aa3cdaa/src/SearchableScope.php#L34-L42).

```php
$builder->macro('searchable', function (EloquentBuilder $builder, $chunk = null) {
    $scoutKeyName = $builder->getModel()->getScoutKeyName();

    $builder->chunkById($chunk ?: config('scout.chunk.searchable', 500), function ($models) {
        $models->filter->shouldBeSearchable()->searchable();

        event(new ModelsImported($models));
    }, $builder->qualifyColumn($scoutKeyName), $scoutKeyName);
});
```

[chunkById]{.hl} here works until it doesn't. Because chunk is just a loop, the more records you have the longer this loop will take. Unfortunately for us we were trying to import more than 2M rows, making us hit our Vapor CLI timeout.

## How did we solve it?

So now that we know the issue, time to write a solution. What do we need?

- A replacement command that can scale
- A job that performs the import through a queue

What do we need to consider?

- CLI timeout
- Queue timeout
- Throttling

The solution we came up with is [daisy chaining jobs]{.hl}. We can accomplish daisy chaining simply by dispatching another instance of the same job within the job itself. To avoid infinite loop we have to make sure we have an exit logic in place. For our case here it stops dispatching a new job when it's at the end of the table.

```php
class MakeModelSearchable implements ShouldQueue
{
    public function __construct(
        public string $class,
        public int|string|null $cursor = null,
        public int $chunk = 500
    ) {
    }

    public function handle(): void
    {
        /** @var Model $model */
        $model = new ($this->class);

        // CURSOR BASED PAGINATION
        $keys = $model::query()
            ->limit($this->chunk)
            ->when($this->cursor !== null, function(Builder $q){
              return $q->where($model->getKeyName(), '>', $this->cursor);
            })
            ->pluck($model->getKeyName());

        // THIS IS OUR EXIT LOGIC
        if($keys->isEmpty()) {
            return;
        }

        // CALL SCOUT'S SEARCHABLE METHOD TO PERFORM THE IMPORT
        $model::query()
          ->whereIn($model->getKeyName(), $keys)
          ->searchable();

        // WE DISPATCH ANOTHER JOB WITH A NEW CURSOR
        static::dispatch($this->class, $keys->last(), $this->chunk);
    }
}
```

We start the import process with a command that dispatches the first job.

```php
class ImportScoutModel extends Command
{
    protected $signature = 'app:import-scout-model
            {model : Class name of model to bulk import}
            {--c|chunk= : The number of records to import at a time (Defaults to configuration value: `scout.chunk.searchable`)}';

    public function handle(): int
    {
        $class = $this->argument('model');

        $chunk = $this->option('chunk') ?? config('scout.chunk.searchable');

        MakeModelSearchable::dispatch($class, null, $chunk);

        return self::SUCCESS;
    }

}
```

With this approach we are able to address the CLI timeout because it's only responsible for dispatching the first job. Queue timeout was already addressed by optimizing our queries. Throttling issues can easily be addressed by tweaking our job class' backoff strategy.

This solution is inspired by [Aaron Francis' cursor pagination lesson](https://planetscale.com/learn/courses/mysql-for-developers/examples/cursor-pagination).

## Lessons learned along the way

- When pairing Laravel Scout with Typesense and queue is set to true, be sure to restart your queue after running a [scout:flush]{.hl} You're gonna get a [Typesense\Exceptions\ObjectNotFound]{.hl} exception if you do an import without restarting.
