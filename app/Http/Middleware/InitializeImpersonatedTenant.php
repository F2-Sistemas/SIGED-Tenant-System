<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Tenant;
use Illuminate\Http\Request;
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

        if (!$authUser && !$authUser?->can('impersonate-a-tenant')) {
            \tenancy()->end();

            return $next($request);
        }

        $tenantId = \session('impersonated_tenant');

        if (!$tenantId || !($tenant = Tenant::getByIdAndCache($tenantId))) {
            \tenancy()->end();
            \session()->forget('impersonated_tenant');
            \session()->forget('impersonated_tenant_data');

            return $next($request);
        }

        \tenancy()->end();

        if ($tenant) {
            \session()->put('impersonated_tenant', $tenant?->id);
            \session()->put('impersonated_tenant_data', $tenant);
            tenancy()->initialize($tenant);
        }

        return $next($request);
    }
}
