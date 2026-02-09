<?php

namespace App\Livewire\Frontend;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class NotFound extends Component
{
    public function render(): View
    {
        return view('livewire.frontend.not-found')->layout('layouts.front');
    }
}
