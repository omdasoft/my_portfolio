<?php

namespace App\Actions\Post;

use App\Models\Post;
use App\Models\Tag;
use App\Traits\HasMediaUpload;
use Illuminate\Support\Facades\DB;
use Mews\Purifier\Facades\Purifier;

class EditPostAction
{
    use HasMediaUpload;

    /**
     * @param array{
     *     title: string,
     *     content: string,
     *     status: string,
     *     hasImage: bool,
     *     imagePath: string|null,
     *     tags: array<int, string>|null
     * } $data
     */
    public function handle(Post $post, array $data): void
    {
        DB::transaction(function () use ($post, $data): void {
            // Edit Post
            $post->title = $data['title'];
            $post->content = Purifier::clean($data['content']);
            $post->status = $data['status'];
            $post->save();

            // Upload and save image
            if ($data['hasImage']) {

                // Remove old image from storage
                if ($post->image) {
                    $this->removeUploadedFile($post->image->image_path);

                    // Delete old image from db
                    $post->image()->delete();
                }

                // Save image in the database
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
