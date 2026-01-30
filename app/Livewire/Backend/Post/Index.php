<?php

namespace App\Livewire\Backend\Post;

use App\Actions\Post\DeletePostAction;
use App\Models\Post;
use App\Traits\HasMediaUpload;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Livewire\WithPagination;

class Index extends Component
{
    use HasMediaUpload, WithPagination;

    public string $message = '';

    public int $actionId = -1;

    public function mount(): void {}

    public function render(): View
    {
        $posts = Post::with('image')->latest()->paginate(10);

        return view('livewire.backend.post.index', ['posts' => $posts])->layout('layouts.admin');
    }

    public function showConfirmationModal(int $id): void
    {
        $this->actionId = $id;
        $this->dispatch('open-modal', 'confirmationModal');
    }

    public function deleteConfirmed(): void
    {
        if ($this->actionId !== 0) {
            $deletePostAction = new DeletePostAction;
            $deletePostAction->handle($this->actionId);
            $this->actionId = -1;
        }

        $this->message = 'Post Deleted Successfully!';
        $this->dispatch('action-success');
        $this->closeModal('confirmationModal');
    }

    public function edit(int $id): Redirector|RedirectResponse
    {
        return redirect()->route('admin.posts.edit', ['id' => $id]);
    }

    public function view(int $id): Redirector|RedirectResponse
    {
        return redirect()->route('admin.posts.view', ['id' => $id]);
    }

    public function closeModal(string $modalName): void
    {
        $this->dispatch('close-modal', $modalName);
    }
}
