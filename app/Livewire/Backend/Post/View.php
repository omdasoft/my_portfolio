<?php

namespace App\Livewire\Backend\Post;

use App\Models\Post;
use Illuminate\Support\Facades\View as FacadesView;
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
        $this->post = Post::findOrFail($id);
    }

    public function render(): FacadesView
    {
        return view('livewire.backend.post.view')->layout('layouts.admin');
    }
}
