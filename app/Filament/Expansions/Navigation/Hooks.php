<?php

namespace App\Filament\Expansions\Navigation;

use Filament\Facades\Filament;
use Illuminate\Contracts\View\View;
use App\Filament\Expansions\Navigation\Navigation;

class Hooks
{
    /**
     * function renderHooks
     *
     * @return void
     */
    public static function renderHooks(): void
    {
        Filament::registerRenderHook(
            'head.end',
            fn (): View => view('customizations.head-end'),
        );

        Filament::registerRenderHook(
            'global-search.start',
            fn (): View => view(
                'tenants.impersonation-banner', [
                    'impersonatedTenant' => Navigation::getImpersonatedTenant(),
                ]
            ),
        );
    }
}
