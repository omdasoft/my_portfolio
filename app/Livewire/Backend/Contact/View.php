<?php

namespace App\Livewire\Backend\Contact;

use App\Models\Contact;
use Livewire\Component;

class View extends Component
{
    public Contact $contact;

    public function mount(int $id): void
    {
        $this->getContact($id);
    }

    public function getContact(int $id): void
    {
        $this->contact = Contact::findOrFail($id);
    }

    public function render(): View
    {
        return view('livewire.backend.contact.view')->layout('layouts.admin');
    }
}
