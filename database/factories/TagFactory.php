<?php

namespace Database\Factories;

use App\Models\Tag;
use App\Models\TagList;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tagListIds = TagList::pluck('id')->toArray();

        return [
            'tag_list_id' => $this->faker->randomElement($tagListIds),
        ];
    }
}
