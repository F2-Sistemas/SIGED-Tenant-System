<?php

namespace App\Traits;

use App\Models\User;
use App\Models\Tenant;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ImpersonateTenantHelpers;

trait ImpersonatedTenantHelpers
{
    protected static ?Tenant $impersonatedTenant = null;

    /**
     * getUser function
     *
     * @return User|null
     */
    public static function getUser(): ?User
    {
        return Auth::user() ?? Filament::auth()?->user();
    }

    /**
     * getImpersonatedTenant function
     *
     * @return Tenant|null
     */
    public static function getImpersonatedTenant(): ?Tenant
    {
        return static::$impersonatedTenant ??= ImpersonateTenantHelpers::getImpersonatedTenant(static::getUser());
    }
}
