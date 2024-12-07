<?php

namespace App\Livewire\Backend\Portfolio;

use App\Models\Portfolio;
use Livewire\Component;

class View extends Component
{
    public Portfolio $portfolio;

    public function mount(int $id)
    {
        $this->getPortfolio($id);
    }

    public function getPortfolio(int $id)
    {
        $this->portfolio = Portfolio::with('images')->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.backend.portfolio.view')->layout('layouts.admin');
    }
}
