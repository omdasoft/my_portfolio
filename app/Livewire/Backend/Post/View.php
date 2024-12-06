<?php

namespace App\Livewire\Backend\Post;

use App\Models\Post;
use Livewire\Component;

class View extends Component
{
    public Post $post;

    public function mount(int $id)
    {
        $this->getPost($id);
    }

    public function getPost(int $id)
    {
        $this->post = Post::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.backend.post.view')->layout('layouts.admin');
    }
}
