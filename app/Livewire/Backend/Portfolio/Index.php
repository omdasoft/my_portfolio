<?php

namespace App\Livewire\Backend\Portfolio;

use App\Models\Portfolio as PortfolioModel;
use App\Traits\HasMediaUpload;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use HasMediaUpload, WithPagination;

    public int $actionId;

    public string $title;

    public string $url;

    public string $github_url;

    public string $description;

    public $image;

    public array $imagePathes = [];

    public bool $isCreate = false;

    public string $message = '';

    public int $maxFileSize = 1024 * 8;

    public function mount()
    {
    }

    public function render()
    {
        $portfolios = PortfolioModel::with('images')->latest()->paginate(10);

        return view('livewire.backend.portfolio.index', compact('portfolios'))->layout('layouts.admin');
    }

    // public function create()
    // {
    //     $this->isCreate = true;
    //     $this->dispatch('open-modal', 'createEditPortfolio');
    // }

    public function edit(int $id)
    {
        $this->isCreate = false;
        $this->getPortfolio($id);
        $this->actionId = $id;
        $this->dispatch('open-modal', 'createEditPortfolio');
    }

    private function getPortfolio(int $id)
    {
        $portfolio = PortfolioModel::findOrFail($id);

        $this->title = $portfolio->title;
        $this->description = $portfolio->description;
        $this->url = $portfolio->url;
        $this->github_url = $portfolio->github_url;
    }

    public function store()
    {
        $this->validate();

        // Create portfolio
        $portfolio = new PortfolioModel();
        $portfolio->title = $this->title;
        $portfolio->url = $this->url;
        $portfolio->github_url = $this->github_url;
        $portfolio->description = $this->description;
        $portfolio->save();

        // Upload and associate images
        // if (! empty($this->images)) {
        //     foreach ($this->images as $image) {
        //         // $imagePath = $image->store('portfolio', 'public');
        //         $imagePath = $this->upload($image, 'portfolio');

        //         // Create image record associated with portfolio
        //         $portfolio->images()->create([
        //             'image_path' => $imagePath,
        //         ]);
        //     }
        // }

        $this->message = 'Portfolio Created Successfully!';
        $this->dispatch('action-success');
        $this->clearForm();
        $this->closeModal('createEditPortfolio');
    }

    public function update()
    {
        $this->validate();

        if ($this->actionId) {
            $portfolio = PortfolioModel::findOrFail($this->actionId);
            $portfolio->title = $this->title;
            $portfolio->url = $this->url;
            $portfolio->github_url = $this->github_url;
            $portfolio->description = $this->description;
            $portfolio->save();

            // Upload and associate images
            // if (! empty($this->images)) {
            //     foreach ($this->images as $image) {
            //         // $imagePath = $image->store('portfolio', 'public');
            //         $imagePath = $this->upload($image, 'portfolio');

            //         // Create image record associated with portfolio
            //         $portfolio->images()->create([
            //             'image_path' => $imagePath,
            //         ]);
            //     }
            // }

            $this->message = 'Portfolio Updated Successfully!';
            $this->dispatch('action-success');
            $this->clearForm();
            $this->closeModal('createEditPortfolio');
            $this->actionId = -1;
        }
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

    public function showConfirmationModal($id)
    {
        $this->actionId = $id;
        $this->dispatch('open-modal', 'confirmationModal');
    }

    public function deleteConfirmed()
    {
        if ($this->actionId) {
            PortfolioModel::findOrFail($this->actionId)->delete();
            $this->actionId = -1;
        }

        $this->message = 'Portfolio Deleted Successfully!';
        $this->dispatch('action-success');
        $this->closeModal('confirmationModal');
    }

    public function closeModal($modalName)
    {
        $this->dispatch('close-modal', $modalName);
    }
}
