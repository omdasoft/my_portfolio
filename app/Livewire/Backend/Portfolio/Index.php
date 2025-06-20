<?php

namespace App\Livewire\Backend\Portfolio;

use App\Models\Portfolio;
use App\Traits\HasMediaUpload;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Livewire\WithPagination;

class Index extends Component
{
    use HasMediaUpload, WithPagination;

    public int $actionId;

    public string $message = '';

    public function mount(): void {}

    public function render(): View
    {
        $portfolios = Portfolio::with('images')->latest()->paginate(10);

        return view('livewire.backend.portfolio.index', ['portfolios' => $portfolios])->layout('layouts.admin');
    }

    public function edit(int $id): Redirector|RedirectResponse
    {
        return redirect()->to(route('admin.portfolios.edit', ['id' => $id]));
    }

    public function view(int $id): Redirector|RedirectResponse
    {
        return redirect()->to(route('admin.portfolios.view', ['id' => $id]));
    }

    public function showConfirmationModal(int $id): void
    {
        $this->actionId = $id;
        $this->dispatch('open-modal', 'confirmationModal');
    }

    public function deleteConfirmed(): void
    {
        if ($this->actionId !== 0) {
            $portfolio = Portfolio::with('images')->findOrFail($this->actionId);

            /** @phpstan-ignore-next-line */
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

    public function closeModal(string $modalName): void
    {
        $this->dispatch('close-modal', $modalName);
    }
}
