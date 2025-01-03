<?php

namespace App\Livewire\Backend\Post;

use App\Actions\Post\DeletePostAction;
use App\Models\Post;
use App\Traits\HasMediaUpload;
use Livewire\Component;

class Index extends Component
{
    use HasMediaUpload;

    public string $message = '';

    public int $actionId = -1;

    public function mount()
    {
    }

    public function render()
    {
        $posts = Post::with('image', 'category')->latest()->paginate(10);

        return view('livewire.backend.post.index', compact('posts'))->layout('layouts.admin');
    }

    public function showConfirmationModal($id)
    {
        $this->actionId = $id;
        $this->dispatch('open-modal', 'confirmationModal');
    }

    public function deleteConfirmed()
    {
        if ($this->actionId) {
            $deletePostAction = new DeletePostAction();
            $deletePostAction->handle($this->actionId);
            $this->actionId = -1;
        }

        $this->message = 'Post Deleted Successfully!';
        $this->dispatch('action-success');
        $this->closeModal('confirmationModal');
    }

    public function edit(int $id)
    {
        return redirect()->route('admin.posts.edit', ['id' => $id]);
    }

    public function view(int $id)
    {
        return redirect()->route('admin.posts.view', ['id' => $id]);
    }

    public function closeModal($modalName)
    {
        $this->dispatch('close-modal', $modalName);
    }
}
