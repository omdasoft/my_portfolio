<div class="py-5">
    <div class="max-w-4xl mx-auto my-8 p-6">
        <div class="lg:max-w-[52rem] mx-auto mb-20">
            <h1 class="font-extrabold text-3xl md:text-5xl md:leading-snug -mt-3">{{ $post->title }}</h1>

            <p class="mt-5 uppercase text-xs inline-flex space-x-2 font-medium text-gray-500">
                <span>{{ $post->created_at }}</span>
                <span class="before:mr-2 before:bg-gray-400 before:w-[2px] before:h-[2px] before:rounded-full flex items-center">13 min read</span>
            </p>
        </div>
        
        <article class="mx-auto md:mb-44 prose text-black md:prose-lg">
            <p class="text-justify leading-10">{{ $post->content }}</p>
        </article>
    </div>
</div>
