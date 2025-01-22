<div>
    <section class="md:flex" id="blog">
        <div class="w-full md:w-2/3 md:mr-20 mb-20">
            <h1
                class="mb-5 md:mb-10 flex items-center after:ml-4 after:bg-gray-300 after:h-px after:w-1/2 after:grow uppercase text-xs font-medium">
                Content
            </h1>

            @foreach ($posts as $post)
                <a href="{{ route('posts.show', $post->slug) }}"
                    class="mb-16 block">
                    <h2 class="font-bold text-xl md:text-3xl">{{ $post->title }}</h2>

                    <p class="mt-4 md:leading-7 md:text-lg">
                    {{ $post->short_content }}
                    </p>

                    <p class="mt-4 uppercase text-xs inline-flex space-x-2 font-medium text-gray-500">
                        <span>{{ $post->created_at }}</span>
                        <span
                            class="before:mr-2 before:bg-gray-400 before:w-[2px] before:h-[2px] before:rounded-full flex items-center">
                            {{ $post->reading_time }}
                        </span>
                    </p>
                </a>
            @endforeach
            <x-pagination :collection="$posts"/>
        </div>
        
        @if ($tags)
            <div class="w-full md:w-1/3">
                <h1 class="mb-5 md:mb-10 flex items-center after:ml-4 after:bg-gray-300 after:h-px after:w-1/2 after:grow uppercase text-xs font-medium">
                    Topics
                </h1>
                <div>
                    @if($selectedTag)
                        <button 
                            wire:click="resetFilter"
                            class="mb-4 text-sm text-blue-600 hover:text-blue-800"
                        >
                            ← Clear filter
                        </button>
                    @endif
                    
                    @foreach ($tags as $tag)
                        <a 
                            href="#" 
                            wire:click.prevent="getPosts('{{ $tag->tag_name }}')"
                            class="flex items-center mb-5 block {{ $selectedTag === $tag->tag_name ? 'text-blue-600' : '' }}"
                        >
                            <h3 class="text-sm md:text-md font-medium">{{ $tag->tag_name }}</h3>
                            <span class="rounded-full border border-gray-200 text-xs px-2 py-1 ml-auto">
                                {{ $tag->tags_count }} posts
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </section>
</div>
