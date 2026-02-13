<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Animation',
                'description' => 'All animation related content',
                'status' => 'active',
                'order' => 1
            ],
            [
                'name' => 'Technology',
                'description' => 'Technology and IT related content',
                'status' => 'active',
                'order' => 2
            ],
            [
                'name' => 'Medical',
                'description' => 'Medical and healthcare related content',
                'status' => 'active',
                'order' => 3
            ],
            [
                'name' => 'Commerce',
                'description' => 'Business and commerce related content',
                'status' => 'active',
                'order' => 4
            ],
            [
                'name' => 'Arts',
                'description' => 'Arts and creative content',
                'status' => 'active',
                'order' => 5
            ],
            [
                'name' => 'Engineering',
                'description' => 'Engineering and technical content',
                'status' => 'active',
                'order' => 6
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}