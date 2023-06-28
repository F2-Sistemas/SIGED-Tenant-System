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
use App\Filament\Traits\NavigationCollectResource;

class Navigation
{
    protected static ?Tenant $impersonatedTenant = null;
    protected static array $menuItems = [
        'withoutGroups' => [],
        'groups' => [],
    ];

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

    public static function mapItems($navigationItems) : void
    {
        foreach (($navigationItems ?? []) as $navigationItem) {
            $group = $navigationItem->getGroup();
            if (!$group) {
                static::$menuItems['withoutGroups'][] = $navigationItem;
                continue;
            }

            static::$menuItems['groups'][$group][] = $navigationItem;
        }
    }

    /**
     * Bootstrap services.
     */
    public static function bootItems(): void
    {
        Hooks::renderHooks();

        Filament::serving(function () {
            Filament::registerNavigationGroups([
                ...static::registerGroups(),
                // ...
            ]);

            Filament::registerUserMenuItems([
                UserMenuItem::make()
                    ->label(__('Settings'))
                    ->url(route('filament.pages.settings.index'))
                    ->icon('heroicon-s-cog'),
                // ...
            ]);

            Filament::registerUserMenuItems([
                'account' => UserMenuItem::make()->url(route('filament.pages.account-settings.index')),
                // ...
            ]);
        });

        Filament::navigation(function (NavigationBuilder $builder): NavigationBuilder {
            foreach (config('navigation.enabled_resources', static::filamentManager()->getResources()) as $item) {
                static::mapItems(call_user_func([$item, 'getNavigationItems']));
            }

            static::mapItems(static::staticMenuItems());

            // \App\Filament\Resources\UserResource::registerNavigationItems();

            $builder->items(static::$menuItems['withoutGroups'] ?? []);

            foreach(static::$menuItems['groups'] as $groupName => $groupItems) {
                $builder->group($groupName, $groupItems, true);
            }

            return $builder;
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

            NavigationItem::make('Analytics')
            ->url('https://filament.pirsch.io', shouldOpenInNewTab: true)
            ->icon('heroicon-o-presentation-chart-line')
            ->activeIcon('heroicon-s-presentation-chart-line')
            ->group('Reports')
            ->sort(3),
        ];
    }

    /**
     * function registerGroups
     *
     * @return array
     */
    public static function registerGroups(): array
    {
        return [
            NavigationGroup::make()
                ->label('Shop')
                ->icon('heroicon-s-shopping-cart'),
            NavigationGroup::make()
                ->label('Blog')
                ->icon('heroicon-s-pencil'),
            NavigationGroup::make()
                ->label('Settings')
                ->icon('heroicon-s-cog')
                ->collapsed(),
            NavigationGroup::make()
                ->label('Reports')
                ->icon('heroicon-o-presentation-chart-line') //'heroicon-s-presentation-chart-line'
                ->collapsed(),
        ];
    }
}
