<?php

namespace App\Livewire\Backend\Post;

use App\Actions\Post\EditPostAction;
use App\Enums\PostStatus;
use App\Models\Category;
use App\Models\Image;
use App\Models\Post;
use App\Models\Tag;
use App\Traits\HasMediaUpload;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class Edit extends Component
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

    public Post $post;

    /**
     * @var array<string, mixed>
     */
    public array $formData = [];

    public function mount(int $id): void
    {
        $this->getCategories();
        $this->getPost($id);
        $this->setPostStatus();
    }

    public function getPost(int $id): void
    {
        $this->post = Post::with('image', 'category', 'tags')->findOrFail($id);
        $this->setFormData($this->post);
    }

    public function setFormData(Post $post): void
    {
        $this->formData = [
            'title' => $post->title,
            'content' => $post->content,
            'category' => $post->category_id,
            'imagePath' => $post->image_path,
            'status' => $post->status,
            'tags' => [],
        ];
    }

    public function setPostStatus(): void
    {
        $statuses = PostStatus::cases();

        foreach ($statuses as $status) {
            $this->statuses[$status->value] = $status->value;
        }
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

    public function getCategories(): void
    {
        $categories = Category::orderBy('category_name', 'asc')->get(['id', 'category_name']);
        $this->setOptions($categories);
    }

    /**
     * @param  Collection<int, Category>  $categories
     */
    public function setOptions(Collection $categories): void
    {
        $this->options = $categories->pluck('category_name', 'id')->toArray();
    }

    public function render(): View
    {
        return view('livewire.backend.post.edit')->layout('layouts.admin');
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

    public function update(): void
    {
        $this->validate();

        $this->formData['hasImage'] = $this->image ? true : false;

        $editAction = new EditPostAction();

        $editAction->handle($this->post, $this->formData);

        $this->image = null;
        $this->formData['tags'] = [];
        $this->tag = '';
        $this->message = 'Post Updated Successfully!';
        $this->dispatch('updated');
        $this->dispatch('refresh-component');
    }

    #[On('refresh-component')]
    public function refreshComponent(): void
    {
        $this->dispatch('$refresh');
    }

    public function deleteImage(int $id): void
    {
        Image::findOrFail($id)->delete();
        $this->message = 'Post Image Deleted Successfully!';
        $this->dispatch('updated');
    }

    public function deleteTag(int $id): void
    {
        Tag::findOrFail($id)->delete();
        $this->message = 'Post Tag Deleted Successfully!';
        $this->dispatch('updated');
    }

    /**
     * @return array<string, string>
     */
    protected function rules(): array
    {
        return [
            'formData.title' => 'required|min:6|max:255',
            'formData.content' => 'required|string',
            'formData.category' => 'required|numeric|exists:categories,id',
            'formData.status' => 'required|string',
            'image' => [
                'nullable',
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
            'formData.category.required' => 'Category is required',
            'formData.category.numeric' => 'Category must be number',
            'formData.category.exists' => 'Category value not found',
            'image.image' => 'Image must be an image',
            'image.max' => 'Image size must not be greator than :max',
            'image.mimes' => 'The allowed image types are :values',
        ];
    }
}
