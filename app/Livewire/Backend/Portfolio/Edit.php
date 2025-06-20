<?php

namespace App\Livewire\Backend\Portfolio;

use App\Models\Image;
use App\Models\Portfolio;
use App\Traits\HasMediaUpload;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Edit extends Component
{
    use HasMediaUpload;

    public string $title;

    public string $url;

    public string $github_url;

    public string $description;

    public ?object $image = null;

    /**
     * @var string[]
     */
    public array $imagePathes = [];

    public string $message = '';

    public int $maxFileSize = 1024 * 8;

    public Portfolio $portfolio;

    public function mount(int $id): void
    {
        $this->getPortfolio($id);
    }

    private function getPortfolio(int $id): void
    {
        $portfolio = Portfolio::with('images')->findOrFail($id);
        $this->title = $portfolio->title;
        $this->description = $portfolio->description;
        $this->url = $portfolio->url;
        $this->github_url = $portfolio->github_url;
        $this->portfolio = $portfolio;
    }

    public function render(): View
    {
        return view('livewire.backend.portfolio.edit')->layout('layouts.admin');
    }

    public function updatedImage(): void
    {
        $this->validate([
            'image' => [
                'image',
                'max:5120', // 5MB max file size
                'mimes:jpeg,jpg,webp,png,gif',
            ],
        ], [
            'image.image' => 'The file must be an image.',
            'image.max' => 'Image size should not exceed 5MB.',
            'image.mimes' => 'The image must be one of these types: jpeg, jpg, webp, png, gif.',
        ]);

        $path = $this->upload($this->image, 'portfolio');
        $this->addImagePath($path);
    }

    public function addImagePath(string $path): void
    {
        $this->imagePathes[] = $path;
    }

    public function removeImage(int $index): void
    {
        $path = $this->imagePathes[$index];
        $this->removeUploadedFile($path);
        unset($this->imagePathes[$index]);
        $this->imagePathes = array_values($this->imagePathes);
    }

    public function update(): void
    {
        $this->validate();

        // Edit portfolio
        $this->portfolio->title = $this->title;
        $this->portfolio->url = $this->url;
        $this->portfolio->github_url = $this->github_url;
        $this->portfolio->description = $this->description;
        $this->portfolio->save();

        // Create portfolio images
        foreach ($this->imagePathes as $path) {
            $this->portfolio->images()->create([
                'image_path' => $path,
            ]);
        }

        $this->imagePathes = [];
        $this->message = 'Portfolio Updated Successfully!';
        $this->dispatch('updated');
    }

    public function deleteImage(int $id): void
    {
        Image::findOrFail($id)->delete();
        $this->message = 'Portfolio Image Deleted Successfully!';
        $this->dispatch('updated');
    }

    /**
     * @return array<string, string>
     */
    protected function rules(): array
    {
        return [
            'title' => 'required|min:6',
            'url' => 'required|url',
            'github_url' => 'required|url',
            'description' => 'required|string',
            'image.*' => [
                'required',
                'image',
                'max:5120', // 5MB max file size
                'mimes:jpeg,jpg,webp,png,gif',
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function messages(): array
    {
        return [
            'title.required' => 'The title is required.',
            'title.min' => 'The title must be at least 6 characters.',
            'url.required' => 'The project URL is required.',
            'url.url' => 'Please provide a valid URL.',
            'github_url.required' => 'The GitHub URL is required.',
            'github_url.url' => 'Please provide a valid GitHub URL.',
            'description.required' => 'The description is required.',
            'image.required' => 'The Image is required.',
            'image.image' => 'The file must be an image.',
            'image.max' => 'Image size should not exceed 5MB.',
            'image.mimes' => 'The image must be one of these types: jpeg, jpg, webp, png, gif.',
        ];
    }
}
