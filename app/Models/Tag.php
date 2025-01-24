<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['tag_name', 'tag_slug'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo<Model, Tag>
     */
    public function tagable(): MorphTo
    {
        return $this->morphTo();
    }

    protected static function booted(): void
    {
        static::creating(function (Tag $tag) {
            $tag->tag_slug = Str::slug($tag->tag_name);
        });
    }
}
