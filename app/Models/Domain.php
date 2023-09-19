<?php

namespace App\Models;

use App\Models\Tenant;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Domain
 *
 * @property int $id
 * @property string $domain
 * @property string $tenant_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Tenant $tenant
 * @method static \Illuminate\Database\Eloquent\Builder|Domain newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Domain newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Domain query()
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Domain extends \Stancl\Tenancy\Database\Models\Domain
{
    /**
     * Get the tenant that owns the Domain
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * function firstByDomain
     *
     * @param ?string $domain
     *
     * @return ?object
     */
    public static function firstByDomain(?string $domain): ?object
    {
        if (!$domain) {
            return null;
        }

        return Cache::remember(
            implode('-', [
                str(__CLASS__)->afterLast('\\'),
                __FUNCTION__,
                $domain,
            ]),
            300,
            fn () => Domain::where('domain', $domain)->first()
        );
    }
}
