<?php

namespace App\Actions\Post;

use App\Models\Post;
use Illuminate\Support\Facades\DB;

class CreatePostAction
{
    public static function handle(array $data): void
    {
        DB::transaction(function () use ($data) {
            $post = new Post();
            $post->title = $data['title'];
            $post->content = $data['content'];
            $post->category_id = $data['category'];
            $post->save();

            //create image
            if ($data['imagePath']) {
                $post->image()->create([
                    'image_path' => $data['imagePath'],
                ]);
            }

            //Create tags
            if ($data['tags']) {
                foreach ($data['tags'] as $tag) {
                    $post->tags()->create([
                        'tag_name' => $tag,
                    ]);
                }
            }
        });
    }
}
