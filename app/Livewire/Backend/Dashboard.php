<?php

namespace App\Livewire\Backend;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Dashboard extends Component
{
    public function render(): View
    {
        return view('livewire.backend.dashboard')->layout('layouts.admin');
    }
}
