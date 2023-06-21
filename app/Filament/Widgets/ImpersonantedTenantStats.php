<?php

namespace App\Filament\Widgets;

use App\Models\Tenant;
use Filament\Facades\Filament;
use Illuminate\Support\HtmlString;
use Illuminate\Contracts\View\View;
use App\Helpers\ImpersonateTenantHelpers;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Spatie\Html\Facades\Html;

class ImpersonantedTenantStats extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        $user = Filament::auth()->user();

        return $user
            && !$user?->tenant
            && $user->can('view-tenant-list')
            && ImpersonateTenantHelpers::hasTenantOnSession($user);
    }

    /**
     * getCards function
     *
     * @return array|string|Illuminate\Contracts\Support\Htmlable|Card[]
     */
    protected function getCards(): array
    {
        $tenant = ImpersonateTenantHelpers::getImpersonatedTenant();

        return [
            \Filament\Widgets\StatsOverviewWidget\Card::make(
                __('general.tenant.impersonated_as', [
                    'tenant' => '',
                ]),
                $tenant?->id
            )
                ->color('danger')
                ->description(
                    Html::div('')
                        ->class([
                            'h-12 flex items-center space-x-4 rtl:space-x-reverse',
                        ])
                        ->children(
                            Html::element('h1')
                                ->class('text-lg sm:text-xl font-bold tracking-tight')
                        )
                        ->children(
                            Html::a(
                                route('end-impersonated-tenant'),
                                __('general.tenant.remove_impersonated')
                            )
                                ->class([
                                    'text-gray-600 hover:text-primary-500 outline-none focus:underline',
                                    'dark:text-gray-300 dark:hover:text-primary-500' => config(
                                        'filament.dark_mode'
                                    ),
                                ])
                        )
                ),
            // \Filament\Widgets\StatsOverviewWidget\Card::make('Unique views', '192.1k'),
            new HtmlString('<strong></strong>'),
            // view('tenants.impersonated', [
            //     'tenant' => $tenant,
            // ]),
        ];
    }
}
