<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'designation', 'intro', 'phone', 'github', 'twitter', 'linkedin', 'resume_path'];

    public function image() {
        return $this->morphOne('App\Models\Image', 'imageable');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
