<?php

namespace App\Models;

use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase;
    use HasDomains;

    protected $appends = [
        'domains',
    ];

    /**
     * Get all of the domainsList for the Tenant
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function domainsList(): HasMany
    {
        return $this->hasMany(Domain::class, 'tenant_id', 'id');
    }

    public function getDomainsAttribute()
    {
        $cacheKey = implode('-', [
            'Tenant',
            'domainsList',
            $this->id,
        ]);

        return \Illuminate\Support\Facades\Cache::remember(
            $cacheKey,
            300 /*secs*/,
            fn() => Domain::where('tenant_id', $this->id)->get(),
        );;
    }
}
