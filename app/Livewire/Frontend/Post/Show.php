<?php

namespace App\Livewire\Frontend\Post;

use App\Models\Post;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Show extends Component
{
    public Post $post;

    public function mount(string $slug): void
    {
        $post = Post::with('tags.tagList')->where('slug', $slug)->first();

        if (! $post) {
            abort(404);
        }

        $this->post = $post;
    }

    public function render(): View
    {
        return view('livewire.frontend.post.show')->layout('layouts.front');
    }
}
