<div class="py-5">
    <x-slot:title>
        Portfolio Details
    </x-slot:title>

    @section('header')
        <livewire:frontend.includes.blog-nav />
    @endsection

    <div class="max-w-4xl mx-auto my-2 p-6">
        <div class="lg:max-w-[52rem] mx-auto mb-20">
            <!-- Use the Slider Component -->
            <livewire:image-slider :images="$portfolio->images" />

            <!-- Header Section -->
            <div class="mb-6">
                <h1 class="font-extrabold text-3xl md:text-5xl md:leading-snug -mt-3">
                    {{ $portfolio->title }}
                </h1>
                <!-- Rest of your existing header content -->
            </div>

            <!-- Article Content -->
            <article class="mx-auto md:mb-44 md:prose-lg text-gray-700 leading-9 text-justify">
                {{ $portfolio->description }}
            </article>
        </div>
    </div>
</div>
