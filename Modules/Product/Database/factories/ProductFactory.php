<?php

namespace Modules\Product\Database\factories;

use App\Models\User;
use Modules\Product\Enums\ProductEnum;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Product\Entities\Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'seller_id' => User::factory(),
            'name' => fake()->words(3, true),
            'unit_type' => Arr::random([
                ProductEnum::UNIT_TYPE_UNITY,
                ProductEnum::UNIT_TYPE_BOX,
                ProductEnum::UNIT_TYPE_METER,
                ProductEnum::UNIT_TYPE_LITER,
                ProductEnum::UNIT_TYPE_KG,
            ]),
        ];
    }
}
