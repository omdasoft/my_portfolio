<?php

namespace App\Livewire\Frontend;

use App\Models\Portfolio;
use App\Models\Post;
use App\Models\Profile;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Index extends Component
{
    public function mount()
    {
    }

    public function render()
    {
        $profile = $this->getProfile();
        $portfolios = $this->getPortfolios();
        $tags = $this->getTagsWithCount();
        $latestPosts = $this->getLatestPosts();

        return view('livewire.frontend.index', compact('profile', 'portfolios', 'tags', 'latestPosts'))->layout('layouts.front');
    }

    private function getProfile()
    {
        return Profile::first();
    }

    private function getPortfolios()
    {
        return Portfolio::latest()->paginate(3);
    }

    private function getTagsWithCount()
    {
        return DB::table('tags')
            ->selectRaw('tag_name, COUNT(*) as tags_count')
            ->groupBy('tag_name')
            ->get();
    }

    private function getLatestPosts()
    {
        return Post::latest()->take(6)->get();
    }
}
