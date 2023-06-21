<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\ServiceProvider;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationBuilder;

class PainelNavigationServiceProvider extends ServiceProvider
{
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

            NavigationItem::make('impersonated_as')
                ->label(
                    __('general.tenant.acting_as', [
                        'tenant' => tenant('id'),
                    ])
                )
                ->icon('carbon-dashboard')
                ->isActiveWhen(fn () => request()->routeIs("filament.pages.*"))
                ->badge(100, color: 'primary')
                // ->visible(fn () => !tenant())
                ->hidden(fn () => !tenant()) // TODO validate impersonation
                ->url(route('filament.pages.dashboard'))
            ,
        ];
    }
}
