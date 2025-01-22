<?php

namespace App\Livewire\Frontend;

use App\Models\Portfolio;
use App\Models\Post;
use App\Models\Profile;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;

class Index extends Component
{
    public function render(): View
    {
        $profile = $this->getProfile();
        $portfolios = $this->getPortfolios();
        $tags = get_tags_with_count('post');
        $latestPosts = $this->getLatestPosts();

        return view('livewire.frontend.index', compact('profile', 'portfolios', 'tags', 'latestPosts'))->layout('layouts.front');
    }

    private function getProfile(): ?Profile
    {
        return Profile::first();
    }

    /**
     * @return LengthAwarePaginator<Portfolio>
     */
    private function getPortfolios(): LengthAwarePaginator
    {
        return Portfolio::latest()->paginate(3);
    }

    /**
     * @return Collection<int, Post>
     */
    private function getLatestPosts(): Collection
    {
        return Post::published()->latest()->take(6)->get();
    }
}
