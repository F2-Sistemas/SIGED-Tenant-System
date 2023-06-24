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
     * Get all of the users for the Tenant
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'id', 'tenant_id');
    }
}
