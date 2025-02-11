<div>
    <x-slot:title>
        Posts List
    </x-slot:title>
    
    @section('header')
        <livewire:frontend.includes.blog-nav />
    @endsection
    
    <section class="md:flex" id="blog">
        <div class="md:w-2/3 md:mr-20 mb-20">
            <h1
                class="mb-5 md:mb-10 flex items-center after:ml-4 after:bg-gray-300 after:h-px after:w-1/2 after:grow uppercase text-xs font-medium">
                Content
            </h1>

            @foreach ($posts as $post)
                <x-post-summary :post="$post"/>
            @endforeach
            <x-pagination :collection="$posts"/>
        </div>
        
        @if ($tags)
            <div class="md:w-1/3">
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
                       <x-tag :tag="$tag"/>
                    @endforeach
                </div>
            </div>
        @endif
    </section>
</div>
