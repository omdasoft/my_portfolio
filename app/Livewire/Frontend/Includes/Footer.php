<?php

namespace App\Livewire\Frontend\Includes;

use App\Models\Profile;
use Livewire\Component;

class Footer extends Component
{
    public function render()
    {
        $profile = Profile::first();

        return view('livewire.frontend.includes.footer', compact('profile'));
    }
}
