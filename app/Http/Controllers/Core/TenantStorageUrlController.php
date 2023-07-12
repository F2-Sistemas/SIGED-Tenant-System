<?php

declare(strict_types=1);

namespace App\Http\Controllers\Core;;

use Throwable;
use App\Helpers\TenantHelpers;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\InitializeUserTenant;
use App\Http\Middleware\InitializeImpersonatedTenant;

class TenantStorageUrlController extends Controller
{
    public static \Closure|array|string $tenancyMiddleware = [
        InitializeImpersonatedTenant::class,
        InitializeUserTenant::class,
    ];

    public function __construct()
    {
        $this->middleware(static::$tenancyMiddleware);
    }

    public function getStorageFile($tenantId, $path = null)
    {
        abort_if($path === null, 404);

        try {
            if (!$tenantId) {
                abort(404);
            }

            $filePath = TenantHelpers::storagePath($tenantId, $path);

            if (!file_exists($filePath)) {
                abort(404);
            }

            return response()->file($filePath);
        } catch (Throwable $th) {
            abort(404);
        }
    }

    /**
     * function routes
     *
     * @return void
     */
    public static function routes(): void
    {
        Route::get('/tn_storage/{tenantId}/{path?}', [static::class, 'getStorageFile'])
            ->where('path', '(.*)')
            ->name('tenant.storage_file');
    }
}
