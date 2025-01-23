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
    function get_tags_with_count(string $modelName): Collection
    {
        $model = ($modelName === 'post') ? Post::class : Portfolio::class;

        return Tag::selectRaw('tags.tag_name, COUNT(id) as tags_count')
            ->where('tagable_type', $model)
            ->whereHasMorph(
                'tagable',
                [$model],
                function ($query) {
                    $query->where('status', PostStatus::PUBLISHED->value);
                }
            )
            ->groupBy('tags.tag_name')
            ->get();
    }
}
