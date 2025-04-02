<?php

namespace App\Livewire\Frontend\Includes;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Nav extends Component
{
    public bool $show = false;

    public function render(): View
    {
        return view('livewire.frontend.includes.nav');
    }

    public function showModal(): void
    {
        $this->show = true;
        $this->dispatch('open-modal', 'contact-me');
    }

    public function closeModal(): void
    {
        $this->show = false;
        $this->dispatch('close-modal', 'contact-me');
    }
}
