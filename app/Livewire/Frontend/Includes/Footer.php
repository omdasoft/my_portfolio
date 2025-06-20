<?php

namespace App\Livewire\Frontend\Includes;

use App\Models\Profile;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Footer extends Component
{
    public function render(): View
    {
        $profile = Profile::first();

        return view('livewire.frontend.includes.footer', ['profile' => $profile]);
    }
}
