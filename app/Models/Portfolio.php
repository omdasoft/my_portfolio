<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'description',
        'url',
        'github_url',
        'completion_date'
    ];

    public function images() {
        return $this->morphMany('App\Models\Image', 'imageable');
    }

    public function tags() {
        return $this->morphMany('App\Models\Tag', 'tagable');
    }
}
