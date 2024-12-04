<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Image;
use App\Models\Portfolio;
use App\Models\Post;
use App\Models\Profile;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create();
        Profile::factory()->has(Image::factory())->create();
        Category::factory()->count(5)->create();
        Portfolio::factory()->count(15)->has(Image::factory()->count(15))->has(Tag::factory()->count(15))->create();
        Post::factory()->count(5)->has(Tag::factory(5)->count(5))->create();
    }
}
