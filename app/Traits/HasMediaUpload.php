<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

trait HasMediaUpload
{
    use WithFileUploads;

    public function upload($image, $folder)
    {
        return $image->store("images/{$folder}", 'public');
    }

    public function removeUploadedImage($path)
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
