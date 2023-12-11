<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'content', 'category_id'];

    public function images() {
        return $this->morphMany('App\Models\Image', 'imageable');
    }

    public function tags() {
        return $this->morphMany('App\Models\Tag', 'tagable');
    }
}
