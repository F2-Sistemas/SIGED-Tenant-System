<?php

namespace App\Filament\Resources\OrcamentoResource\Pages;

use App\Filament\Resources\OrcamentoResource;
use Filament\Resources\Pages\ViewRecord;

class ViewOrcamento extends ViewRecord
{
    protected static string $resource = OrcamentoResource::class;

    protected static string $view = 'filament.resources.user-resource.pages.view-user';

    protected function getActions(): array
    {
        return [];
    }

    protected function getTitle(): string
    {
        return '';
    }
}
