<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Web Development',
            'Backend Development',
            'Frontend Development',
            'System Design',
            'Database Managment',
            'API Integration',
            'Career Advice',
            'Security',
            'CI/CD',
        ];

        foreach ($categories as $category) {
            Category::create([
                'category_name' => $category,
            ]);
        }
    }
}
