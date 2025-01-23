<?php

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

if (! function_exists('get_tags_with_count')) {

    /**
     * @return Collection<int, Tag>
     */
    function get_post_tags_with_count(): Collection
    {
        $publishedPostIds = Post::published()->pluck('id')->toArray();

        return Tag::query()
            ->selectRaw('tags.tag_name, COUNT(*) as tags_count')
            ->where('tagable_type', Post::class)
            ->whereIn('tagable_id', $publishedPostIds)
            ->distinct()
            ->groupBy('tags.tag_name')
            ->get();
    }
}
