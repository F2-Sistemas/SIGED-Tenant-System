<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Helpers\TenantHelpers;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class InitializeImpersonatedTenant
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
            \session()->forget('impersonated_tenant');
            \session()->forget('impersonated_tenant_data');

            TenantHelpers::tenantDiskReset();

            return $next($request);
        }

        $impersonatedTenantId = \session()->get('impersonated_tenant');

        \tenancy()->end();
        TenantHelpers::tenantDiskReset();

        if (!$impersonatedTenantId || $authUser?->tenant_id || !$authUser?->can('impersonate-a-tenant')) {
            \session()->forget('impersonated_tenant');
            \session()->forget('impersonated_tenant_data');

            return $next($request);
        }

        $tenant = Tenant::getByIdAndCache($impersonatedTenantId);

        if (!$impersonatedTenantId || !$tenant || !$tenant?->id || ($impersonatedTenantId != $tenant?->id)) {
            \session()->forget('impersonated_tenant');
            \session()->forget('impersonated_tenant_data');


            return $next($request);
        }

        if ($tenant) {
            \session()->put('impersonated_tenant', $tenant?->id);
            \session()->put('impersonated_tenant_data', $tenant);
            tenancy()->initialize($tenant);
            TenantHelpers::tenantDiskInit();
        }

        return $next($request);
    }
}
