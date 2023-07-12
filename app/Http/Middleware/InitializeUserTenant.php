<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Helpers\TenantHelpers;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class InitializeUserTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authUser = $request?->user() ?? Auth::user() ?? Filament::auth()->user();

        if (!$authUser) {
            \tenancy()->end();

            TenantHelpers::tenantDiskReset();

            return $next($request);
        }

        $userTenantId = $authUser?->tenant_id;

        \tenancy()->end();
        TenantHelpers::tenantDiskReset();

        if (!$userTenantId) {
            return $next($request);
        }

        $tenant = Tenant::getByIdAndCache($userTenantId);

        if (!$tenant || !$userTenantId || !$tenant?->id || ($userTenantId != $tenant?->id)) {
            return $next($request);
        }

        if ($tenant) {
            tenancy()->initialize($tenant);
            TenantHelpers::tenantDiskInit();
        }

        return $next($request);
    }
}
