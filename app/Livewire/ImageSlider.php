<?php

namespace App\Livewire;

use App\Models\Image;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Component;

class ImageSlider extends Component
{
    /** @var Collection<int, Image> */
    public Collection $images;

    public int $currentSlide = 0;

    /**
     * @param  Collection<int, Image>  $images
     */
    public function mount(Collection $images): void
    {
        $this->images = $images;
    }

    public function next(): void
    {
        $this->currentSlide = $this->currentSlide < count($this->images) - 1
            ? $this->currentSlide + 1
            : 0;
    }

    public function prev(): void
    {
        $this->currentSlide = $this->currentSlide > 0
            ? $this->currentSlide - 1
            : count($this->images) - 1;
    }

    public function setSlide(int $index): void
    {
        $this->currentSlide = $index;
    }

    public function render(): View
    {
        return view('livewire.image-slider');
    }
}
