<?php

namespace Tests\Feature\Post;

use App\Livewire\Backend\Portfolio\Create;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class PortfolioCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_portfolio_create_component()
    {
        Livewire::test(Create::class)
            ->assertSee('Title')
            ->assertSee('URL')
            ->assertSee('Description')
            ->assertSee('Github UR')
            ->assertSee('Image');
    }

    public function test_can_validate_form()
    {
        Livewire::test(Create::class)
            ->set('title', '')
            ->set('url', '')
            ->set('github_url', '')
            ->set('description', '')
            ->call('store')
            ->assertHasErrors([
                'title',
                'url',
                'github_url',
                'description',
            ]);
    }

    public function test_can_create_portfolio()
    {
        Livewire::test(Create::class)
            ->set('title', 'Test title')
            ->set('description', 'Test portfolio description')
            ->set('url', 'https://test.com')
            ->set('github_url', 'https://test.com')
            ->call('store')
            ->assertDispatched('created');

        $this->assertDatabaseHas('portfolios', [
            'title' => 'Test title',
            'description' => 'Test portfolio description',
            'url' => 'https://test.com',
            'github_url' => 'https://test.com',
        ]);
    }

    public function test_can_upload_portfolio_images()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('photo1.jpg');

        $component = Livewire::test(Create::class);

        $component
            ->set('image', $file)
            ->set('imagePathes', [])
            ->call('uploadImage');

        $generatedPaths = $component->get('imagePathes');

        $this->assertNotEmpty($generatedPaths);
        $this->assertTrue(Str::startsWith($generatedPaths[0], 'uploads/portfolio/'));
        $this->assertTrue(Str::endsWith($generatedPaths[0], '.jpg'));

        Storage::disk('public')->assertExists($generatedPaths[0]);
    }
}
