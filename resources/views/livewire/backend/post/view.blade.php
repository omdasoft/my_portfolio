<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post View') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-4xl mx-auto my-8 p-6 bg-white shadow-lg rounded-lg">
            <!-- Post Image -->
            <img src="{{ $post->image_path }}" alt="Post Image" class="w-full h-80 object-cover rounded-t-lg">

            <!-- Post Meta Information -->
            <div class="mt-4 flex justify-between items-center text-sm text-gray-600">
                <span class="text-gray-600 font-bold">
                    {{ $post->status }}
                </span>
                <span class="font-bold">
                    {{ $post->created_at }}
                </span>
            </div>

            <!-- Post Title -->
            <h1 class="mt-4 text-2xl font-bold text-gray-800">{{ $post->title }}</h1>

            <!-- Tags -->
            <div class="mt-2 flex flex-wrap gap-2">
                @foreach ($post->tags as $tag)
                    <span class="px-3 py-1 text-sm text-gray-600 bg-gray-200 rounded-full">
                        {{ $tag->tagList->name }}
                    </span>
                @endforeach
            </div>

            <!-- Post Content -->
            <div class="mt-4 text-gray-700 leading-relaxed">
                <p class="text-justify leading-10">
                    {!! $post->content !!}
                </p>
            </div>
        </div>
    </div>
</div>