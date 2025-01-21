<?php

namespace App\Livewire\Backend;

use Illuminate\Support\Facades\View;
use Livewire\Component;

class Profile extends Component
{
    public function render(): View
    {
        return view('livewire.backend.profile')->layout('layouts.admin');
    }
}
