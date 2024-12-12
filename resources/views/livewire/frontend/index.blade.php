<div>
    <section class="mb-16 md:mb-36 flex flex md:gap-8" id="about">
        <div class="md:w-3/4 md:text-lg md:leading-8">
            <h1 class="text-4xl md:text-6xl font-extrabold text-indigo-600">
                {{ $profile->designation }}
            </h1>
            <p class="mt-5 text-neutral-600 leading-9 text-justify">
                {{ $profile->intro }}
            </p>
            <div class="mt-10 flex gap-2">
                <button type="button"
                    class="inline-block rounded bg-indigo-500 px-6 py-3 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                    Hire Me
                </button>
                <button type="button"
                    class="inline-block rounded border border-indigo-400 px-6 py-3 text-indigo-600 text-xs font-medium uppercase leading-normal shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:border-indigo-400 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] hover:bg-indigo-500 hover:text-white focus:border-indigo-400 focus:text-white focus:outline-none focus:ring-0 active:border-indigo-400 active:text-white"
                    data-te-ripple-init>
                    Download my resume
                </button>
            </div>
        </div>
        <div class="hidden md:block md:w-1/3">
            <img src="{{ $profile->image_path }}" class="mx-auto md:w-64 rounded-lg shadow-md" alt="Profile Pic" />
        </div>
    </section>

    <!--Portfolios-->

    @if($portfolios)
        <x-portfolio-list :portfolios="$portfolios" name="Latest Work"/>
    @endif
    
    <!--End Portfolios-->

    <section class="md:flex" id="blog">
        <div class="w-full md:w-2/3 md:mr-20">
            <h1
                class="mb-5 md:mb-10 flex items-center after:ml-4 after:bg-gray-300 after:h-px after:w-1/2 after:grow uppercase text-xs font-medium">
                Content
            </h1>

            <a href="https://themsaid.com/infrastructure-management-for-several-high-traffic-php-applications"
                class="mb-16 block">
                <h2 class="font-bold text-xl md:text-3xl">Infrastructure management for several high-traffic PHP
                    applications</h2>

                <p class="mt-4 md:leading-7 md:text-lg">
                    This post describes how I manage the infrastructure for 50+ high-traffic PHP applications.
                    Covering things like conatiners vs. serverless vs. servers, OPcache, zero-downtime
                    deployments, and IaC.
                </p>

                <p class="mt-4 uppercase text-xs inline-flex space-x-2 font-medium text-gray-500">
                    <span>Aug 8, 2023</span>
                    <span
                        class="before:mr-2 before:bg-gray-400 before:w-[2px] before:h-[2px] before:rounded-full flex items-center">13
                        min read</span>
                </p>
            </a>
            <a href="https://themsaid.com/infrastructure-management-for-several-high-traffic-php-applications"
                class="mb-16 block">
                <h2 class="font-bold text-xl md:text-3xl">Infrastructure management for several high-traffic PHP
                    applications</h2>

                <p class="mt-4 md:leading-7 md:text-lg">
                    This post describes how I manage the infrastructure for 50+ high-traffic PHP applications.
                    Covering things like conatiners vs. serverless vs. servers, OPcache, zero-downtime
                    deployments, and IaC.
                </p>

                <p class="mt-4 uppercase text-xs inline-flex space-x-2 font-medium text-gray-500">
                    <span>Aug 8, 2023</span>
                    <span
                        class="before:mr-2 before:bg-gray-400 before:w-[2px] before:h-[2px] before:rounded-full flex items-center">13
                        min read</span>
                </p>
            </a>
            <a href="https://themsaid.com/infrastructure-management-for-several-high-traffic-php-applications"
                class="mb-16 block">
                <h2 class="font-bold text-xl md:text-3xl">Infrastructure management for several high-traffic PHP
                    applications</h2>

                <p class="mt-4 md:leading-7 md:text-lg">
                    This post describes how I manage the infrastructure for 50+ high-traffic PHP applications.
                    Covering things like conatiners vs. serverless vs. servers, OPcache, zero-downtime
                    deployments, and IaC.
                </p>

                <p class="mt-4 uppercase text-xs inline-flex space-x-2 font-medium text-gray-500">
                    <span>Aug 8, 2023</span>
                    <span
                        class="before:mr-2 before:bg-gray-400 before:w-[2px] before:h-[2px] before:rounded-full flex items-center">13
                        min read</span>
                </p>
            </a>
        </div>
        <div class="w-full md:w-1/3">
            <h1
                class="mb-5 md:mb-10 flex items-center after:ml-4 after:bg-gray-300 after:h-px after:w-1/2 after:grow uppercase text-xs font-medium">
                Topics
            </h1>
            <div>
                <a href="https://themsaid.com/topic/php-laravel" class="flex items-center mb-5 block">
                    <h3 class="text-sm md:text-md font-medium">PHP &amp; Laravel</h3>
                    <span class="rounded-full border border-gray-200 text-xs px-2 py-1 ml-auto">12
                        posts</span>
                </a>
                <a href="https://themsaid.com/topic/programming-careers" class="flex items-center mb-5 block">
                    <h3 class="text-sm md:text-md font-medium">Programming Careers</h3>
                    <span class="rounded-full border border-gray-200 text-xs px-2 py-1 ml-auto">1
                        posts</span>
                </a>
                <a href="https://themsaid.com/topic/architecture" class="flex items-center mb-5 block">
                    <h3 class="text-sm md:text-md font-medium">Architecture</h3>
                    <span class="rounded-full border border-gray-200 text-xs px-2 py-1 ml-auto">4
                        posts</span>
                </a>
                <a href="https://themsaid.com/topic/go-lang" class="flex items-center mb-5 block">
                    <h3 class="text-sm md:text-md font-medium">GoLang</h3>
                    <span class="rounded-full border border-gray-200 text-xs px-2 py-1 ml-auto">1
                        posts</span>
                </a>
            </div>
        </div>
    </section>
    <!--End Blog section-->
</div>