<?php

namespace App\Actions\Post;

use App\Models\Post;
use App\Traits\HasMediaUpload;
use Illuminate\Support\Facades\DB;

class EditPostAction
{
    use HasMediaUpload;

    public static function handle(Post $post, array $data): void
    {
        DB::transaction(function () use ($post, $data) {
            // Edit Post
            $post->title = $data['title'];
            $post->content = $data['content'];
            $post->category_id = $data['category'];
            $post->status = $data['status'];
            $post->save();

            //Upload and save image
            if ($data['hasImage']) {

                //Remove old image from storage
                if ($post->image) {
                    $this->removeUploadedFile($post->image->image_path);

                    //Delete old image from db
                    $post->image()->delete();
                }

                //Save image in the database
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
