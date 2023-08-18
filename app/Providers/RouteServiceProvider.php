<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Fluent;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            $this->mapApiRoutes();
            $this->mapWebRoutes();
            $this->mapTenantStaticRoutes();
            $this->mapTenantByDomainRoutes();
        });
    }

    protected function configureRateLimiting()
    {
        RateLimiter::for('api', fn (
            Request $request
        ) => Limit::perMinute(60)->by($request->user()?->id ?: $request->ip()));
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));

        foreach ($this->centralDomains() as $domain) {
            Route::middleware('web')
                ->domain($domain)
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        }

        Route::middleware('web')
            ->group(base_path('routes/auth.php'));

        if (config('public-web.routes.enabled')) {
            Route::middleware('web')
                ->group(base_path('routes/public-web.php'));
        }
    }

    protected function mapApiRoutes()
    {
        foreach ($this->centralDomains() as $domain) {
            Route::prefix('api')
                ->domain($domain)
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));
        }
    }

    protected function mapTenantStaticRoutes()
    {
        foreach ($this->centralDomains() as $domain) {
            Route::domain($domain)
                ->middleware([
                    'api',
                    'web',
                ])
                ->namespace($this->namespace)
                ->group(base_path('routes/tenant.php'));
        }
    }

    protected function mapTenantByDomainRoutes()
    {
        $basePathRoute = base_path('routes/tenant_by_domain.php');

        foreach ([
            [
                'prefix' => '/',
                'middlewares' => [
                    'web',
                    'tenant_by_domain',
                    'tenant_is_required',
                ],
                'name' => '/',
            ],
            [
                'prefix' => 'api',
                'middlewares' => [
                    'api',
                    'tenant_by_domain',
                    'tenant_is_required',
                ],
                'name' => 'api',
            ],
        ] as $item) {
            $item = new Fluent($item);
            $name = str($item->name ?: '')->slug()->toString();

            Route::middleware($item->middlewares ?: [])
                ->prefix($item->prefix ?: '')
                ->name($name ? $name . '.' : '')
                ->namespace($this->namespace)
                ->group($basePathRoute);
        }
    }

    protected function centralDomains(): array
    {
        return config('tenancy.central_domains');
    }
}
