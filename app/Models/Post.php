<?php

namespace App\Models;

use App\Enums\PostStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Mews\Purifier\Facades\Purifier;

class Post extends Model
{
    /**
     * @use HasFactory<\Database\Factories\PostFactory>
     */
    use HasFactory;

    protected $fillable = ['title', 'slug', 'content', 'category_id', 'status'];

    /**
     * @return MorphOne<Image, $this>
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    /**
     * @return MorphMany<Tag, $this>
     */
    public function tags(): MorphMany
    {
        return $this->morphMany(Tag::class, 'tagable');
    }

    protected static function booted(): void
    {
        static::creating(function (Post $post): void {
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

    /**
     * @param  Builder<Post>  $query
     * @return Builder<Post>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', PostStatus::PUBLISHED->value);
    }

    public function getContentAttribute(string $value): string
    {
        return Purifier::clean($value);
    }

    public function getMetaDescriptionAttribute(): string
    {
        $content = strip_tags($this->content);
        $content = preg_replace('/\s+/', ' ', $content);

        return Str::limit($content, 160, '');
    }

    public function getMetaKeywordsAttribute(): string
    {
        $keywords = [];

        // Extract words from title
        $titleWords = explode(' ', strtolower($this->title));
        $keywords = array_merge($keywords, array_filter($titleWords, function ($word) {
            return strlen($word) > 3;
        }));

        // Extract tag names
        foreach ($this->tags as $tag) {
            $keywords[] = strtolower($tag->tagList->name);
        }

        return implode(', ', array_unique($keywords));
    }
}
