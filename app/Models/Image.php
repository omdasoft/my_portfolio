<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['imageable_type', 'imageable_id', 'image_path'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo<Model, Image>
     */
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
