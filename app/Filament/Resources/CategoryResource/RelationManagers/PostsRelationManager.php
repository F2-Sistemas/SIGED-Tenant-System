<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use App\Filament\Resources\PostResource;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return PostResource::form($form);
    }

    public static function table(Table $table): Table
    {
        return PostResource::table($table);
    }
}
