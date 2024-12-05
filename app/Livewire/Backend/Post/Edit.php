<?php

namespace App\Livewire\Backend\Post;

use App\Models\Category;
use App\Models\Image;
use App\Models\Post;
use App\Traits\HasMediaUpload;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Edit extends Component
{
    use HasMediaUpload;

    public string $title;

    public string $content;

    public $image;

    public string $imagePath = '';

    public string $message = '';

    public array $options = [];

    public int $category;

    public Post $post;

    public function mount(int $id)
    {
        $this->getCategories();
        $this->getPost($id);
    }

    public function getPost(int $id)
    {
        $this->post = Post::with('image', 'category')->findOrFail($id);
        $this->title = $this->post->title;
        $this->content = $this->post->content;
        $this->category = $this->post->category_id;
        $this->imagePath = $this->post->image_path;
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

    public function update()
    {
        $this->validate();

        // Edit Post
        $this->post->title = $this->title;
        $this->post->content = $this->content;
        $this->post->category_id = $this->category;
        $this->post->save();

        //Add image if exists
        if ($this->imagePath) {
            //Remove old image from storage
            $this->removeUploadedImage($this->post->image->image_path);

            //Delete old image from db
            $this->post->image()->delete();

            //Save image un the database
            $this->post->image()->create([
                'image_path' => $this->imagePath,
            ]);

            $this->image = '';
        }

        $this->message = 'Post Updated Successfully!';
        $this->dispatch('updated');
    }

    public function deleteImage(int $id)
    {
        Image::findOrFail($id)->delete();
        $this->message = 'Post Image Deleted Successfully!';
        $this->dispatch('updated');
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
