<?php

namespace App\Providers;

use App\Filament\Expansions\Assets\AssetLoader;
use App\Filament\Expansions\Navigation\Navigation;
use App\Models\Tenant;
use Illuminate\Support\ServiceProvider;

class FilamentBootLoaderServiceProvider extends ServiceProvider
{
    protected static ?Tenant $impersonatedTenant = null;

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        AssetLoader::beforeCoreScripts();
        AssetLoader::afterCoreScripts();
        Navigation::bootItems();
    }
}
