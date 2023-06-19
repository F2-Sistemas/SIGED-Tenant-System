<?php

namespace App\Traits;

trait TenancyEasyHelpers
{
    public static function getTenancy(): ?\Stancl\Tenancy\Tenancy
    {
        return tenancy();
    }

    public static function hasInitializedTenant(): bool
    {
        return (bool) (tenancy()?->initialized ?? false);
    }

    /**
     * Get a key from the current tenant's storage.
     *
     * @param string|null $key
     * @return Tenant|null|mixed
     */
    public static function getTenant($key = null): ?\Stancl\Tenancy\Database\Models\Tenant
    {
        if (is_null($key)) {
            static::getTenancy()?->tenant ?? \null;
        }

        return optional(static::getTenancy()?->tenant ?? \null)->getAttribute($key) ?? null;
    }
}
