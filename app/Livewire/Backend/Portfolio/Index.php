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

    public string $message = '';

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
                    $this->removeUploadedFile($image->image_path);
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
