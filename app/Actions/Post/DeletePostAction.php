<?php

namespace App\Actions\Post;

use App\Models\Post;
use App\Traits\HasMediaUpload;
use Illuminate\Support\Facades\DB;

class DeletePostAction
{
    use HasMediaUpload;

    public function handle(int $id): void
    {
        DB::transaction(function () use ($id) {
            $post = Post::with('image')->findOrFail($id);

            if ($post->image) {
                $this->removeUploadedFile($post->image);
            }

            $post->image()->delete();

            $post->tags()->delete();

            $post->delete();
        });
    }
}
