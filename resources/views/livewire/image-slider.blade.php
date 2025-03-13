<div
    x-data="{
        currentSlide: {{ $currentSlide }},
        totalSlides: {{ count($images) }}
    }"
    class="relative mb-6"
>
    <div class="overflow-hidden rounded-sm">
        <div class="flex transition-transform ease-out duration-500"
             x-bind:style="'transform: translateX(-' + (currentSlide * 100) + '%)'">
            @foreach($images as $image)
                <img src="{{ asset($image->image_path) }}"
                     alt="Slide Image"
                     class="w-full h-100 object-cover flex-shrink-0">
            @endforeach
        </div>
    </div>

    <!-- Navigation Buttons -->
    @if(count($images) > 1)
        <button
            class="absolute left-4 top-1/2 -translate-y-1/2 bg-indigo-500 bg-opacity-50 p-2 rounded-full text-white hover:bg-opacity-75"
            @click="currentSlide = currentSlide > 0 ? currentSlide - 1 : totalSlides - 1"
            wire:click="prev"
        >
            ←
        </button>
        <button
            class="absolute right-4 top-1/2 -translate-y-1/2 bg-indigo-500 bg-opacity-50 p-2 rounded-full text-white hover:bg-opacity-75"
            @click="currentSlide = currentSlide < totalSlides - 1 ? currentSlide + 1 : 0"
            wire:click="next"
        >
            →
        </button>

        <!-- Dots Navigation -->
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2">
            @foreach($images as $index => $image)
                <button
                    class="w-3 h-3 rounded-full"
                    :class="currentSlide === {{ $index }} ? 'bg-indigo-500' : 'bg-indigo-300'"
                    @click="currentSlide = {{ $index }}"
                    wire:click="setSlide({{ $index }})"
                ></button>
            @endforeach
        </div>
    @endif
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:load', function () {
            Alpine.start();
        });
    </script>
@endpush
