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

        return view('livewire.frontend.post.index', compact('posts', 'tags'))->layout('layouts.front');
    }

    /**
     * @return LengthAwarePaginator<Post>
     */
    public function getPosts(?string $tag_slug = null): LengthAwarePaginator
    {
        $this->selectedTag = $tag_slug ?? $this->selectedTag;

        $query = Post::published()->with('tags.tagList')->latest();

        if ($this->selectedTag) {
            $query->whereHas('tags', function ($q) {
                $q->whereHas('tagList', function ($q) {
                    $q->where('slug', $this->selectedTag);
                });
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
