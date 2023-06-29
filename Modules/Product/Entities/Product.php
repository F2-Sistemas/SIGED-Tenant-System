<?php

namespace Modules\Product\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Modules\Product\Entities\Product
 *
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $id
 * @property string $seller_id
 * @property string $name
 * @property int|null $unit_type
 * @property-read User|null $seller
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ProductVariation> $variations
 * @property-read int|null $variations_count
 * @method static \Modules\Product\Database\factories\ProductFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUnitType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ProductVariation> $variations
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Product\Entities\ProductVariation> $variations
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Product\Entities\ProductVariation> $variations
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Product\Entities\ProductVariation> $variations
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Product\Entities\ProductVariation> $variations
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Product\Entities\ProductVariation> $variations
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Product\Entities\ProductVariation> $variations
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Product\Entities\ProductVariation> $variations
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Product\Entities\ProductVariation> $variations
 * @mixin \Eloquent
 */
class Product extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'seller_id',
        'name',
        'unit_type',
    ];

    protected static function newFactory()
    {
        return \Modules\Product\Database\factories\ProductFactory::new();
    }

    /**
     * Get the seller that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id', 'id');
    }

    /**
     * Get all of the variations for the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function variations(): HasMany
    {
        return $this->hasMany(ProductVariation::class, 'product_id', 'id');
    }
}
