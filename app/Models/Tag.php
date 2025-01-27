<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<TagList, Tag>
     */
    public function tagList(): BelongsTo
    {
        return $this->belongsTo(TagList::class, 'tag_list_id', 'id');
    }
}
