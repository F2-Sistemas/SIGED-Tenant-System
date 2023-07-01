<?php

namespace App\Filament\Resources;

use App\Models\Post;
use Filament\Tables;
use Illuminate\Support\Str;
use Filament\Resources\Form;
use Filament\Resources\Table;
// use Filament\Resources\Resource;
use App\Filament\Resources\TenancyBaseResource as Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\PostResource\Pages;
use Filament\Forms\Components\RichEditor;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = 'Blog';
    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->required()
                    ->disabled()
                    ->unique(Post::class, 'slug', fn ($record) => $record),
                RichEditor::make('content')
                    ->nullable()
                    ->columnSpan(2),
                DateTimePicker::make('published_at')
                    ->label('Published Date & Time')
                    ->nullable(),
                Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'title')
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\IconColumn::make('published_at')
                    ->label('Published')
                    ->sortable()
                    ->default(fn ($record) => $record->published)
                    ->trueColor('success')
                    ->falseColor('danger'),
                Tables\Columns\TextColumn::make('category.title'),
            ])
            ->filters([
                Tables\Filters\Filter::make('published')
                    ->label('Published')
                    ->query(fn ($query) => $query->whereNotNull('published_at')),
                Tables\Filters\Filter::make('with_category')
                    ->label('With category')
                    ->query(fn ($query) => $query->whereNotNull('category_id')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('category.title'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
            'show' => Pages\ViewPost::route('/{record}/show'),
        ];
    }
}
