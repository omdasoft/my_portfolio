<?php

namespace App\Livewire\Backend\Portfolio;

use App\Models\Portfolio;
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
        $portfolios = Portfolio::with('images')->latest()->paginate(10);

        return view('livewire.backend.portfolio.index', compact('portfolios'))->layout('layouts.admin');
    }

    public function edit(int $id)
    {
        return redirect()->route('admin.portfolios.edit', ['id' => $id]);
    }

    public function view(int $id)
    {
        return redirect()->route('admin.portfolios.view', ['id' => $id]);
    }

    private function getPortfolio(int $id)
    {
        $portfolio = Portfolio::findOrFail($id);

        $this->title = $portfolio->title;
        $this->description = $portfolio->description;
        $this->url = $portfolio->url;
        $this->github_url = $portfolio->github_url;
    }

    public function showConfirmationModal($id)
    {
        $this->actionId = $id;
        $this->dispatch('open-modal', 'confirmationModal');
    }

    public function deleteConfirmed()
    {
        if ($this->actionId) {
            $portfolio = Portfolio::with('images')->findOrFail($this->actionId);

            if ($portfolio->images) {
                foreach ($portfolio->images as $image) {
                    $this->removeUploadedImage($image->image_path);
                }
            }

            $portfolio->images()->delete();

            $portfolio->delete();

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
