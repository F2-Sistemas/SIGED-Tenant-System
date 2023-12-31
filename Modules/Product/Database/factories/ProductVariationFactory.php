<?php

namespace Modules\Product\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductVariationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Product\Entities\ProductVariation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => implode('-', \fake()->words(2)),
            'product_id' => \Modules\Product\Entities\Product::factory(),
            'description' => \App\Helpers\Faker::paragraphs(
                count: 3,
                implodeWith: '<br>' . \PHP_EOL,
                attributes: ['class' => 'faker-generated-text']
            ),
            'is_free' => false,
            'price' => number_format(
                rand(300, 15000) . '.' . rand(10, 90),
                2,
                '.',
                ''
            ),
            'promo_price_enabled' => (rand(1, 100) % 5) === 0,
            'promo_price' => function ($att) {
                return $att['promo_price_enabled']
                    ? number_format((
                        $att['price'] - ($att['price'] * 0.20)
                    ), 2, '.', '')
                    : \null;
            },
            'main' => false,
            'enabled' => true,
            'need_to_control_stock' => false,
            'available' => (rand(1, 100) % 5) === 0,
            'meta_info' => [
                'voltage' => '12v',
                'weight' => '120g',
            ],
        ];
    }
}
