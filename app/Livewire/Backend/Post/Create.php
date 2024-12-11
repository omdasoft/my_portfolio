<?php

namespace App\Livewire\Backend\Post;

use App\Actions\Post\CreatePostAction;
use App\Enums\PostStatus;
use App\Models\Category;
use App\Traits\HasMediaUpload;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Create extends Component
{
    use HasMediaUpload;

    public $image;

    public string $message = '';

    public array $options = [];

    public array $statuses = [];

    public string $tag = '';

    public array $formData;

    public function mount()
    {
        $this->getCategories();
        $this->formDataDefaultValues();
        $this->setPostStatus();
    }

    public function formDataDefaultValues()
    {
        $this->formData = [
            'title' => '',
            'content' => '',
            'imagePath' => '',
            'tags' => [],
            'category' => '',
            'status' => PostStatus::PUBLISHED->value,
        ];
    }

    public function setPostStatus()
    {
        $statuses = PostStatus::cases();

        foreach ($statuses as $status) {
            $this->statuses[$status->value] = $status->value;
        }
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

        $this->uploadImage();
    }

    public function uploadImage()
    {
        $this->formData['imagePath'] = $this->upload($this->image, 'post');
    }

    public function removeImage()
    {
        if ($this->formData['imagePath']) {
            $this->removeUploadedFile($this->formData['imagePath']);
            $this->formData['imagePath'] = '';
            $this->image = '';
        }
    }

    public function store()
    {
        $this->validate();

        CreatePostAction::handle($this->formData);

        $this->message = 'Post Created Successfully!';

        $this->clearForm();

        $this->dispatch('created');
    }

    public function addTag()
    {
        $this->validate(['tag' => 'required|string|max:50']);

        if (! in_array($this->tag, $this->formData['tags'])) {
            $this->formData['tags'][] = $this->tag;
        }

        $this->tag = '';
    }

    public function removeTag($index)
    {
        unset($this->formData['tags'][$index]);
        $this->formData['tags'] = array_values($this->formData['tags']);
    }

    public function clearForm()
    {
        $this->formDataDefaultValues();

        $this->reset([
            'image',
            'tag',
        ]);
    }

    protected function rules()
    {
        return [
            'formData.title' => 'required|min:6|max:255',
            'formData.content' => 'required|string',
            'formData.category' => 'required|numeric|exists:categories,id',
            'formData.status' => 'required|string',
            'image' => [
                'required',
                'image',
                'max:5120', // 5MB max file size
                'mimes:jpeg,jpg,webp,png,gif',
            ],
        ];
    }

    protected function messages()
    {
        return [
            'formData.title.required' => 'Title is required',
            'formData.title.min' => 'Title must not be less than :min chars',
            'formData.title.max' => 'Title must not be greator than :max chars',
            'formData.content.required' => 'Content is required',
            'formData.content.string' => 'Content must be string',
            'formData.category.required' => 'Category is required',
            'formData.category.numeric' => 'Category must be number',
            'formData.category.exists' => 'Category value not found',
            'image.required' => 'Image is required',
            'image.image' => 'Image must be an image',
            'image.max' => 'Image size must not be greator than :max',
            'image.mimes' => 'The allowed image types are :mimes',
        ];
    }
}
