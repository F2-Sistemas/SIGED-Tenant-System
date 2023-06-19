<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
// use Filament\Resources\Resource;
use App\Filament\Resources\TenancyBaseResource as Resource;
use Spatie\Permission\Models\Role;
use Filament\Tables\Filters\Filter;
use App\Enums\UserStatusEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Spatie\Activitylog\Models\Activity;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Resources\UserResource\Pages\DashboardUser;
use App\Filament\Resources\UserResource\Pages\ListActivitiesUser;
use AymanAlhattami\FilamentPageWithSidebar\PageNavigationItem;
use AymanAlhattami\FilamentPageWithSidebar\FilamentPageSidebar;
use App\Filament\Resources\UserResource\Pages\ListUserActivitiesUser;
use Illuminate\Database\Eloquent\Model;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'manage',
            'change_password',
            'user_activities',
            'activities',
            'dashboard',
        ];
    }

    protected static function getNavigationGroup(): ?string
    {
        return trans('Users & Roles');
    }

    public static function getModelLabel(): string
    {
        return __('Users');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Users');
    }

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function sidebar(Model $record): FilamentPageSidebar
    {
        return FilamentPageSidebar::make()
            ->setTitle($record->name)
            ->setDescription($record->created_at)
            ->setNavigationItems([
                PageNavigationItem::make(__('User Dashboard'))
                    ->url(fn () => static::getUrl('dashboard', ['record' => $record->id]))->icon('heroicon-o-collection')
                    ->isActiveWhen(fn () => request()->routeIs(static::getRouteBaseName() . '.dashboard'))->isHiddenWhen(false),
                PageNavigationItem::make(__('View User'))
                    ->url(fn () => static::getUrl('view', ['record' => $record->id]))->icon('heroicon-o-collection')
                    ->isActiveWhen(fn () => request()->routeIs(static::getRouteBaseName() . '.view'))->isHiddenWhen(false),
                PageNavigationItem::make(__('Edit User'))
                    ->url(fn () => static::getUrl('edit', ['record' => $record->id]))->icon('heroicon-o-collection')
                    ->isActiveWhen(fn () => request()->routeIs(static::getRouteBaseName() . '.edit'))
                    ->isHiddenWhen(false),
                PageNavigationItem::make(__('Manage User'))
                    ->url(fn () => static::getUrl('manage', ['record' => $record->id]))->icon('heroicon-o-collection')
                    ->isActiveWhen(fn () => request()->routeIs(static::getRouteBaseName() . '.manage'))->isHiddenWhen(false),
                PageNavigationItem::make(__('Change Password'))
                    ->url(fn () => static::getUrl('password.change', ['record' => $record->id]))->icon('heroicon-o-collection')
                    ->isActiveWhen(fn () => request()->routeIs(static::getRouteBaseName() . '.password.change'))
                    ->isHiddenWhen(false),
                PageNavigationItem::make(__('User Activities'))
                    ->url(fn () => static::getUrl('activities.user', ['record' => $record->id]))->icon('heroicon-o-collection')
                    ->isActiveWhen(fn () => request()->routeIs(static::getRouteBaseName() . '.activities.user'))
                    ->isHiddenWhen(false)
                    ->badge(Activity::query()->where([['causer_type', '=', User::class], ['causer_id', '=', $record->id]])->count()),
                PageNavigationItem::make(__('Record Activities'))
                    ->url(fn () => static::getUrl('activities', ['record' => $record->id]))->icon('heroicon-o-collection')
                    ->isActiveWhen(fn () => request()->routeIs(static::getRouteBaseName() . '.activities'))
                    ->badge(Activity::query()->where([['subject_type', '=', User::class], ['subject_id', '=', $record->id]])->count())
                    ->isHiddenWhen(false)
                ,
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('User Information'))
                    ->schema([
                        Forms\Components\TextInput::make('name')->label(__('Name'))
                            ->required()
                            ->maxLength(191),
                        Forms\Components\TextInput::make('email')->label(__('Email'))
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(191),
                        Forms\Components\DateTimePicker::make('email_verified_at')->label(__('Email verified at'))
                            ->hiddenOn(['edit', 'create']),
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->required()
                            ->maxLength(191)
                            ->minLength(6)
                            ->hiddenOn(['edit', 'view']),
                        Select::make('language')->label(__('Language'))
                            ->options([
                                'en_US' => __('English'),
                                'pt_BR' => __('Portuguese Brazilian'),
                            ])
                            ->searchable()
                            ->required(),
                        Forms\Components\DateTimePicker::make('created_at')->label(__('Created at'))
                            ->hiddenOn(['create', 'edit']),
                        Forms\Components\DateTimePicker::make('updated_at')->label(__('Updated at'))
                            ->hiddenOn(['create', 'edit']),
                        Select::make('roles')->label(__('Roles'))
                            ->options(Role::pluck('name', 'id'))
                            ->multiple()
                            ->searchable()
                            ->relationship('roles', 'name')
                            ->preload()
                            ->columnSpan(2),
                        SpatieMediaLibraryFileUpload::make('avatar')->label(__('Avatar'))
                            ->columnSpan(2),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('roles')
                    ->formatStateUsing(fn (string $state): string => optional(json_decode($state))[0]?->name ?? ''),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters(
                [
                    SelectFilter::make('status')
                        ->searchable()
                        ->options([
                            UserStatusEnum::INACTIVE => UserStatusEnum::getValue(UserStatusEnum::INACTIVE),
                            UserStatusEnum::ACTIVE => UserStatusEnum::getValue(UserStatusEnum::ACTIVE),
                        ]),

                    SelectFilter::make('roles')->searchable()->relationship('roles', 'name'),

                    Filter::make('name')
                        ->form([
                            Forms\Components\TextInput::make('name'),
                        ])->query(fn (Builder $query, array $data): Builder => $query->where('name', 'like', "%{$data['name']}%")),

                    Filter::make('email')
                        ->form([
                            Forms\Components\TextInput::make('email'),
                        ])->query(fn (Builder $query, array $data): Builder => $query->where('email', 'like', "%{$data['email']}%")),

                    Filter::make('created_at')
                        ->form([
                            Forms\Components\DatePicker::make('created_from'),
                            Forms\Components\DatePicker::make('created_until')->default(now()),
                        ])->query(function (Builder $query, array $data): Builder {
                            return $query
                                ->when(
                                    $data['created_from'],
                                    fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                                )
                                ->when(
                                    $data['created_until'],
                                    fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                                );
                        }),
                ],
            )
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\Action::make('manage')->url(function (User $record) {
                //     return static::getNavigationUrl() . '/' . $record->id . '/manage';
                // }),
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            // 'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            'view' => Pages\ViewUser::route('/{record}/view'),
            'manage' => Pages\ManageUser::route('/{record}/manage'),
            'password.change' => Pages\ChangePasswordUser::route('/{record}/password/change'),
            'activities' => ListActivitiesUser::route('/{record}/activities'),
            'activities.user' => ListUserActivitiesUser::route('/{record}/activities/user'),
            'dashboard' => DashboardUser::route('/{record}/dashboard'),
        ];
    }
}
