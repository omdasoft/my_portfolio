<?php

namespace Tests\Feature\Post;

use App\Livewire\Backend\Post\Edit;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class EditTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_post_edit_component()
    {
        $category = Category::factory()->create();
        $post = Post::factory()->create(['category_id' => $category->id]);
        Livewire::test(Edit::class, ['id' => $post->id])
            ->assertSet('formData.title', $post->title)
            ->assertSet('formData.content', $post->content)
            ->assertSet('formData.category', $post->category_id);
    }

    public function test_can_validate_form()
    {
        $category = Category::factory()->create();
        $post = Post::factory()->create(['category_id' => $category->id]);

        Livewire::test(Edit::class, ['id' => $post->id])
            ->set('formData.title', '')
            ->set('formData.content', '')
            ->set('formData.category', $category->id)
            ->call('update')
            ->assertHasErrors(['formData.title', 'formData.content']);
    }

    public function test_can_update_post()
    {
        $category = Category::factory()->create();
        $post = Post::factory()->create(['category_id' => $category->id]);

        Livewire::test(Edit::class, ['id' => $post->id])
            ->set('formData.title', 'updated title')
            ->set('formData.content', 'updated content')
            ->set('formData.category', $category->id)
            ->set('tag', 'NewTag')
            ->call('addTag')
            ->call('update')
            ->assertDispatched('updated')
            ->assertSet('message', 'Post Updated Successfully!');

        $this->assertDatabaseHas('posts', [
            'title' => 'updated title',
            'content' => 'updated content',
        ]);

        $this->assertDatabaseHas('tags', [
            'tag_name' => 'NewTag',
            'tagable_id' => $post->id,
        ]);
    }
}
