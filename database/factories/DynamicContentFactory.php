<?php

namespace Database\Factories;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DynamicContent>
 */
class DynamicContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'slug' => fake()->slug(8, true),
            'title' => fake()->words(8, true),
            'cover_image' => \null,
            'small_description' => fake()->sentence(8, true),
            'content' => nl2br(fake()->paragraphs(8, true)),
            'active' => true,
            'css_code' => \null,
            'js_code' => \null,
            'html_code' => \null,
            'show_from' => Arr::random([\null, now(), now()->subDays(15)]),
            'show_to' => Arr::random([\null, now(), now()->subDays(15)]),
            'search_tags' => fake()->words(8),
        ];
    }
}
