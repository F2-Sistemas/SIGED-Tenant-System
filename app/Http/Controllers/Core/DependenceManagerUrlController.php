<?php

declare(strict_types=1);

namespace App\Http\Controllers\Core;

use Throwable;
use Illuminate\Http\Request;
use App\Helpers\TenantHelpers;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Route;

class DependenceManagerUrlController extends Controller
{
    public function getStaticFile(Request $request, string $path = null)
    {
        $allowedPaths = static::allowedPaths($request);

        abort_if(!$allowedPaths || !$path || !in_array($path, array_keys($allowedPaths), true), 404);

        $fileInfo = $allowedPaths[$path] ?? null;
        $filePath = $fileInfo['path'] ?? null;
        $can = $fileInfo['can'] ?? null;
        $enabled = boolval($fileInfo['enabled'] ?? true);

        if (!$enabled || !$filePath || !file_exists($filePath)) {
            abort(404);
        }

        if (is_a($can, 'Closure') && !$can()) {
            abort(404);
        }

        try {
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
        Route::get('/pkgman-static/{path?}', [static::class, 'getStaticFile'])
            ->where('path', '(.*)')
            ->name('pkgman.static_file');
    }

    /**
     * function allowedPaths
     *
     * @param Request $request
     *
     * @return array
     */
    protected static function allowedPaths(Request $request): array
    {
        $nodeModules = fn(string $path) => base_path("node_modules/{$path}");

        $composer = fn(string $path) => base_path("vendor/{$path}");

        /**
         * 'some-file.js' => [
         *      'path' => base_path('node_modules/xyz/dist/some-file.js'),
         *      'can' => Closure|null
         *      'enabled' => bool
         * ]
         */
        return [
            // 'some-file.js' => [
            //      'path' => base_path('node_modules/xyz/dist/some-file.js'),
            //      'can' => Closure|null
            //      'enabled' => bool
            // ],
        ];
    }
}
