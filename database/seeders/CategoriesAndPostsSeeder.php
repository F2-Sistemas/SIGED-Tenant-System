<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use App\Models\Post;

class CategoriesAndPostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory()
            ->count(rand(5, 10))
            ->has(
                Post::factory()
                    ->published()
                    ->count(rand(5, 10))
            )
            ->create();
    }
}
