<?php

namespace App\Livewire\Backend\Post;

use App\Actions\Post\CreatePostAction;
use App\Enums\PostStatus;
use App\Models\TagList;
use App\Traits\HasMediaUpload;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Create extends Component
{
    use HasMediaUpload;

    public ?object $image = null;

    public string $message = '';

    /**
     * @var string[]
     */
    public array $options = [];

    /**
     * @var string[]
     */
    public array $statuses = [];

    public string $tag = '';

    /**
     * @var array<string, mixed>
     */
    public array $formData;

    public array $tagLists;

    public function mount(): void
    {
        $this->formDataDefaultValues();
        $this->setPostStatus();
        $this->setTagLists();
    }

    public function formDataDefaultValues(): void
    {
        $this->formData = [
            'title' => '',
            'content' => '',
            'imagePath' => '',
            'tags' => [],
            'status' => PostStatus::PUBLISHED->value,
        ];
    }

    protected function setPostStatus(): void
    {
        $statuses = PostStatus::cases();

        foreach ($statuses as $status) {
            $this->statuses[$status->value] = $status->value;
        }
    }

    protected function setTagLists(): void
    {
        $this->tagLists = TagList::pluck('name', 'id')->toArray();
    }

    public function render(): View
    {
        return view('livewire.backend.post.create')->layout('layouts.admin');
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

        $this->uploadImage();
    }

    public function uploadImage(): void
    {
        $this->formData['imagePath'] = $this->upload($this->image, 'post');
    }

    public function removeImage(): void
    {
        if ($this->formData['imagePath']) {
            $this->removeUploadedFile($this->formData['imagePath']);
            $this->formData['imagePath'] = '';
            $this->image = null;
        }
    }

    public function store(): void
    {
        $this->validate();

        CreatePostAction::handle($this->formData);

        $this->message = 'Post Created Successfully!';

        $this->clearForm();

        $this->dispatch('created');
    }

    public function addTag(): void
    {
        $this->validate(['tag' => 'required|string|max:50']);

        if (! in_array($this->tag, $this->formData['tags'])) {
            $this->formData['tags'][] = $this->tag;
        }

        $this->tag = '';
    }

    public function removeTag(int $index): void
    {
        unset($this->formData['tags'][$index]);
        $this->formData['tags'] = array_values($this->formData['tags']);
    }

    public function clearForm(): void
    {
        $this->formDataDefaultValues();

        $this->reset([
            'image',
            'tag',
        ]);
    }

    /**
     * @return array<string, string>
     */
    protected function rules(): array
    {
        return [
            'formData.title' => 'required|min:6|max:255',
            'formData.content' => 'required|string',
            'formData.status' => 'required|string',
            'image' => [
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
            'formData.title.required' => 'Title is required',
            'formData.title.min' => 'Title must not be less than :min chars',
            'formData.title.max' => 'Title must not be greator than :max chars',
            'formData.content.required' => 'Content is required',
            'formData.content.string' => 'Content must be string',
            'image.required' => 'Image is required',
            'image.image' => 'Image must be an image',
            'image.max' => 'Image size must not be greator than :max',
            'image.mimes' => 'The allowed image types are :mimes',
        ];
    }
}
