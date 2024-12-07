<?php

namespace Database\Factories;

use App\Enums\PostStatus;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->text(15),
            'content' => $this->faker->text(),
            'category_id' => Category::inRandomOrder()->first(),
            'status' => $this->faker->randomElement(PostStatus::cases()),
        ];
    }
}
