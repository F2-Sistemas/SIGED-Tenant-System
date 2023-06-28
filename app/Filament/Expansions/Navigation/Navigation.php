<?php

namespace App\Filament\Expansions\Navigation;

use App\Models\User;
use App\Models\Tenant;
use Filament\Facades\Filament;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Filament\Navigation\UserMenuItem;
use Filament\Navigation\NavigationItem;
use Filament\Navigation\NavigationGroup;
use App\Helpers\ImpersonateTenantHelpers;
use Filament\Navigation\NavigationBuilder;

class Navigation
{
    protected static ?Tenant $impersonatedTenant = null;

    /**
     * getUser function
     *
     * @return User|null
     */
    public static function getUser(): ?User
    {
        return Auth::user() ?? Filament::auth()?->user();
    }

    /**
     * getImpersonatedTenant function
     *
     * @return Tenant|null
     */
    public static function getImpersonatedTenant(): ?Tenant
    {
        return static::$impersonatedTenant ??= ImpersonateTenantHelpers::getImpersonatedTenant(static::getUser());
    }

    /**
     * Bootstrap services.
     */
    public static function bootItems(): void
    {
        Hooks::renderHooks();

        Filament::serving(function () {
            Filament::registerUserMenuItems([
                UserMenuItem::make()
                    ->label('Settings')
                    ->url(route('filament.pages.settings.index'))
                    ->icon('heroicon-s-cog'),
                // ...
            ]);
        });

        Filament::serving(function () {
            Filament::registerUserMenuItems([
                'account' => UserMenuItem::make()->url(route('filament.pages.account-settings.index')),
                // ...
            ]);
        });

        Filament::navigation(function (NavigationBuilder $builder): NavigationBuilder {
            $menuItems = \collect(static::filamentManager()->getResources())
                ->filter(function ($item) {
                    return in_array(
                        $item,
                        (array) config('navigation.enabled_resources', []),
                        true
                    );
                })
                ->map(fn ($item) => call_user_func_array([$item, 'getNavigationItems'], []));

            foreach (static::staticMenuItems() as $staticItem) {
                if ($staticItem->isHidden()) {
                    continue;
                }

                $builder->item($staticItem);
            }

            return $builder->items([
                // ...static::staticMenuItems(),
                ...$menuItems->flatten()->all(),
            ]);

            // return $builder
            //     ->groups([
            //         NavigationGroup::make('Website')
            //             ->items([]),
            //     ]);
        });
    }

    /**
     * function filamentManager
     */
    public static function filamentManager(): \Filament\FilamentManager
    {
        /**
         * @var \Filament\FilamentManager
         */
        return app('filament');
    }

    /**
     * function staticMenuItems
     *
     * @return NavigationItem[]
     */
    public static function staticMenuItems(): array
    {
        // vendor/filament/filament/src/Resources/Resource.php ~ 97
        return  [
            NavigationItem::make('dashboard')
                ->label(__('filament::pages/dashboard.title'))
                ->icon('carbon-dashboard')
                ->isActiveWhen(fn () => request()->routeIs(
                    'filament.pages.dashboard.*',
                    'filament.pages.dashboard',
                ))
                ->url(route('filament.pages.dashboard')),
        ];
    }
}
