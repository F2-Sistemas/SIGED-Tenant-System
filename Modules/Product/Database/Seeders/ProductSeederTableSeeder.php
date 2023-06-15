<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductVariation;

class ProductSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Product::factory(10)->create()->each(function (Product $product) {
            foreach (range(1, rand(1, 4)) as $iteration) {
                ProductVariation::factory()->create([
                    'product_id' => $product->id,
                    'main' => $iteration === 1,
                ]);
            }
        });
    }
}
