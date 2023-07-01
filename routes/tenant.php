<?php

declare(strict_types=1);

use App\Models\Post;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get(
        '/',
        fn () => 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id')
    )->name('tenant.root.path');
});

Route::middleware([
    'web',
])->group(function () {
    Route::get(
        '/{tenantId}/posts/{postSlug}',
        fn ($tenantId, $postSlug) => tenancy()->find($tenantId)?->run(function () use ($tenantId, $postSlug) {
            // Your actual command code
            return "{$tenantId} {$postSlug} " . tenant('id') . ' ' . Post::whereSlug($postSlug)->select('slug')->first()?->slug;
        }) ?? abort(404)
    )->name('tenant.posts.show');
});
