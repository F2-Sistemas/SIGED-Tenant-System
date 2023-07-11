<?php

namespace App\Filament\Resources\OrcamentoResource\Pages;

use App\Filament\Resources\OrcamentoResource;
use Filament\Resources\Pages\EditRecord;

class EditOrcamentoItem extends EditRecord
{
    protected static string $resource = OrcamentoResource::class;

    protected static string $view = 'filament.resources.user-resource.pages.edit-user';

    protected function getActions(): array
    {
        return [];
    }
}
