<?php

use App\Models\User;
use App\Models\Tenant;
use App\Helpers\TenantHelpers;
use App\Helpers\ImpersonateTenantHelpers;

if (!function_exists('getTenancy')) {
    /**
     * getTenancy function
     *
     * @return ?\Stancl\Tenancy\Tenancy
     */
    function getTenancy(): ?Stancl\Tenancy\Tenancy
    {
        return TenantHelpers::getTenancy();
    }
}

if (!function_exists('hasInitializedTenant')) {
    /**
     * hasInitializedTenant function
     *
     * @return boolean
     */
    function hasInitializedTenant(): bool
    {
        return TenantHelpers::hasInitializedTenant();
    }
}

if (!function_exists('getTenant')) {
    /**
     * Get a key from the current tenant's storage.
     *
     * @param string|null $key
     * @return Tenant|null|mixed
     */
    function getTenant($key = null): ?Tenant
    {
        return TenantHelpers::getTenant($key);
    }
}

if (!function_exists('tenantInit')) {
    /**
     * function tenantInit
     *
     * @param mixed $tenantId
     * @param bool $throwException
     *
     * @return bool
     */
    function tenantInit(mixed $tenantId, bool $throwException = false): bool
    {
        return TenantHelpers::tenantInit($tenantId, $throwException);
    }
}

if (!function_exists('tenantEnd')) {
    /**
     * function tenantEnd
     *
     * @param bool $throwException
     *
     * @return bool
     */
    function tenantEnd(?bool $throwException = null): bool
    {
        return TenantHelpers::tenantEnd($throwException);
    }
}

if (!function_exists('initializeTenant')) {
    /**
     * function initializeTenant
     *
     * @param mixed $tenantId
     * @param bool $throwException
     *
     * @return bool
     */
    function initializeTenant(mixed $tenantId, bool $throwException = false): bool
    {
        return TenantHelpers::tenantInit($tenantId, $throwException);
    }
}

if (!function_exists('hasTenantOnSession')) {
    /**
     * function hasTenantOnSession
     *
     * @param null|User $user
     * @return bool
     */
    function hasTenantOnSession(null|User $user): bool
    {
        return ImpersonateTenantHelpers::hasTenantOnSession($user);
    }
}

if (!function_exists('canImpersonateATenant')) {
    /**
     * function canImpersonateATenant
     *
     * @param null|User $user
     * @return bool
     */
    function canImpersonateATenant(null|User $user): bool
    {
        return ImpersonateTenantHelpers::canImpersonateATenant($user);
    }
}
