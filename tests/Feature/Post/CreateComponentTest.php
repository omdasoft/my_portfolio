<?php

namespace Tests\Feature\Post;

use App\Enums\PostStatus;
use App\Livewire\Backend\Post\Create;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CreateComponentTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_post_create_component()
    {
        Livewire::test(Create::class)
            ->assertSee('Title')
            ->assertSee('Content')
            ->assertSee('Category')
            ->assertSee('Status')
            ->assertSee('Image');
    }

    public function test_can_validate_form()
    {
        $category = Category::factory()->create();

        Livewire::test(Create::class)
            ->set('formData.title', '')
            ->set('formData.content', '')
            ->set('formData.category', $category->id)
            ->call('store')
            ->assertHasErrors(['formData.title', 'formData.content']);
    }

    public function test_can_create_post()
    {
        $category = Category::factory()->create();

        Livewire::test(Create::class)
            ->set('formData.title', 'Test Post')
            ->set('formData.content', 'This is a test post content.')
            ->set('formData.category', $category->id)
            ->set('formData.status', PostStatus::PUBLISHED->value)
            ->call('store')
            ->assertStatus(200);
    }

    public function test_can_add_and_remove_tag()
    {
        Livewire::test(Create::class)
            ->set('tag', 'Laravel')
            ->call('addTag')
            ->assertSet('formData.tags', ['Laravel'])
            ->call('removeTag', 0)
            ->assertSet('formData.tags', []);
    }
}
