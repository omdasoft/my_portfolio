<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Profile extends Model
{
    /**
     * @use HasFactory<\Database\Factories\ProfileFactory>
     */
    use HasFactory;

    protected $fillable = ['designation', 'intro', 'phone', 'github', 'twitter', 'linkedin', 'resume_path'];

    /**
     * @return MorphOne<Image, $this>
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function getImagePathAttribute(): string
    {
        $image = $this->image()->first();

        if ($image) {
            return Str::startsWith($image->image_path, 'https') ? $image->image_path : Storage::url($image->image_path);
        }

        return asset('storage/default.png');
    }

    public function getResumePathAttribute(): string
    {
        return Str::startsWith($this->attributes['resume_path'], 'https') ? $this->attributes['resume_path'] : Storage::url($this->attributes['resume_path']);
    }
}
