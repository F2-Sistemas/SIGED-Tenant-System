<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Models\User;
use App\Enums\UserStatusEnum;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use App\Filament\Resources\UserResource;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\HasFormActions;
use App\Filament\Resources\UserResource\Widgets\UserClosedWidget;
use App\Filament\Resources\UserResource\Widgets\UserStatusWidget;

class ManageUser extends Page
{
    use HasFormActions;

    protected static string $resource = UserResource::class;

    protected static string $view = 'filament.resources.user-resource.pages.manage-user';

    public $status;
    public $reason;

    public User $record;

    protected function getShieldRedirectPath(): string
    {
        return redirect()->back()->getTargetUrl();
    }

    public function getBreadcrumb(): ?string
    {
        return __("Manage User");
    }

    protected function getFormActions(): array
    {
        if ($this->record->status != UserStatusEnum::INACTIVE) {
            return [
                $this->getSaveFormAction(),
                $this->getCancelFormAction(),
            ];
        }

        return [];
    }

    protected function getSaveFormAction(): Action
    {
        return Action::make('save')
            ->label(__('filament::resources/pages/edit-record.form.actions.save.label'))
            ->submit('save')
            ->keyBindings(['mod+s']);
    }

    protected function getCancelFormAction(): Action
    {
        return Action::make('cancel')
            ->label(__('filament::resources/pages/edit-record.form.actions.cancel.label'))
            ->url($this->previousUrl ?? static::getResource()::getUrl())
            ->color('secondary');
    }

    protected function getTitle(): string
    {
        return '';
    }

    protected function getFormSchema(): array
    {
        return [
            Section::make(__('Manage User'))
                ->schema([
                    Select::make('status')->label(__('Status'))
                        ->options(function () {
                            return [
                                ...UserStatusEnum::enums(false, true),
                                $this->record->status => UserStatusEnum::getValue($this->record->status, true)
                                    . ' (current)'
                            ];
                        })
                        // ->searchable()
                        ->required(),
                    Textarea::make('reason')->label(__('Reason'))
                        ->required()
                        ->minLength(5)
                ])
        ];
    }

    public function save(): void
    {
        $this->validate();

        DB::transaction(function () {
            $oldStatus = $this->record->status;

            $statusExists = UserStatusEnum::enumExists($this->status);

            if (!$statusExists) {
                return;
            }

            $this->record->updateStatus($this->status);

            activity()
                ->causedBy(auth()->user())
                ->performedOn($this->record)
                ->event('manage')
                ->withProperties([
                    'status' => [
                        'old_value' => $oldStatus,
                        'new_value' => $this->status,
                    ]
                ])
                ->log($this->reason);
        });

        unset($this->status);
        unset($this->reason);

        Notification::make()
            ->title(__('Saved successfully'))
            ->success()
            ->send();
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // UserStatusWidget::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            // UserClosedWidget::class,
        ];
    }

    protected function getHeaderWidgetsColumns(): int | array
    {
        return 1;
    }

    protected function getFooterWidgetsColumns(): int | array
    {
        return 1;
    }
}
