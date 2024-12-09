<?php

namespace Tests\Feature\Post;

use App\Livewire\Backend\Post\Index;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class IndexComponentTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_post_index_component_successfully()
    {
        Post::factory()->count(5)->create([
            'category_id' => Category::factory()->create(),
        ]);

        Livewire::test(Index::class)
            ->assertStatus(200);
    }

    public function test_can_display_posts()
    {
        Category::factory()
            ->has(Post::factory()->count(5))
            ->create();

        $firstPost = Post::first();

        Livewire::test(Index::class)
            ->assertSee($firstPost->title)
            ->assertViewHas('posts', function ($posts) {
                return count($posts) == 5;
            });
    }

    public function test_only_auth_user_can_display_dashboard()
    {
        $this->get('/admin/dashboard')
            ->assertStatus(302);
    }

    public function test_auth_user_can_display_dashboard()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/admin/dashboard')
            ->assertStatus(200);
    }

    public function test_can_delete_post()
    {
        Category::factory()
            ->has(Post::factory()->count(5))
            ->create();

        $post = Post::first();

        Livewire::test(Index::class)
            ->call('showConfirmationModal', $post->id)
            ->call('deleteConfirmed')
            ->assertViewMissing($post->title);

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function test_can_redirect_to_edit_post_component()
    {
        Category::factory()
            ->has(Post::factory()->count(5))
            ->create();

        $post = Post::first();

        Livewire::test(Index::class)
            ->call('edit', $post->id)
            ->assertRedirect(route('admin.posts.edit', $post->id));
    }

    public function test_can_redirect_to_view_post_component()
    {
        Category::factory()
            ->has(Post::factory()->count(5))
            ->create();

        $post = Post::first();

        Livewire::test(Index::class)
            ->call('view', $post->id)
            ->assertRedirect(route('admin.posts.view', $post->id));
    }
}
