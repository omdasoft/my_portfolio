<?php

namespace Tests\Feature\Post;

use App\Enums\PostStatus;
use App\Livewire\Backend\Post\Create;
use App\Models\TagList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Mews\Purifier\Facades\Purifier;
use Tests\TestCase;

class PostCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_post_create_component(): void
    {
        Livewire::test(Create::class)
            ->assertSee('Title')
            ->assertSee('Content')
            ->assertSee('Status')
            ->assertSee('Image');
    }

    public function test_can_validate_form(): void
    {
        Livewire::test(Create::class)
            ->set('formData.title', '')
            ->set('formData.content', '')
            ->call('store')
            ->assertHasErrors(['formData.title', 'formData.content']);
    }

    public function test_can_create_post(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('photo1.jpg');

        // Create a test tag in the database first
        $tagList = TagList::create(['name' => 'Laravel']);

        Livewire::test(Create::class)
            ->set('formData.tags', [])
            ->set('tag', $tagList->id)
            ->call('addTag')
            ->set('formData.title', 'test title')
            ->set('formData.content', 'post content')
            ->set('formData.status', PostStatus::PUBLISHED->value)
            ->set('image', $file)
            ->call('store')
            ->assertDispatched('created');

        $this->assertDatabaseHas('posts', [
            'title' => 'test title',
            'content' => Purifier::clean('post content'),
            'status' => PostStatus::PUBLISHED->value,
        ]);

        $this->assertDatabaseHas('tags', ['tag_list_id' => $tagList->id]);
    }

    /** @test */
    public function test_can_add_and_remove_tag(): void
    {
        // Create a test tag in the database first
        $tagList = TagList::create(['name' => 'Laravel']);

        $component = Livewire::test(Create::class);

        // Verify initial state
        $component->assertSet('formData.tags', [])
            ->set('tag', $tagList->id)
            ->call('addTag')
            ->assertSet('formData.tags', [$tagList->id])
            ->call('removeTag', 0)
            ->assertSet('formData.tags', []);
    }

    public function test_can_upload_image(): void
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
