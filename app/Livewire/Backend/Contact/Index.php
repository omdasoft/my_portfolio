<?php

namespace App\Livewire\Backend\Contact;

use App\Models\Contact;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Index extends Component
{
    public string $message = '';

    public function render(): View
    {
        $contacts = Contact::latest()->paginate(10);

        return view('livewire.backend.contact.index', ['contacts' => $contacts])->layout('layouts.admin');
    }
}
