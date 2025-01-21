<?php

namespace App\Livewire\Frontend\Post;

use App\Models\Post;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Show extends Component
{
    protected string $slug;

    public function mount(string $slug): void
    {   
        $this->slug = $slug;
    }

    public function render(): View
    {
        $post = $this->getPost();
        return view('livewire.frontend.post.show', compact('post'))->layout('layouts.blog');
    }

    private function getPost()
    {
        $post = Post::with('tags')->where('slug', $this->slug)->first();

        if (! $post) abort(404);

        return $post;
    }
}
