<?php

namespace Database\Factories;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'designation' => $this->faker->text(5),
            'intro' => $this->faker->text(),
            'phone' => $this->faker->phoneNumber(),
            'github' => $this->faker->url(),
            'twitter' => $this->faker->url(),
            'linkedin' => $this->faker->url(),
            'resume_path' => $this->faker->imageUrl(),
        ];
    }
}
