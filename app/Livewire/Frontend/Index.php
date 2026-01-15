<?php

namespace App\Livewire\Frontend;

use App\Models\Contact;
use App\Models\Portfolio;
use App\Models\Post;
use App\Models\Profile;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;

class Index extends Component
{
    public bool $show = false;

    public string $name = '';

    public string $email = '';

    public string $description = '';

    public bool $isSent = false;

    public function render(): View
    {
        $profile = $this->getProfile();
        $portfolios = $this->getPortfolios();
        $tags = get_post_tags_with_count();
        $latestPosts = $this->getLatestPosts();

        return view('livewire.frontend.index', ['profile' => $profile, 'portfolios' => $portfolios, 'tags' => $tags, 'latestPosts' => $latestPosts])->layout('layouts.front');
    }

    private function getProfile(): ?Profile
    {
        return Profile::first();
    }

    /**
     * @return LengthAwarePaginator<int, Portfolio>
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

    public function showModal(): void
    {
        $this->resetForm();
        $this->show = true;
        $this->dispatch('open-modal', 'contact-me');
    }

    public function closeModal(): void
    {
        $this->show = false;
        $this->resetForm();
        $this->dispatch('close-modal', 'contact-me');
    }

    public function resetForm(): void
    {
        $this->reset(['name', 'email', 'description', 'isSent']);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function send(): void
    {
        $this->validate();

        $contact = new Contact;
        $contact->name = $this->name;
        $contact->email = $this->email;
        $contact->description = $this->description;
        $contact->ip_address = request()->ip();
        $contact->save();
        $this->isSent = true;
        $this->reset(['name', 'email', 'description']);
    }

    /**
     * @return array<string, string>
     */
    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email:rfc,dns|max:255',
            'description' => 'nullable|string',
        ];
    }
}
