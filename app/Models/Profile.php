<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = ['designation', 'intro', 'phone', 'github', 'twitter', 'linkedin', 'resume_path'];

    public function image()
    {
        return $this->morphOne('App\Models\Image', 'imageable');
    }

    public function getImagePathAttribute()
    {
        $image = $this->image()->first();

        if ($image) {
            return Str::startsWith($image->image_path, 'https') ? $image->image_path : Storage::url($image->image_path);
        }

        return asset('storage/default.png');
    }

    public function getResumePathAttribute()
    {
        return Str::startsWith($this->attributes['resume_path'], 'https') ? $this->attributes['resume_path'] : Storage::url($this->attributes['resume_path']);
    }
}
