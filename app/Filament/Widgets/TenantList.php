<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\Tenant;
use App\Enums\UserStatusEnum;
use Filament\Facades\Filament;
use Illuminate\Contracts\View\View;
use App\Helpers\ImpersonateTenantHelpers;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\TableWidget as BaseWidget;

class TenantList extends BaseWidget
{
    protected static ?int $sort = -3;
    protected int | string | array $columnSpan = 'full';
    // protected static string $view = 'filament.custom-views.widgets.table-widget';

    public static function canView(): bool
    {
        $user = Filament::auth()->user();

        return $user
            && !$user?->tenant
            && $user->can('view-tenant-list')
            && !ImpersonateTenantHelpers::hasTenantOnSession($user);
    }

    protected function getTableQuery(): Builder
    {
        return Tenant::query();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id')
                ->searchable()
                ->limit(25)
                ->label(__('ID')),
            Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->limit(25)
                ->label(__('Name')),
            Tables\Columns\TextColumn::make('email')
                ->searchable()
                ->limit(25)
                ->label(__('Email'))
                ->extraAttributes([
                    'class' => 'overflow-hidden',
                ], true),
        ];
    }

    public function getTableActions(): array
    {
        return [
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
            Tables\Actions\Action::make('impersonate')
                ->label(__('general.tenant.impersonate'))
                ->url(fn (Tenant $record) => route('impersonate-tenant', $record?->id))
                ->icon('heroicon-s-user-circle'),
        ];
    }

    protected function getTableContentGrid(): array
    {
        return [
            'md' => 4,
            'xl' => 5,
        ];
    }

    protected function getHeader(): View
    {
        return view('filament.settings.custom-header');
    }

    protected function getFooter(): View
    {
        return view('filament.settings.custom-footer');
    }

    protected function getTableBulkActions(): array
    {
        return [
            Tables\Actions\DeleteBulkAction::make(),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            Tables\Filters\Filter::make('active_users')
                ->label(__('general.users.filters.active'))
                ->query(fn ($query) => $query->where('status', UserStatusEnum::ACTIVE)),

            Tables\Filters\Filter::make('inactive_users')
                ->label(__('general.users.filters.inactive'))
                ->query(fn ($query) => $query->where('status', UserStatusEnum::INACTIVE)),

            Tables\Filters\Filter::make('validated_email')
                ->label(__('general.users.filters.validated_email'))
                ->query(fn ($query) => $query->whereNotNull('email_verified_at')),

            Tables\Filters\Filter::make('not_validated_email')
                ->label(__('general.users.filters.not_validated_email'))
                ->query(fn ($query) => $query->whereNull('email_verified_at')),
        ];
    }

    // protected function getTableContentGrid(): ?array
    // protected function getTableActionsPosition(): ?string
    // protected function getTableFiltersLayout(): ?string
    // protected function getTableHeaderActions(): array
}
