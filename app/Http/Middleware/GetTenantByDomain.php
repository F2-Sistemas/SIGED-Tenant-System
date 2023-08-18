<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GetTenantByDomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $hostDomain = $request->getHost();

        abort_if(
            (!$hostDomain || in_array($hostDomain, (array) config('tenancy.central_domains'), true)),
            404
        );

        $tenant = Tenant::firstByDomain($hostDomain);

        if (!$tenant) {
            abort(404);
        }

        tenancy()->initialize($tenant);

        return $next($request);
    }
}
