<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'url',
        'github_url',
        'completion_date',
    ];

    public function images()
    {
        return $this->morphMany('App\Models\Image', 'imageable');
    }

    public function tags()
    {
        return $this->morphMany('App\Models\Tag', 'tagable');
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('Y-m-d');
    }

    public function getImageAttribute()
    {
        $image = $this->images()->first();

        if ($image) {
            $imagePath = $image->image_path;

            return Str::startsWith($imagePath, 'https') ? $imagePath : Storage::url($imagePath);
        }

        return asset('storage/default.png');
    }
}
