<?php

namespace App\Livewire\Frontend\Post;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithPagination;

    public $selectedTag = '';

    public function mount(Request $request)
    {
        $this->selectedTag = $request->tag ?? '';
    }

    public function render()
    {
        $posts = $this->getPosts();
        $tags = $this->getTagsWithCount();
        return view('livewire.frontend.post.index', compact('posts', 'tags'))->layout('layouts.front');
    }

    public function getPosts($tag_name = null)
    {
        $this->selectedTag = $tag_name ?? $this->selectedTag;
        
        $query = Post::with('tags')->latest();
        
        if ($this->selectedTag) {
            $query->whereHas('tags', function($q) {
                $q->where('tag_name', $this->selectedTag);
            });
        }
        
        return $query->paginate(10);
    }

    private function getTagsWithCount()
    {
        return DB::table('tags')
            ->selectRaw('tag_name, COUNT(*) as tags_count')
            ->groupBy('tag_name')
            ->get();
    }

    public function resetFilter()
    {
        $this->selectedTag = '';
        $this->resetPage();
    }
}
