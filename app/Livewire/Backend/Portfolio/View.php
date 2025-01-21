<?php

namespace App\Livewire\Backend\Portfolio;

use App\Models\Portfolio;
use Illuminate\Contracts\View\View as ViewView;
use Livewire\Component;

class View extends Component
{
    public Portfolio $portfolio;

    public function mount(int $id): void
    {
        $this->getPortfolio($id);
    }

    public function getPortfolio(int $id): void
    {
        $this->portfolio = Portfolio::with('images')->findOrFail($id);
    }

    public function render(): ViewView
    {
        return view('livewire.backend.portfolio.view')->layout('layouts.admin');
    }
}
