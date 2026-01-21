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

    public string $name = '';

    public function render(): View
    {
        $list = TagList::where('name', 'like', '%'.$this->search.'%')->orderBy('name', 'asc')->paginate(10);

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
        $this->resetErrorBag();
        $this->dispatch('close-modal', $modalName);
    }

    public function showCreateModal(): void
    {
        $this->reset('name');
        $this->dispatch('open-modal', 'createModal');
    }

    public function storeTag(): void
    {
        $this->validate([
            'name' => 'required|max:255|unique:tag_lists,name',
        ]);

        TagList::create([
            'name' => $this->name,
        ]);

        $this->message = 'Tag Created Successfully!';
        $this->dispatch('action-success');
        $this->closeModal('createModal');
    }

    public function showEditModal(int $id): void
    {
        $this->reset('name');
        $this->actionId = $id;
        $tag = TagList::findOrFail($id);
        $this->name = $tag->name;
        $this->dispatch('open-modal', 'updateModal');
    }

    public function updateTag(): void
    {
        $this->validate([
            'name' => 'required|max:255|unique:tag_lists,name,' . $this->actionId,
        ]);

        $tag = TagList::findOrFail($this->actionId);
        $tag->update([
            'name' => $this->name,
        ]);

        $this->message = 'Tag Updated Successfully!';
        $this->dispatch('action-success');
        $this->closeModal('updateModal');
    }
}
