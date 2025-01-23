<?php

namespace App\Livewire\Frontend\Post;

use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $selectedTag = '';

    public function mount(Request $request): void
    {
        $this->selectedTag = $request->tag ?? '';
    }

    public function render(): View
    {
        $posts = $this->getPosts();
        $tags = get_post_tags_with_count();

        return view('livewire.frontend.post.index', compact('posts', 'tags'))->layout('layouts.blog');
    }

    /**
     * @param  string  $tag_name
     * @return LengthAwarePaginator<Post>
     */
    public function getPosts($tag_name = null): LengthAwarePaginator
    {
        $this->selectedTag = $tag_name ?? $this->selectedTag;

        $query = Post::published()->with('tags')->latest();

        if ($this->selectedTag) {
            $query->whereHas('tags', function ($q) {
                $q->where('tag_name', $this->selectedTag);
            });
        }

        return $query->paginate(10);
    }

    public function resetFilter(): void
    {
        $this->selectedTag = '';
        $this->resetPage();
    }
}
