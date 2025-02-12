<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
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
        'slug',
    ];

    protected static function booted(): void
    {
        static::creating(function (Portfolio $portfolio) {
            $portfolio->slug = Str::slug($portfolio->title);
        });
    }

    /**
     * @return MorphMany<Image>
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * @return MorphMany<Tag>
     */
    public function tags(): MorphMany
    {
        return $this->morphMany(Tag::class, 'tagable');
    }

    public function getCreatedAtAttribute(): string
    {
        return Carbon::parse($this->attributes['created_at'])->format('M d, Y');
    }

    public function getImageAttribute(): string
    {
        $image = $this->images()->first();

        if ($image) {
            $imagePath = $image->image_path;

            return Str::startsWith($imagePath, 'https') ? $imagePath : Storage::url($imagePath);
        }

        return asset('storage/default.png');
    }

    public function getShortDescriptionAttribute(): string
    {
        return Str::substr($this->attributes['description'], 0, 100);
    }
}
