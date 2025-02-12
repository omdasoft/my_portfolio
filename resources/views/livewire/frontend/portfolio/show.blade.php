<div class="py-5">
    <x-slot:title>
        Portfolio Details
    </x-slot:title>

    @section('header')
        <livewire:frontend.includes.blog-nav />
    @endsection
    
    <div class="max-w-4xl mx-auto my-2 p-6">
        <div class="lg:max-w-[52rem] mx-auto mb-20">
            <img src="{{ $portfolio->image }}" alt="Portfolio Image" class="w-full h-100 object-cover rounded-sm mb-6">

            <!-- Header Section -->
            <div class="mb-6">
                <h1 class="font-extrabold text-3xl md:text-5xl md:leading-snug -mt-3">
                    {{ $portfolio->title }}
                </h1>

                <!-- Metadata Row -->
                <p class="mt-4 uppercase text-sm inline-flex space-x-2 font-medium text-gray-500">
                    <span>
                        {{ $portfolio->created_at }}
                    </span>
                </p>

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

                <!-- Tags -->
                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach ($portfolio->tags as $tag)
                        <a href="{{ url('/posts/'.$tag->tagList->name) }}"
                           class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition duration-200">
                            #{{ $tag->tagList->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Article Content -->
            <article class="mx-auto md:mb-44 md:prose-lg text-gray-700 leading-9 text-justify">
                {{ $portfolio->description }}
            </article>
        </div>
    </div>
</div>