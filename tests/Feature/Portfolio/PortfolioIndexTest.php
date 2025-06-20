<?php

namespace Tests\Feature\Post;

use App\Livewire\Backend\Portfolio\Index;
use App\Models\Portfolio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PortfolioIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_portfolio_index(): void
    {
        Portfolio::factory()->count(5)->create();

        Livewire::test(Index::class)
            ->assertStatus(200);
    }

    public function test_can_list_portfolios(): void
    {
        Portfolio::factory()->count(5)->create();

        Livewire::test(Index::class)
            ->assertViewHas('portfolios', fn($portfolios): bool => count($portfolios) == 5);
    }

    public function test_can_delete_portfolio(): void
    {
        $portfolio = Portfolio::factory()->create();

        Livewire::test(Index::class)
            ->call('showConfirmationModal', $portfolio->id)
            ->call('deleteConfirmed')
            ->assertViewMissing($portfolio->title);

        $this->assertDatabaseMissing('portfolios', ['id' => $portfolio->id]);
    }

    public function test_can_redirect_to_edit_portfolio_component(): void
    {

        $portfolio = Portfolio::factory()->create();

        Livewire::test(Index::class)
            ->call('edit', $portfolio->id)
            ->assertRedirect(route('admin.portfolios.edit', $portfolio->id));
    }

    public function test_can_redirect_to_view_portfolio_component(): void
    {

        $portfolio = Portfolio::factory()->create();

        Livewire::test(Index::class)
            ->call('view', $portfolio->id)
            ->assertRedirect(route('admin.portfolios.view', $portfolio->id));
    }
}
