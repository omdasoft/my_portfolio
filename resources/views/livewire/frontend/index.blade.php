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
                    <x-post-summary :post="$post"/>
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
                           <x-tag :tag="$tag"/>
                        @endforeach
                    </div>
                </div>
            @endif
        </section>
    @endif  
</div>