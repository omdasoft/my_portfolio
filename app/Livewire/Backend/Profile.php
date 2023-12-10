<?php

namespace App\Livewire\Backend;

use Livewire\Component;

class Profile extends Component
{
    public function render()
    {
        return view('livewire.backend.profile')->layout('layouts.admin');
    }
}
