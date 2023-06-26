<?php

namespace App\Filament\Widgets;

use App\Models\Tenant;
use Spatie\Html\Facades\Html;
use Filament\Facades\Filament;
use Illuminate\Support\HtmlString;
use Illuminate\Contracts\View\View;
use App\Helpers\ImpersonateTenantHelpers;
use App\Traits\ImpersonatedTenantHelpers;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class ImpersonantedTenantStats extends BaseWidget
{
    use ImpersonatedTenantHelpers;

    protected static ?Tenant $impersonatedTenant = null;

    public function mount()
    {
        parent::mount();
        // static::$impersonatedTenant ??= ImpersonateTenantHelpers::getImpersonatedTenant(static::getUser());
    }

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
        if (!ImpersonateTenantHelpers::canViewItem(static::getUser(), true)) {
            return [];
        }

        $tenant = ImpersonateTenantHelpers::getImpersonatedTenant();

        return [
            // \Filament\Widgets\StatsOverviewWidget\Card::make(
            //     __('general.tenant.impersonated_as', [
            //         'tenant' => '',
            //     ]),
            //     $tenant?->id
            // )
            //     ->description(
            //     )
            //     ->extraAttributes([
            //         'class' => '', // resources/css/before-head-end.css
            //     ]),
            // \Filament\Widgets\StatsOverviewWidget\Card::make('Unique views', '192.1k'),
            // new HtmlString('<strong></strong>'),
            Card::make('impersonatedTenantCard', 'impersonatedTenant')
                ->view('tenants/impersonated', [
                    'impersonatedTenant' => $tenant,
                ]),
            // view('customizations.white-label', [
            //     'content' => Html::div()
            //         ->class([
            //             'h-6 px-2 flex items-center space-x-4 rtl:space-x-reverse',
            //         ])
            //         ->addClass('forced-style bg-danger-500')
            //         ->children(
            //             Html::element('h1')
            //                 ->class('text-lg sm:text-xl font-bold tracking-tight')
            //                 ->addClass('bg-danger-500')
            //         )
            //         ->children(
            //             Html::a(
            //                 route('end-impersonated-tenant'),
            //                 __('general.tenant.remove_impersonated')
            //             )
            //                 ->class([
            //                     'text-gray-600 hover:text-primary-500 outline-none focus:underline',
            //                     'dark:text-gray-300 dark:hover:text-primary-500' => config(
            //                         'filament.dark_mode'
            //                     ),
            //                 ])
            //         ),
            // ]),
        ];
    }
}
