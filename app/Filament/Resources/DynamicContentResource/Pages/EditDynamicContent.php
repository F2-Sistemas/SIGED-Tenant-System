<?php

namespace App\Filament\Resources\DynamicContentResource\Pages;

use App\Filament\Resources\DynamicContentResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDynamicContent extends EditRecord
{
    protected static string $resource = DynamicContentResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
