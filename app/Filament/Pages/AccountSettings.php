<?php

namespace App\Filament\Pages;

use Closure;
use Illuminate\Support\Facades\Route;
use Filament\Pages\Page;

class AccountSettings extends Page
{
    protected static ?string $slug = 'account-settings';

    public function mount()
    {
        parent::mount();
    }

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?int $navigationSort = -2;

    protected static string $view = 'filament::pages.dashboard';

    protected static function getNavigationLabel(): string
    {
        return static::$navigationLabel ?? static::$title ?? __('general.pages.account_settings.title');
    }

    public static function getRoutes(): Closure
    {
        return function () {
            Route::prefix(static::getSlug())->group(function () {
                Route::get('/', static::class)->name(static::getSlug() . '.index');
            });
        };
    }

    protected function getWidgets(): array
    {
        return [
            \Filament\Widgets\AccountWidget::class,
            \Filament\Widgets\AccountWidget::class,
        ];
    }

    protected function getColumns(): int | string | array
    {
        return 2;
    }

    protected function getTitle(): string
    {
        return static::$title ?? __('general.pages.account_settings.title');
    }
}
