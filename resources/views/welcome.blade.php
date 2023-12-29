<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    @vite('resources/css/app.css')

</head>

<body>
    <div class="bg-site px-6 py-24 sm:py-32 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <p class="text-base font-semibold leading-7 text-orange-600">Hello, my name is</p>
            <h2 class="mt-2 text-4xl font-bold tracking-tight text-neutral-900 sm:text-6xl">Prince John</h2>
            <p class="mt-6 text-lg leading-8 text-neutral-600">No, I don't live in a castle and I don't run a country, I
                am a guy from the the Philippines. I am a father to a beautiful little girl and a husband to an
                incredible woman that I'm madly inlove with. Also, I do software development for a living and I'm really
                enjoying it!</p>
        </div>
    </div>


    <div class="bg-white px-6 py-32 lg:px-8">
        <div class="mx-auto max-w-3xl text-base leading-7 text-gray-700">
            <p class="text-base font-semibold leading-7 text-orange-600">Dec 29, 2023</p>
            <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Year in review: 2023</h1>
            <p class="mt-6 text-xl leading-8">This is my very first time writing and my first time putting a public site
                for myself. So to keep things simple I will put this very first content on the home page, I will move it
                later to it's own path when as I continue to write more.</p>
            <p class="mt-6 text-xl leading-8">to be continued ...</p>
            <div class="mt-10 max-w-2xl">
                <p>Faucibus commodo massa rhoncus, volutpat. Dignissim sed eget risus enim. Mattis mauris semper sed
                    amet vitae sed turpis id. Id dolor praesent donec est. Odio penatibus risus viverra tellus varius
                    sit neque erat velit. Faucibus commodo massa rhoncus, volutpat. Dignissim sed eget risus enim.
                    Mattis mauris semper sed amet vitae sed turpis id.</p>
                <ul role="list" class="mt-8 max-w-xl space-y-8 text-gray-600">
                    <li class="flex gap-x-3">
                        <svg class="mt-1 h-5 w-5 flex-none text-orange-600" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                clip-rule="evenodd" />
                        </svg>
                        <span><strong class="font-semibold text-gray-900">Data types.</strong> Lorem ipsum, dolor sit
                            amet consectetur adipisicing elit. Maiores impedit perferendis suscipit eaque, iste dolor
                            cupiditate blanditiis ratione.</span>
                    </li>
                    <li class="flex gap-x-3">
                        <svg class="mt-1 h-5 w-5 flex-none text-orange-600" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                clip-rule="evenodd" />
                        </svg>
                        <span><strong class="font-semibold text-gray-900">Loops.</strong> Anim aute id magna aliqua ad
                            ad non deserunt sunt. Qui irure qui lorem cupidatat commodo.</span>
                    </li>
                    <li class="flex gap-x-3">
                        <svg class="mt-1 h-5 w-5 flex-none text-orange-600" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                clip-rule="evenodd" />
                        </svg>
                        <span><strong class="font-semibold text-gray-900">Events.</strong> Ac tincidunt sapien vehicula
                            erat auctor pellentesque rhoncus. Et magna sit morbi lobortis.</span>
                    </li>
                </ul>
                <p class="mt-8">Et vitae blandit facilisi magna lacus commodo. Vitae sapien duis odio id et. Id
                    blandit molestie auctor fermentum dignissim. Lacus diam tincidunt ac cursus in vel. Mauris varius
                    vulputate et ultrices hac adipiscing egestas. Iaculis convallis ac tempor et ut. Ac lorem vel
                    integer orci.</p>
                <h2 class="mt-16 text-2xl font-bold tracking-tight text-gray-900">From beginner to expert in 3 hours
                </h2>
                <p class="mt-6">Id orci tellus laoreet id ac. Dolor, aenean leo, ac etiam consequat in. Convallis arcu
                    ipsum urna nibh. Pharetra, euismod vitae interdum mauris enim, consequat vulputate nibh. Maecenas
                    pellentesque id sed tellus mauris, ultrices mauris. Tincidunt enim cursus ridiculus mi. Pellentesque
                    nam sed nullam sed diam turpis ipsum eu a sed convallis diam.</p>
                <figure class="mt-10 border-l border-orange-600 pl-9">
                    <blockquote class="font-semibold text-gray-900">
                        <p>“Vel ultricies morbi odio facilisi ultrices accumsan donec lacus purus. Lectus nibh
                            ullamcorper ac dictum justo in euismod. Risus aenean ut elit massa. In amet aliquet eget
                            cras. Sem volutpat enim tristique.”</p>
                    </blockquote>
                    <figcaption class="mt-6 flex gap-x-4">
                        <img class="h-6 w-6 flex-none rounded-full bg-gray-50"
                            src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                            alt="">
                        <div class="text-sm leading-6"><strong class="font-semibold text-gray-900">Maria Hill</strong> –
                            Marketing Manager</div>
                    </figcaption>
                </figure>
                <p class="mt-10">Faucibus commodo massa rhoncus, volutpat. Dignissim sed eget risus enim. Mattis mauris
                    semper sed amet vitae sed turpis id. Id dolor praesent donec est. Odio penatibus risus viverra
                    tellus varius sit neque erat velit.</p>
            </div>
            <figure class="mt-16">
                <img class="aspect-video rounded-xl bg-gray-50 object-cover"
                    src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&auto=format&fit=facearea&w=1310&h=873&q=80&facepad=3"
                    alt="">
                <figcaption class="mt-4 flex gap-x-2 text-sm leading-6 text-gray-500">
                    <svg class="mt-0.5 h-5 w-5 flex-none text-gray-300" viewBox="0 0 20 20" fill="currentColor"
                        aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z"
                            clip-rule="evenodd" />
                    </svg>
                    Faucibus commodo massa rhoncus, volutpat.
                </figcaption>
            </figure>
            <div class="mt-16 max-w-2xl">
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">Everything you need to get up and running
                </h2>
                <p class="mt-6">Purus morbi dignissim senectus mattis adipiscing. Amet, massa quam varius orci dapibus
                    volutpat cras. In amet eu ridiculus leo sodales cursus tristique. Tincidunt sed tempus ut viverra
                    ridiculus non molestie. Gravida quis fringilla amet eget dui tempor dignissim. Facilisis auctor
                    venenatis varius nunc, congue erat ac. Cras fermentum convallis quam.</p>
                <p class="mt-8">Faucibus commodo massa rhoncus, volutpat. Dignissim sed eget risus enim. Mattis mauris
                    semper sed amet vitae sed turpis id. Id dolor praesent donec est. Odio penatibus risus viverra
                    tellus varius sit neque erat velit.</p>
            </div>
        </div>
    </div>




    <footer class="bg-site">
        <div class="mx-auto max-w-7xl overflow-hidden px-6 py-20 sm:py-24 lg:px-8">
            <!--
          <nav class="-mb-6 columns-2 sm:flex sm:justify-center sm:space-x-12" aria-label="Footer">
            <div class="pb-6">
              <a href="#" class="text-sm leading-6 text-neutral-600 hover:text-neutral-900">Writings</a>
            </div>
            <div class="pb-6">
              <a href="#" class="text-sm leading-6 text-neutral-600 hover:text-neutral-900">Projects</a>
            </div>
            <div class="pb-6">
                <a href="#" class="text-sm leading-6 text-neutral-600 hover:text-neutral-900">Random</a>
              </div>
          </nav>
          -->
            <div class="mt-10 flex justify-center space-x-10">
                <a href="https://twitter.com/pjsantillan" class="text-neutral-400 hover:text-neutral-500">
                    <span class="sr-only">Twitter</span>
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path
                            d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                    </svg>
                </a>
                <a href="https://github.com/princejohnsantillan" class="text-neutral-400 hover:text-neutral-500">
                    <span class="sr-only">GitHub</span>
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
                <!--
                Add Linkedin
            -->
            </div>
            <p class="mt-10 text-center text-xs leading-5 text-neutral-500">&copy; 2023 Prince John Santillan. All
                rights reserved.</p>
        </div>
    </footer>
</body>

</html>
