<?php

namespace Tests\Feature\Post;

use App\Enums\PostStatus;
use App\Livewire\Backend\Post\Create;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class PostCreateTest extends TestCase
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
        Storage::fake('public');

        $file = UploadedFile::fake()->image('photo1.jpg');

        $category = Category::factory()->create();

        Livewire::test(Create::class)
            ->set('formData.tags', [])
            ->set('tag', 'Laravel')
            ->call('addTag')
            ->set('formData.title', 'test title')
            ->set('formData.content', 'post content')
            ->set('formData.category', $category->id)
            ->set('formData.status', PostStatus::PUBLISHED->value)
            ->set('image', $file)
            ->call('store')
            ->assertDispatched('created');

        $this->assertDatabaseHas('posts', [
            'title' => 'test title',
            'content' => 'post content',
            'category_id' => $category->id,
            'status' => PostStatus::PUBLISHED->value,
        ]);

        $this->assertDatabaseHas('tags', ['tag_name' => 'Laravel']);
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

    public function test_can_upload_image()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('photo1.jpg');

        $component = Livewire::test(Create::class);
        $component->set('image', $file)
            ->set('formData.imagePath', '')
            ->call('uploadImage');

        $generatedPath = $component->get('formData.imagePath');

        $this->assertNotEmpty($generatedPath);
        $this->assertTrue(Str::startsWith($generatedPath, 'uploads/post/'));
        $this->assertTrue(Str::endsWith($generatedPath, '.jpg'));

        Storage::disk('public')->assertExists($generatedPath);
    }
}
