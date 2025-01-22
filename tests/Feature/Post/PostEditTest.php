<?php

namespace Tests\Feature\Post;

use App\Livewire\Backend\Post\Edit;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PostEditTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_post_edit_component()
    {
        $post = Post::factory()->create();
        Livewire::test(Edit::class, ['id' => $post->id])
            ->assertSet('formData.title', $post->title)
            ->assertSet('formData.content', $post->content);
    }

    public function test_can_validate_form()
    {
        $post = Post::factory()->create();

        Livewire::test(Edit::class, ['id' => $post->id])
            ->set('formData.title', '')
            ->set('formData.content', '')
            ->call('update')
            ->assertHasErrors(['formData.title', 'formData.content']);
    }

    public function test_can_update_post()
    {
        $post = Post::factory()->create();

        Livewire::test(Edit::class, ['id' => $post->id])
            ->set('formData.title', 'updated title')
            ->set('formData.content', 'updated content')
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
