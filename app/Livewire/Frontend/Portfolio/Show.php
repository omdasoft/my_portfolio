<?php

namespace App\Livewire\Frontend\Portfolio;

use App\Models\Portfolio;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Show extends Component
{
    public int $id;

    public function mount(int $id): void
    {
        $this->id = $id;
    }

    public function render(): View
    {
        $portfolio = Portfolio::with(['images', 'tags'])->find($this->id);

        return view('livewire.frontend.portfolio.show', compact('portfolio'))->layout('layouts.front');
    }
}
