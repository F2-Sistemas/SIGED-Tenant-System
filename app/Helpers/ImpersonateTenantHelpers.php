<?php

namespace App\Helpers;

use App\Models\Tenant;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ImpersonateTenantHelpers
{
    /**
     * function impersonate
     *
     * @param null|User $user
     * @param null|Tenant|string $tenant
     *
     * @return bool
     */
    public static function impersonate(
        null|User $user,
        null|Tenant|string $tenant,
    ): bool {
        if (
            !$tenant
            || !$user
            || !static::canImpersonateATenant($user)
        ) {
            return false;
        }

        $tenant = \is_string($tenant) ? Tenant::where('id', $tenant)->first() : $tenant;

        if (!$tenant || !$tenant?->id || is_a($tenant, Tenant::class)) {
            return false;
        }

        session()->forget('impersonated_tenant');

        tenancy()->initialize($tenant);
        session()->put('impersonated_tenant', $tenant?->id);

        return true;
    }

    /**
     * function canViewItem
     *
     * @param null|User $user
     * @param bool $initializedTenantIsRequired
     *
     * @return bool
     */
    public static function canViewItem(
        null|User $user,
        bool $initializedTenantIsRequired = false
    ): bool {
        if (
            !$user
            || !static::canImpersonateATenant($user)
            || !session('impersonated_tenant')
        ) {
            return false;
        }

        $tenantId = session('impersonated_tenant');

        $tenant = static::getImpersonatedTenant();

        if ($initializedTenantIsRequired && !$tenant) {
            return \false;
        }

        if (!$tenant || $tenant?->id != $tenantId) {
            return false;
        }

        return true;
    }

    /**
     * getImpersonatedTenant function
     *
     * @param null|User $user
     *
     * @return Tenant|null
     */
    public static function getImpersonatedTenant(null|User $user = null): ?Tenant
    {
        $user ??= Auth::user() ?? Filament::auth()->user();

        if (!$user && !$user?->can('impersonate-a-tenant')) {
            return null;
        }

        $tenantId = session('impersonated_tenant');

        if (!$tenantId || !Tenant::getByIdAndCache($tenantId)) {
            \tenancy()->end();
            \session()->forget('impersonated_tenant');
            \session()->forget('impersonated_tenant_data');

            return null;
        }

        return \tenancy()?->tenant ?: null;
    }

    /**
     * function canImpersonateATenant
     *
     * @param null|User $user
     * @return bool
     */
    public static function canImpersonateATenant(null|User $user): bool
    {
        if (!$user) {
            return false;
        }

        return $user
            && !$user?->tenant
            && $user->can('impersonate-a-tenant');
    }

    /**
     * function hasTenantOnSession
     *
     * @param null|User $user
     * @return bool
     */
    public static function hasTenantOnSession(null|User $user): bool
    {
        $initialValidation = static::canImpersonateATenant($user)
            && session('impersonated_tenant');

        if (!$initialValidation) {
            return false;
        }

        if (!\tenant() || !\tenant('id') || (\tenant('id') != session('impersonated_tenant'))) {
            session()->forget('impersonated_tenant');

            return false;
        }

        return \tenant('id') === session('impersonated_tenant');
    }
}
