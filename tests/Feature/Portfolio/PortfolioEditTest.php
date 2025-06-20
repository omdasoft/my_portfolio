<?php

namespace Tests\Feature\Portfolio;

use App\Livewire\Backend\Portfolio\Edit;
use App\Models\Portfolio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PortfolioEditTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_portfolio_edit_component(): void
    {
        $portfolio = Portfolio::factory()->create();

        Livewire::test(Edit::class, ['id' => $portfolio->id])
            ->assertSet('title', $portfolio->title)
            ->assertSet('url', $portfolio->url)
            ->assertSet('github_url', $portfolio->github_url)
            ->assertSet('description', $portfolio->description);
    }

    public function test_can_validate_form(): void
    {
        $portfolio = Portfolio::factory()->create();

        Livewire::test(Edit::class, ['id' => $portfolio->id])
            ->set('title', '')
            ->set('description', '')
            ->set('url', '')
            ->set('github_url', '')
            ->call('update')
            ->assertHasErrors([
                'title',
                'description',
                'url',
                'github_url',
            ]);
    }

    public function test_can_update_portfolio(): void
    {
        $portfolio = Portfolio::factory()->create();

        Livewire::test(Edit::class, ['id' => $portfolio->id])
            ->set('title', 'updated title')
            ->set('description', 'updated description')
            ->set('url', 'https://website.com')
            ->set('github_url', 'https://website.com')
            ->call('update')
            ->assertDispatched('updated');

        $this->assertDatabaseHas('portfolios', [
            'title' => 'updated title',
            'description' => 'updated description',
            'url' => 'https://website.com',
            'github_url' => 'https://website.com',
        ]);
    }
}
