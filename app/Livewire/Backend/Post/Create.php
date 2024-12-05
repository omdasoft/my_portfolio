<?php

namespace App\Livewire\Backend\Post;

use App\Models\Category;
use App\Models\Post;
use App\Traits\HasMediaUpload;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Create extends Component
{
    use HasMediaUpload;

    public string $title;

    public string $content;

    public $image;

    public string $imagePath;

    public string $message = '';

    public array $options = [];

    public int $category;

    public function mount()
    {
        $this->getCategories();
    }

    public function getCategories()
    {
        $categories = Category::orderBy('category_name', 'asc')->get(['id', 'category_name']);
        $this->setOptions($categories);
    }

    public function setOptions(Collection $categories)
    {
        $this->options = $categories->pluck('category_name', 'id')->toArray();
    }

    public function render()
    {
        return view('livewire.backend.post.create')->layout('layouts.admin');
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

        $this->imagePath = $this->upload($this->image, 'post');
    }

    public function removeImage()
    {
        if ($this->imagePath) {
            $this->removeUploadedImage($this->imagePath);
            $this->imagePath = '';
            $this->image = '';
        }
    }

    public function store()
    {
        $this->validate();

        $post = new Post();
        $post->title = $this->title;
        $post->content = $this->content;
        $post->category_id = $this->category;
        $post->save();

        if ($this->imagePath) {
            $post->image()->create([
                'image_path' => $this->imagePath,
            ]);
        }

        $this->clearForm();
        $this->message = 'Post Created Successfully!';
        $this->dispatch('created');
    }

    public function clearForm()
    {
        $this->reset([
            'title',
            'content',
            'category',
            'image',
            'imagePath',
        ]);
    }

    protected function rules()
    {
        return [
            'title' => 'required|min:6|max:255',
            'content' => 'required|string',
            'category' => 'required|numeric|exists:categories,id',
            'image.*' => [
                'required',
                'image',
                'max:5120', // 5MB max file size
                'mimes:jpeg,jpg,webp,png,gif',
            ],
        ];
    }
}
