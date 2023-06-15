<?php

namespace App\Filament\Resources\DynamicContentResource\Pages;

use App\Filament\Resources\DynamicContentResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDynamicContents extends ListRecords
{
    protected static string $resource = DynamicContentResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
