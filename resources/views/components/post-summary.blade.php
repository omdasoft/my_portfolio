@props(['post'])
<a href="{{ route('posts.show', $post->slug) }}" class="mb-16 block text-gray-700">
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