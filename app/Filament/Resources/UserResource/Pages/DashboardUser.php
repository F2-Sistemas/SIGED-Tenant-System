<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Models\User;
use Filament\Resources\Pages\Page;
use App\Filament\Resources\UserResource;
use App\Filament\Resources\UserResource\Widgets\UserLastLoginWidget;
use App\Filament\Resources\UserResource\Widgets\UserProfileWidget;
use App\Filament\Resources\UserResource\Widgets\UserStatusWidget;

class DashboardUser extends Page
{
    protected static string $resource = UserResource::class;

    protected static string $view = 'filament.resources.user-resource.pages.dashboard-user';

    public User $record;

    protected function getShieldRedirectPath(): string
    {
        return redirect()->back()->getTargetUrl();
    }

    protected function getTitle(): string
    {
        return '';
    }

    public function getBreadcrumb(): ?string
    {
        return trans("User Dashboard");
    }

    protected function getHeaderWidgets(): array
    {
        return [
            UserProfileWidget::class,
            UserStatusWidget::class,
            UserLastLoginWidget::class
        ];
    }
}
