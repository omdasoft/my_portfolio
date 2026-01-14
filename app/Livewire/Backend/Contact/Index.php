<?php

namespace App\Livewire\Backend\Contact;

use App\Models\Contact;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class Index extends Component
{
    public string $message = '';

    public int $actionId;

    public function render(): View
    {
        $contacts = Contact::latest()->paginate(10);

        return view('livewire.backend.contact.index', ['contacts' => $contacts])->layout('layouts.admin');
    }

    public function showConfirmationModal(int $id): void
    {
        $this->actionId = $id;
        $this->dispatch('open-modal', 'confirmationModal');
    }

    public function deleteConfirmed(): void
    {
        if ($this->actionId !== 0) {
            Contact::findOrFail($this->actionId)->delete();
            $this->actionId = -1;
        }

        $this->message = 'Contact Deleted Successfully!';
        $this->dispatch('action-success');
        $this->closeModal('confirmationModal');
    }

    public function closeModal(string $modalName): void
    {
        $this->dispatch('close-modal', $modalName);
    }

    public function view(int $id): Redirector|RedirectResponse
    {
        return redirect()->to(route('admin.contacts.view', ['id' => $id]));
    }
}
