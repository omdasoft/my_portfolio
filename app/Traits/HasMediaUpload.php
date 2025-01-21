<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

trait HasMediaUpload
{
    use WithFileUploads;

    public function upload(object $file, string $folder): string
    {
        return $file->store("uploads/{$folder}", 'public');
    }

    public function removeUploadedFile(string $path): void
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
