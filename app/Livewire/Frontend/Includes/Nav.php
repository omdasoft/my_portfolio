<?php

namespace App\Livewire\Frontend\Includes;

use App\Models\Contact;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Nav extends Component
{
    public bool $show = false;

    public string $name = '';

    public string $email = '';

    public string $description = '';

    public bool $isSent = false;

    public function render(): View
    {
        return view('livewire.frontend.includes.nav');
    }

    public function showModal(): void
    {
        $this->resetForm();
        $this->show = true;
        $this->dispatch('open-modal', 'contact-me');
    }

    public function closeModal(): void
    {
        $this->show = false;
        $this->resetForm();
        $this->dispatch('close-modal', 'contact-me');
    }

    public function resetForm(): void
    {
        $this->reset(['name', 'email', 'description', 'isSent']);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function send(): void
    {
        $this->validate();

        $contact = new Contact;
        $contact->name = $this->name;
        $contact->email = $this->email;
        $contact->description = $this->description;
        $contact->ip_address = request()->ip();
        $contact->save();
        $this->isSent = true;
        $this->reset(['name', 'email', 'description']);
    }

    /**
     * @return array<string, string>
     */
    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email:rfc,dns|max:255',
            'description' => 'nullable|string',
        ];
    }
}
