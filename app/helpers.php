<?php

use App\Enums\PostStatus;
use App\Models\Portfolio;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

if (! function_exists('get_tags_with_count')) {

    /**
     * @return Collection<int, Tag>
     */
    function get_tags_with_count(string $model): Collection
    {
        $modelType = ($model === 'post') ? Post::class : Portfolio::class;

        return Tag::selectRaw('tags.tag_name, COUNT(*) as tags_count')
            ->where('tagable_type', $modelType)
            ->whereHasMorph(
                'tagable',
                [$modelType],
                function ($query) {
                    $query->where('status', PostStatus::PUBLISHED->value);
                }
            )
            ->groupBy('tags.tag_name')
            ->get();
    }
}
