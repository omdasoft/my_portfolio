<?php

namespace App\Livewire\Frontend\Portfolio;

use Livewire\Component;

class Show extends Component
{
    public function render()
    {
        return view('livewire.frontend.portfolio.show')->layout('layouts.front');
    }
}
