<?php

namespace App\Traits;

use App\Models\Tenant;

trait TenancyEasyHelpers
{
    /**
     * getTenancy function
     *
     * @return \Stancl\Tenancy\Tenancy|null
     */
    public static function getTenancy(): ?\Stancl\Tenancy\Tenancy
    {
        return tenancy();
    }

    /**
     * hasInitializedTenant function
     *
     * @return boolean
     */
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
    public static function getTenant($key = null): ?Tenant
    {
        if (is_null($key)) {
            static::getTenancy()?->tenant ?? \null;
        }

        return optional(static::getTenancy()?->tenant ?? \null)->getAttribute($key) ?? null;
    }

    /**
     * function tenantInit
     *
     * @param mixed $tenantId
     * @param bool $throwException
     *
     * @return bool
     */
    public static function tenantInit(mixed $tenantId, ?bool $throwException = null): bool
    {
        try {
            tenancy()->initialize(Tenant::find($tenantId));

            return true;
        } catch (\Throwable $th) {
            if ($throwException ?? config('app.debug')) {
                throw $th;
            }

            return false;
        }
    }

    /**
     * function tenantEnd
     *
     * @param bool $throwException
     *
     * @return bool
     */
    public static function tenantEnd(?bool $throwException = null): bool
    {
        try {
            tenancy()->end();

            return true;
        } catch (\Throwable $th) {
            if ($throwException ?? config('app.debug')) {
                throw $th;
            }

            return false;
        }
    }
}
