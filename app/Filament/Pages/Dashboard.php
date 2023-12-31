<?php

namespace App\Filament\Pages;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;
use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?int $navigationSort = -2;
    protected static string $view = 'filament::pages.dashboard';

    public function mount()
    {
        //
    }

    protected static function getNavigationLabel(): string
    {
        return static::$navigationLabel ?? static::$title ?? __('filament::pages/dashboard.title');
    }

    public static function getRoutes(): Closure
    {
        return function () {
            Route::get('/', static::class)->name(static::getSlug());
        };
    }

    protected function getWidgets(): array
    {
        // return Filament::getWidgets();

        return [
            \Filament\Widgets\AccountWidget::class,
            \App\Filament\Widgets\ImpersonantedTenantStats::class,
            \App\Filament\Widgets\TenantList::class,
        ];
    }

    protected function getColumns(): int | string | array
    {
        return 2;
    }

    protected function getTitle(): string
    {
        return static::$title ?? __('filament::pages/dashboard.title');
    }
}
