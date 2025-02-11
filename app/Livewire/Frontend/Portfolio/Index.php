<?php

namespace App\Livewire\Frontend\Portfolio;

use App\Models\Portfolio;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $portfolios = Portfolio::latest()->paginate(12);
        return view('livewire.frontend.portfolio.index', compact('portfolios'))->layout('layouts.front');
    }
}
