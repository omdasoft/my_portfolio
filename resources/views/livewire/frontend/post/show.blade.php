<div class="py-5">
    <x-slot:title>
        Post Show
    </x-slot:title>

    @section('header')
        <livewire:frontend.includes.blog-nav />
    @endsection
    
    <div class="max-w-4xl mx-auto my-2 p-6">
        <div class="lg:max-w-[52rem] mx-auto mb-20">
            <img src="{{ $post->image_path }}" alt="Post Image" class="w-full h-80 object-cover rounded-sm mb-6">

            <!-- Header Section -->
            <div class="mb-6">
                <h1 class="font-extrabold text-3xl md:text-5xl md:leading-snug -mt-3">
                    {{ $post->title }}
                </h1>

                <!-- Metadata Row -->
                <div class="flex flex-wrap items-center gap-4 mt-4 text-sm text-gray-600">
                    <!-- Date -->
                    <time datetime="{{ $post->created_at }}" class="text-gray-500">
                        {{ $post->created_at }}
                    </time>

                    <!-- Reading Time -->
                    <span class="flex items-center text-gray-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $post->reading_time }}
                    </span>
                </div>

                <!-- Tags -->
                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach ($post->tags as $tag)
                        <a href="{{ url('/posts/'.$tag->tagList->name) }}"
                           class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition duration-200">
                            #{{ $tag->tagList->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Article Content -->
            <article class="mx-auto md:mb-44 md:prose-lg text-gray-700 leading-9 text-justify">
                {!! $post->content !!}
            </article>
        </div>
    </div>
</div>