<?php

namespace App\Models;

use App\Traits\TenantStorageSet;
use Illuminate\Support\Facades\Cache;
use App\Traits\TenantModelInitHelpers;
use App\Traits\TenantModelStorageHelpers;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

/**
 * App\Models\Tenant
 *
 * @property string $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property array|null $data
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Domain> $domainList
 * @property-read int|null $domain_list_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Domain> $domains
 * @property-read int|null $domains_count
 * @property-read mixed $domain_list
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Stancl\Tenancy\Database\TenantCollection<int, static> all($columns = ['*'])
 * @method static \Stancl\Tenancy\Database\TenantCollection<int, static> get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant whereUpdatedAt($value)
 * @method static \Stancl\Tenancy\Database\TenantCollection<int, static> all($columns = ['*'])
 * @method static \Stancl\Tenancy\Database\TenantCollection<int, static> get($columns = ['*'])
 * @mixin \Eloquent
 */
class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase;
    use HasDomains;
    use TenantModelInitHelpers;
    use TenantModelStorageHelpers;
    use TenantStorageSet;

    protected $appends = [
        'domainList',
    ];

    /**
     * Get all of the domainList for the Tenant
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function domainList(): HasMany
    {
        return $this->hasMany(Domain::class, 'tenant_id', 'id');
    }

    public function getDomainListAttribute()
    {
        $cacheKey = implode('-', [
            'Tenant',
            'domainList',
            $this->id,
        ]);

        return Cache::remember(
            $cacheKey,
            300 /*secs*/,
            fn () => Domain::where('tenant_id', $this->id)->get(),
        );
    }

    /**
     * function getByIdAndCache
     *
     * @param ?string $tenantId
     *
     * @return ?object
     */
    public static function getByIdAndCache(?string $tenantId): ?object
    {
        return Cache::remember(
            "org-getByIdAndCache-{$tenantId}",
            300,
            fn () => Tenant::whereId($tenantId)->first()
        );
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
            function () use ($domain) {
                $domain = Domain::firstByDomain($domain);

                if (!$domain || !$domain?->tenant_id) {
                    return null;
                }

                return Tenant::whereId($domain?->tenant_id)->first();
            }
        );
    }

    /**
     * Get all of the users for the Tenant
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'id', 'tenant_id');
    }
}
