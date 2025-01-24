<?php

namespace App\Models;

use App\Models\TagList;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['tag_name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo<Model, Tag>
     */
    public function tagable(): MorphTo
    {
        return $this->morphTo();
    }

    public function tagLists(): BelongsTo
    {
        return $this->belongsTo(TagList::class, 'tag_list_id', 'id');
    }
}
