<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Portfolio View') }}
        </h2>
    </x-slot>
    
    <div class="py-5">
        <div class="max-w-4xl mx-auto my-8 p-6 bg-white shadow-lg rounded-lg">
            <!-- Portfolio Images -->
            <img src="{{ $portfolio->image }}" alt="Portfolio Image" class="w-full h-80 object-cover rounded-t-lg">

            <!-- Portfolio Title -->
            <h1 class="mt-4 text-2xl font-bold text-gray-800">{{ $portfolio->title }}</h1>

            <!-- Portfolio Metadata -->
            <p class="mt-4 uppercase text-sm inline-flex space-x-2 font-medium text-gray-500">
                <span>
                    {{ $portfolio->created_at }}
                </span>
            </p>

                <!-- Links -->
            <div class="mt-4 flex gap-2">
                <a 
                    href="{{ $portfolio->url }}"
                    type="button"
                    class="inline-block rounded border border-indigo-400 px-6 py-3 text-indigo-600 text-xs font-medium uppercase leading-normal shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:border-indigo-400 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] hover:bg-indigo-500 hover:text-white focus:border-indigo-400 focus:text-white focus:outline-none focus:ring-0 active:border-indigo-400 active:text-white"
                    data-te-ripple-init>
                    Visit Website
                </a>
                <a 
                    href="{{ $portfolio->github_url }}"
                    type="button"
                    class="inline-block rounded bg-indigo-500 px-6 py-3 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                    Github
                </a>
            </div>

            <!-- Post Content -->
            <div class="mt-10 text-gray-700 leading-relaxed">
                <p class="text-justify leading-10">
                {{ $portfolio->description }}
                </p>
            </div>
        </div>
    </div>
</div>