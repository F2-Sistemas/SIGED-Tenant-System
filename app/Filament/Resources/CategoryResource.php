<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Category;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\CategoryResource\Pages;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'Blog';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label(__('resources.category.title'))
                    ->unique(Category::class, 'title')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('resources.category.title'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('posts_count')
                    ->label(__('resources.category.posts_count'))
                    ->toggleable()
                    ->toggledHiddenByDefault(false)
                    ->counts('posts'),

                Tables\Columns\TextColumn::make('published_posts_count')
                    ->label(__('resources.category.published_posts_count'))
                    ->toggleable()
                    ->toggledHiddenByDefault(false)
                    ->counts([
                        'posts as published_posts_count' => function (\Illuminate\Database\Eloquent\Builder $query) {
                            $query->whereNotNull('published_at');
                        },
                    ]),

                // Tables\Columns\TextColumn::make('published_posts_count')->counts([
                //     'posts' => fn ($query) => $query->whereNotNull('published_at'),
                // ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('resources.category.created_at'))
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->dateTime()
                    ->sortable(),
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

    public static function getRelations(): array
    {
        return [
            CategoryResource\RelationManagers\PostsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('resources.category.label.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resources.category.label.plural');
    }
}
