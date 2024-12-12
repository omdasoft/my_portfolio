<?php

namespace App\Livewire\Frontend;

use App\Models\Portfolio;
use App\Models\Profile;
use Livewire\Component;

class Index extends Component
{
    public function mount()
    {
    }

    public function render()
    {
        $profile = $this->getProfile();
        $portfolios = $this->getPortfolios();

        return view('livewire.frontend.index', compact('profile', 'portfolios'))->layout('layouts.front');
    }

    private function getProfile()
    {
        return Profile::first();
    }

    private function getPortfolios()
    {
        return Portfolio::latest()->paginate(3);
    }
}
