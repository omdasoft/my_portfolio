<?php

namespace App\Livewire\Backend\TagList;

use App\Models\TagList;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Index extends Component
{
    public string $message = '';

    public int $actionId;

    public string $search = '';

    public function render(): View
    {
        $list = TagList::where('name', 'like', '%'.$this->search.'%')->paginate(10);

        return view('livewire.backend.tag-list.index', ['list' => $list])->layout('layouts.admin');
    }

    public function showConfirmationModal(int $id): void
    {
        $this->actionId = $id;
        $this->dispatch('open-modal', 'confirmationModal');
    }

    public function deleteConfirmed(): void
    {
        if ($this->actionId !== 0) {
            TagList::findOrFail($this->actionId)->delete();
            $this->actionId = -1;
        }

        $this->message = 'Tag Deleted Successfully!';
        $this->dispatch('action-success');
        $this->closeModal('confirmationModal');
    }

    public function closeModal(string $modalName): void
    {
        $this->dispatch('close-modal', $modalName);
    }
}
