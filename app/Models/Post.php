<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'content', 'category_id', 'status'];

    public function image()
    {
        return $this->morphOne('App\Models\Image', 'imageable');
    }

    public function tags()
    {
        return $this->morphMany('App\Models\Tag', 'tagable');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected static function booted(): void
    {
        static::creating(function (Post $post) {
            $post->slug = Str::slug($post->title);
        });
    }

    public function getImagePathAttribute()
    {
        $image = $this->image()->first();

        if ($image) {
            return Str::startsWith($image->image_path, 'https') ? $image->image_path : Storage::url($image->image_path);
        }

        return asset('storage/default.png');
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }
}
