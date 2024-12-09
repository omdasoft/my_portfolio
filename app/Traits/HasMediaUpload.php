<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

trait HasMediaUpload
{
    use WithFileUploads;

    public function upload($file, $folder)
    {
        return $file->store("uploads/{$folder}", 'public');
    }

    public function removeUploadedFile($path)
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
