<?php

namespace App\Filament\Resources\OrcamentoResource\Pages;

use App\Filament\Resources\OrcamentoResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrcamento extends EditRecord
{
    protected static string $resource = OrcamentoResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
