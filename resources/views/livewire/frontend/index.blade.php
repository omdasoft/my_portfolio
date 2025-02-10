<div>

    <!--About section-->
    <x-about :profile="$profile"/>

    <!--Portfolios section-->
    @if($portfolios)
        <div class="mb-16">
            <x-portfolio-list :portfolios="$portfolios" name="Latest Work"/>
            <x-gray-button name="view all"/>
        </div>
    @endif


    <!--Latest post section-->
    @if ($latestPosts)
        <section class="md:flex" id="blog">
            <div class="md:w-2/3 md:mr-20 mb-20">
                <h1
                    class="mb-5 md:mb-10 flex items-center after:ml-4 after:bg-gray-300 after:h-px after:w-1/2 after:grow uppercase text-xs font-medium">
                    Content
                </h1>

                @foreach ($latestPosts as $post)
                    <a href="{{ route('posts.show', $post->slug) }}"
                        class="mb-16 block text-gray-700">
                        <h2 class="font-bold text-xl md:text-3xl">{{ $post->title }}</h2>

                        <p class="mt-4 md:leading-relaxed text-justify">
                            {!! $post->short_content !!}
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
                <div class="w-full flex justify-content-center">
                    <x-nav-link href="{{ route('posts.index') }}">
                        view all
                    </x-nav-link>
                </div>
            </div>
            
            @if ($tags)
                <div class="md:w-1/3">
                    <h1
                        class="mb-5 md:mb-10 flex items-center after:ml-4 after:bg-gray-300 after:h-px after:w-1/2 after:grow uppercase text-xs font-medium">
                        Topics
                    </h1>
                    <div>
                        @foreach ($tags as $tag)
                            <a href="{{ url('/posts/'.$tag->tag_slug) }}" class="flex items-center mb-5 block">
                                <h3 class="text-sm md:text-md font-medium">{{ $tag->tag_name }}</h3>
                                <span class="rounded-full border border-gray-200 text-xs px-2 py-1 ml-auto">
                                    {{ $tag->tags_count }}
                                    posts</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </section>
    @endif  
</div>