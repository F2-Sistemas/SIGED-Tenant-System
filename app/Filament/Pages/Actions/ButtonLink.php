<?php

namespace App\Filament\Pages\Actions;

use Closure;
use Filament\Pages\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Filament\Support\Actions\Concerns\CanCustomizeProcess;
use Filament\Support\Actions\Concerns\InteractsWithRecord;

class ButtonLink extends Action
{
    // use CanCustomizeProcess;
    use InteractsWithRecord;

    public static function getDefaultName(): ?string
    {
        return 'external-link';
    }

    public function getAction(): ?Closure
    {
        $this->record($this->getLivewire()?->record);

        return parent::getAction();
    }

    public function getRecord(): ?Model
    {
        return parent::getRecord() ?? $this->record;
    }
}
