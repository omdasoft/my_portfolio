<?php

namespace App\Livewire\Backend\Post;

use App\Actions\Post\EditPostAction;
use App\Models\Category;
use App\Models\Image;
use App\Models\Post;
use App\Models\Tag;
use App\Traits\HasMediaUpload;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class Edit extends Component
{
    use HasMediaUpload;

    public $image;

    public string $message = '';

    public array $options = [];

    public string $tag = '';

    public Post $post;

    public $formData = [];

    public function mount(int $id)
    {
        $this->getCategories();
        $this->getPost($id);
    }

    public function getPost(int $id)
    {
        $this->post = Post::with('image', 'category', 'tags')->findOrFail($id);
        $this->setFormData($this->post);
    }

    public function setFormData(Post $post)
    {
        $this->formData = [
            'title' => $post->title,
            'content' => $post->content,
            'category' => $post->category_id,
            'imagePath' => $post->image_path,
            'tags' => [],
        ];
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
        return view('livewire.backend.post.edit')->layout('layouts.admin');
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

        $this->formData['imagePath'] = $this->upload($this->image, 'post');
    }

    public function removeImage()
    {
        if ($this->formData['imagePath']) {
            $this->removeUploadedImage($this->formData['imagePath']);
            $this->formData['imagePath'] = '';
            $this->image = '';
        }
    }

    public function update()
    {
        $this->validate();

        $this->formData['hasImage'] = $this->image ? true : false;

        EditPostAction::handle($this->post, $this->formData);

        $this->image = '';
        $this->formData['tags'] = [];
        $this->tag = '';
        $this->message = 'Post Updated Successfully!';
        $this->dispatch('updated');
        $this->dispatch('refresh-component');
    }

    #[On('refresh-component')]
    public function refreshComponent()
    {
        $this->dispatch('$refresh');
    }

    public function deleteImage(int $id)
    {
        Image::findOrFail($id)->delete();
        $this->message = 'Post Image Deleted Successfully!';
        $this->dispatch('updated');
    }

    public function deleteTag(int $id)
    {
        Tag::findOrFail($id)->delete();
        $this->message = 'Post Tag Deleted Successfully!';
        $this->dispatch('updated');
    }

    protected function rules()
    {
        return [
            'formData.title' => 'required|min:6|max:255',
            'formData.content' => 'required|string',
            'formData.category' => 'required|numeric|exists:categories,id',
            'image' => [
                'nullable',
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
            'image.image' => 'Image must be an image',
            'image.max' => 'Image size must not be greator than :max',
            'image.mimes' => 'The allowed image types are :values',
        ];
    }
}
