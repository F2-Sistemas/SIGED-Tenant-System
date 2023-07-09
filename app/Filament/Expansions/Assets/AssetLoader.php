<?php

namespace App\Filament\Expansions\Assets;

use Filament\Facades\Filament;

class AssetLoader
{
    /**
     * function beforeCoreScripts
     *
     * @return void
     */
    public static function beforeCoreScripts(): void
    {
        // https://filamentphp.com/docs/2.x/admin/appearance#including-frontend-assets
        Filament::registerScripts([
            // 'https://cdn.jsdelivr.net/npm/@ryangjchandler/alpine-tooltip@0.x.x/dist/cdn.min.js',
            // 'https://unpkg.com/@victoryoalli/alpinejs-screen@1.0.0/dist/screen.min.js',
            // vite_asset('resources/js/before-head-end.js'),
        ], true);
    }

    /**
     * function afterCoreScripts
     *
     * @return void
     */
    public static function afterCoreScripts(): void
    {
        // https://filamentphp.com/docs/2.x/admin/appearance#including-frontend-assets
        Filament::registerScripts([
            // vite_asset('resources/js/before-head-end.js'),
        ], false);
    }
}
