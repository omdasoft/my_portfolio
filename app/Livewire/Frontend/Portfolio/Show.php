<?php

namespace App\Livewire\Frontend\Portfolio;

use App\Models\Portfolio;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Show extends Component
{
    public string $slug;

    public function mount(string $slug): void
    {
        $this->slug = $slug;
    }

    public function render(): View
    {
        $portfolio = Portfolio::with(['images', 'tags'])->where('slug', $this->slug)->first();

        return view('livewire.frontend.portfolio.show', ['portfolio' => $portfolio])->layout('layouts.front');
    }
}
