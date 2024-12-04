<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

trait HasMediaUpload
{
    use WithFileUploads;

    public function upload($image, $folder)
    {
        $path = $image->store("images/{$folder}", 'public');

        return Storage::url($path);
    }

    public function deleteImage($path)
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
