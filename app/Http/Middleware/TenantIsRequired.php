<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenantIsRequired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, mixed $key = null): Response
    {
        $key = is_string($key) ? $key : null;

        static::abortIfHasNoTenant($key);

        return $next($request);
    }

    /**
     * abortIfHasNoTenant function
     *
     * @param string|null $key
     *
     * @return void
     */
    public static function abortIfHasNoTenant(?string $key = null): void
    {
        abort_if(!tenant($key ?: 'id'), 404);
    }
}
