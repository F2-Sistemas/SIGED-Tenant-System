<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TenantIsRequired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(
        Request $request,
        Closure $next,
        null|string|bool $initializedTenantIsRequired = false
    ): Response {
        $authUser = $request?->user() ?? Auth::user() ?? Filament::auth()->user();

        if ($initializedTenantIsRequired) {
            $this->tenantOrAbort($request);
        }

        if (!$authUser && $authUser?->can('impersonate-a-tenant')) {
            return $next($request);
        }

        if (
            \in_array(
                \Route::currentRouteName(),
                static::bypassRouteNames(),
                \true
            ) ||
            \in_array(
                trim(\parse_url(\URL::current(), PHP_URL_PATH), ' /'),
                array_map(
                    fn ($item) => trim($item, ' /'),
                    static::bypassUri()
                ),
                \true
            )
        ) {
            return $next($request);
        }

        $arrayContains = function (string $currentPath) {
            $currentPath = trim($currentPath, ' /');
            $haystack = \array_filter(
                static::bypassUri(),
                fn ($item) => \str_ends_with($item, '*') || \str_starts_with($item, '*')
            );

            foreach ($haystack as $item) {
                if (\str_ends_with($item, '*') && \str_starts_with($item, '*')) {
                    if (\str_contains($currentPath, trim($item, ' /*'))) {
                        return true;
                    }
                }

                if (\str_ends_with($item, '*')) {
                    if (\str_starts_with($currentPath, trim($item, ' /*'))) {
                        return true;
                    }
                }

                if (\str_starts_with($item, '*')) {
                    if (\str_ends_with($currentPath, trim($item, ' /*'))) {
                        return true;
                    }
                }
            }

            return false;
        };

        if ($arrayContains(trim(\parse_url(\URL::current(), PHP_URL_PATH), ' /'))) {
            return $next($request);
        }

        if (\session('impersonated_tenant') && Tenant::getByIdAndCache(\session('impersonated_tenant'))) {
            return $next($request);
        }

        \abort(
            static::getAbortCode(404),
            static::getAbortMessage(),
        );

        return $next($request);
    }

    /**
     * function tenantOrAbort
     *
     * @param Request $request
     * @return void
     */
    public function tenantOrAbort(Request $request): void
    {
        $tenancyData = \tenancy();

        if (!$tenancyData?->initialized || !$tenancyData?->tenant) {
            \abort(
                static::getAbortCode(404),
                static::getAbortMessage(),
            );
        }
    }

    /**
     * function getAbortCode
     *
     * @param ?int $defaultCode
     *
     * @return int
     */
    public static function getAbortCode(?int $defaultCode = 404): int
    {
        // TODO get via config
        $abortCode = \null;

        return (int) ($abortCode ?? $defaultCode ?? 404);
    }

    /**
     * function getAbortMessage
     *
     * @param ?string $defaultMessage
     *
     * @return string
     */
    public static function getAbortMessage(?string $defaultMessage = \null): string
    {
        // TODO get via config
        $message = null;

        return (string) ($message ?? $defaultMessage ?? __('Not found'));
    }

    /**
     * @var array<int, string>
     */
    public static function bypassRouteNames(): array
    {
        return [
            'login',
            'filament.auth.login',
        ];
    }

    /**
     * @var array<int, string>
     */
    public static function bypassUri()
    {
        return [
            '/',
            '/home',
            '*/login',
            '*/register',
            // '*create', // ends with
            // 'create*', // starts with
            // '*create*', // contains

            '*livewire*',
            '*_debugbar*',
            '*email/verify*',
            '*admin',
            '*login',
            '*logout',
            '*filament/assets*',
            '*.css',
            '*password/confirm',
            '*password/reset*',
            '*register',
            '*sanctum/csrf-cookie*',
            '*must-be-confirmed*',
        ];
    }
}
