<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        return [
            'name' => $this->faker->words(asText: true),
            'slug' => fn ($attrs) => str($attrs['name'])->slug()->toString(),
        ];
    }
}
