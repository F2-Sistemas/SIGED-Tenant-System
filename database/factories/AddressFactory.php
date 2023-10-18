<?php

namespace Database\Factories;

use App\Enums\PlaceTypeEnum;
use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return  [
            'city_id' => fn () => City::inRandomOrder()->first(),
            'place_type' => fn () => Arr::random(PlaceTypeEnum::enums()),
            'place' => fake()->streetAddress(),
            'place_number' => fn () => rand(100, 9999),
            'extra_info_1' => fn () => Arr::random([null, fake()->words(2, true)]),
            'extra_info_2' => fn () => Arr::random([null, null, null, fake()->words(2, true)]),
        ];
    }
}
