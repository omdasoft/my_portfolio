<?php

namespace Tests\Feature\Post;

use App\Livewire\Backend\Post\Edit;
use App\Models\Post;
use App\Models\TagList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Mews\Purifier\Facades\Purifier;
use Tests\TestCase;

class PostEditTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_post_edit_component(): void
    {
        $post = Post::factory()->create();
        Livewire::test(Edit::class, ['id' => $post->id])
            ->assertSet('formData.title', $post->title)
            ->assertSet('formData.content', $post->content);
    }

    public function test_can_validate_form(): void
    {
        $post = Post::factory()->create();

        Livewire::test(Edit::class, ['id' => $post->id])
            ->set('formData.title', '')
            ->set('formData.content', '')
            ->call('update')
            ->assertHasErrors(['formData.title', 'formData.content']);
    }

    public function test_can_update_post(): void
    {
        $post = Post::factory()->create();

        // Create a test tag in the database first
        $tagList = TagList::create(['name' => 'Laravel']);

        Livewire::test(Edit::class, ['id' => $post->id])
            ->set('formData.title', 'updated title')
            ->set('formData.content', 'updated content')
            ->set('tag', $tagList->id)
            ->call('addTag')
            ->call('update')
            ->assertDispatched('updated')
            ->assertSet('message', 'Post Updated Successfully!');

        $this->assertDatabaseHas('posts', [
            'title' => 'updated title',
            'content' => Purifier::clean('updated content'),
        ]);

        $this->assertDatabaseHas('tags', [
            'tag_list_id' => $tagList->id,
            'tagable_id' => $post->id,
        ]);
    }
}
