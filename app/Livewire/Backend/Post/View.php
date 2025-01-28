<?php

namespace App\Livewire\Backend\Post;

use App\Models\Post;
use Illuminate\Contracts\View\View as ViewView;
use Livewire\Component;

class View extends Component
{
    public Post $post;

    public function mount(int $id): void
    {
        $this->getPost($id);
    }

    public function getPost(int $id): void
    {
        $this->post = Post::with('tags.tagList')->findOrFail($id);
    }

    public function render(): ViewView
    {
        return view('livewire.backend.post.view')->layout('layouts.admin');
    }
}
