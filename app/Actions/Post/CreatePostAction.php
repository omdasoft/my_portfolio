<?php

namespace App\Actions\Post;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class CreatePostAction
{
    /**
     * @param array{
     *     title: string,
     *     content: string,
     *     status: string,
     *     imagePath: string|null,
     *     tags: array<int, string>|null
     * } $data
     */
    public static function handle(array $data): void
    {
        DB::transaction(function () use ($data) {
            $post = new Post;
            $post->title = $data['title'];
            $post->content = $data['content'];
            $post->status = $data['status'];
            $post->save();

            // create image
            if ($data['imagePath']) {
                $post->image()->create([
                    'image_path' => $data['imagePath'],
                ]);
            }

            // Create tags
            if ($data['tags']) {
                foreach ($data['tags'] as $tag) {
                    Tag::updateOrCreate([
                        'tag_list_id' => $tag,
                        'tagable_id' => $post->id,
                        'tagable_type' => Post::class,
                    ]);
                }
            }
        });
    }
}
