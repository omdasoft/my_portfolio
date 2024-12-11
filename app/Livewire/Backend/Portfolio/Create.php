<?php

namespace App\Livewire\Backend\Portfolio;

use App\Models\Portfolio;
use App\Traits\HasMediaUpload;
use Livewire\Component;

class Create extends Component
{
    use HasMediaUpload;

    public string $title;

    public string $url;

    public string $github_url;

    public string $description;

    public $image;

    public array $imagePathes = [];

    public string $message = '';

    public int $maxFileSize = 1024 * 8;

    public function mount()
    {
    }

    public function render()
    {
        return view('livewire.backend.portfolio.create')->layout('layouts.admin');
    }

    public function updatedImage()
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

        $this->uploadImage();
    }

    public function uploadImage()
    {
        $path = $this->upload($this->image, 'portfolio');

        $this->addImagePath($path);
    }

    public function addImagePath(string $path)
    {
        array_push($this->imagePathes, $path);
    }

    public function removeImage(int $index)
    {
        $path = $this->imagePathes[$index];
        $this->removeUploadedFile($path);
        unset($this->imagePathes[$index]);
        $this->imagePathes = array_values($this->imagePathes);
    }

    public function store()
    {
        $this->validate();

        // Create portfolio
        $portfolio = new Portfolio();
        $portfolio->title = $this->title;
        $portfolio->url = $this->url;
        $portfolio->github_url = $this->github_url;
        $portfolio->description = $this->description;
        $portfolio->save();

        //Create portfolio images
        if ($this->imagePathes) {
            foreach ($this->imagePathes as $path) {
                $portfolio->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

        $this->imagePathes = [];
        $this->clearForm();
        $this->message = 'Portfolio Created Successfully!';
        $this->dispatch('created');
    }

    private function clearForm()
    {
        $this->reset([
            'title',
            'url',
            'github_url',
            'description',
            'image',
        ]);
    }

    // Update the rules method to include images validation
    protected function rules()
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

    // Update the messages method for custom validation messages
    protected function messages()
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
