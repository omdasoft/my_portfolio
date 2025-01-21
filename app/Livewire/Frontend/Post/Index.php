<?php

namespace App\Livewire\Frontend\Post;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
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
        $tags = $this->getTagsWithCount();

        return view('livewire.frontend.post.index', compact('posts', 'tags'))->layout('layouts.front');
    }

    /**
     * @param  string  $tag_name
     * @return LengthAwarePaginator<Post>
     */
    public function getPosts($tag_name = null): LengthAwarePaginator
    {
        $this->selectedTag = $tag_name ?? $this->selectedTag;

        $query = Post::with('tags')->latest();

        if ($this->selectedTag) {
            $query->whereHas('tags', function ($q) {
                $q->where('tag_name', $this->selectedTag);
            });
        }

        return $query->paginate(10);
    }

    /**
     * @return Collection<int, Tag>
     */
    private function getTagsWithCount(): Collection
    {
        return Tag::selectRaw('tag_name, COUNT(*) as tags_count')
            ->groupBy('tag_name')
            ->get();
    }

    public function resetFilter(): void
    {
        $this->selectedTag = '';
        $this->resetPage();
    }
}
