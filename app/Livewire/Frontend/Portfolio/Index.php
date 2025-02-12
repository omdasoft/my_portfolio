<?php

namespace App\Livewire\Frontend\Portfolio;

use App\Models\Portfolio;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Index extends Component
{
    public function render(): View
    {
        $portfolios = Portfolio::latest()->paginate(12);

        return view('livewire.frontend.portfolio.index', compact('portfolios'))->layout('layouts.front');
    }
}
