<?php

namespace App\Livewire\Backend;

use Livewire\Component;

class Portfolio extends Component
{
    public function render()
    {
        return view('livewire.backend.portfolio')->layout('layouts.admin');
    }
}
