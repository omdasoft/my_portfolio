<?php

namespace App\Models;

use App\Enums\PostStatus;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'content', 'category_id', 'status'];

    /**
     * @return MorphOne<Image>
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    /**
     * @return MorphMany<Tag>
     */
    public function tags(): MorphMany
    {
        return $this->morphMany(Tag::class, 'tagable');
    }

    protected static function booted(): void
    {
        static::creating(function (Post $post) {
            $post->slug = Str::slug($post->title);
        });
    }

    public function getImagePathAttribute(): string
    {
        $image = $this->image()->first();

        if ($image) {
            return Str::startsWith($image->image_path, 'https') ? $image->image_path : Storage::url($image->image_path);
        }

        return asset('storage/default.png');
    }

    public function getReadingTimeAttribute(): string
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $wordsPerMinute = 200;
        $readingTime = ceil($wordCount / $wordsPerMinute);

        return $readingTime.' min read';
    }

    public function getCreatedAtAttribute(): string
    {
        return Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }

    public function getShortContentAttribute(): string
    {
        return Str::substr($this->attributes['content'], 0, 200);
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('status', PostStatus::PUBLISHED->value);
    }
}
