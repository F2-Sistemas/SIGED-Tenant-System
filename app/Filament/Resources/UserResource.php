<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\UserResource\Pages;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),

                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required(),

                Forms\Components\DateTimePicker::make('email_verified_at'),

                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required(fn (string $context) => $context === 'create'),

                TextInput::make('newPassword')
                ->password()
                ->reactive()
                ->hidden(fn (string $context) => $context === 'create')
                ->disabledOn('create'),

                TextInput::make('passwordConfirmation')
                    ->label(fn (string $context) => $context === 'create' ? 'Confirm password' : 'Confirm new password')
                    ->password()
                    ->required(fn (Closure $get) => !$get('newPassword') || !$get('password')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(false)
                    ->searchable(),

                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\IconColumn::make('email_verified_at')
                    ->boolean()
                    ->falseColor('danger')
                    ->trueColor('success')
                    ->getStateUsing(fn ($record) => (bool) $record->email_verified_at)
                    ->sortable()
                    ->tooltip(
                        fn ($record) => $record->email_verified_at
                            ? 'Validado em ' . now()->parse($record->email_verified_at)->format('Y-m-d H:i:s')
                            : \null
                    )
                    ->toggleable()
                    ->toggledHiddenByDefault(false),
                Tables\Columns\TextColumn::make('created_at')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->sortable()
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->sortable()
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUsers::route('/'),
        ];
    }
}
