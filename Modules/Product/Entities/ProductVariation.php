<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Modules\Product\Entities\ProductVariation
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property mixed $product_id
 * @property string|null $description
 * @property string $code
 * @property bool $is_free
 * @property string|null $price
 * @property string|null $promo_price
 * @property bool $promo_price_enabled
 * @property bool $main
 * @property bool $enabled
 * @property bool $need_to_control_stock
 * @property int|null $stock
 * @property bool $show_if_out_stock
 * @property bool $show_out_stock_message
 * @property bool $available
 * @property bool $show_if_unavailable
 * @property bool $show_unavailable_message
 * @property AsCollection|null $meta_info
 * @method static \Modules\Product\Database\factories\ProductVariationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation whereIsFree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation whereMain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation whereMetaInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation whereNeedToControlStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation wherePromoPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation wherePromoPriceEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation whereShowIfOutStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation whereShowIfUnavailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation whereShowOutStockMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation whereShowUnavailableMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation whereUpdatedAt($value)
 * @property-read \Modules\Product\Entities\Product $product
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
