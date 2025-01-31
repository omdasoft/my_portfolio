<?php

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

if (! function_exists('get_post_tags_with_count')) {

    /**
     * @return Collection<int, Tag>
     */
    function get_post_tags_with_count(): Collection
    {
        return Tag::query()
            ->select([
                'lists.name as tag_name',
                'lists.slug as tag_slug',
                DB::raw('COUNT(*) as tags_count'),
            ])
            ->join('tag_lists as lists', 'lists.id', '=', 'tags.tag_list_id')
            ->join('posts', 'posts.id', '=', 'tags.tagable_id')
            ->where('posts.status', 'Published')
            ->where('tagable_type', Post::class)
            ->distinct()
            ->groupBy('tag_name', 'tag_slug')
            ->get();
    }
}
