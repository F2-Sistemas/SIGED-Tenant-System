<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Modules\Product\Entities\ProductVariation
 *
 * @property AsCollection $meta_info
 * @property-read \Modules\Product\Entities\Product|null $product
 * @method static \Modules\Product\Database\factories\ProductVariationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation query()
 * @mixin \Eloquent
 */
class ProductVariation extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'product_id',
        'description',
        'is_free',
        'price',
        'promo_price',
        'main',
        'enabled',
        'need_to_control_stock',
        'stock',
        'show_if_out_stock',
        'show_out_stock_message',
        'available',
        'show_if_unavailable',
        'show_unavailable_message',
        'meta_info',
        'promo_price_enabled',
    ];

    protected $casts = [
        'main' => 'boolean',
        'is_free' => 'boolean',
        'enabled' => 'boolean',
        'promo_price_enabled' => 'boolean',
        'need_to_control_stock' => 'boolean',
        'show_if_out_stock' => 'boolean',
        'show_out_stock_message' => 'boolean',
        'available' => 'boolean',
        'show_if_unavailable' => 'boolean',
        'show_unavailable_message' => 'boolean',
        'meta_info' => AsCollection::class,
    ];

    /**
     * Get the product that owns the ProductVariation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(
            \Modules\Product\Entities\Product::class,
            'product_id',
            'id'
        );
    }

    protected static function newFactory()
    {
        return \Modules\Product\Database\factories\ProductVariationFactory::new();
    }
}
