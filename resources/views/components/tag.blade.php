@props(['tag'])
<a href="{{ url('/posts/'.$tag->tag_slug) }}" class="flex items-center mb-5 block">
    <h3 class="text-sm md:text-md font-medium">{{ $tag->tag_name }}</h3>
    <span class="rounded-full border border-gray-200 text-xs px-2 py-1 ml-auto">
        {{ $tag->tags_count }}
        posts
    </span>
</a>