<?php

namespace App\Filament\Resources\OrcamentoResource\Pages;

use App\Enums\LeiEnum;
use App\Models\Orcamento;
use App\Models\OrcamentoItem;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\Card;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\OrcamentoResource;
use Filament\Tables\Concerns\InteractsWithTable;

class ListOrcamentoItems extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = OrcamentoResource::class;

    protected static string $view = 'filament.resources.user-resource.pages.list-activities-user';

    public Orcamento $record;

    protected function getShieldRedirectPath(): string
    {
        return redirect()->back()->getTargetUrl();
    }

    public function hasTableColumnSearches(): bool
    {
        return true;
    }

    protected function getTitle(): string
    {
        return '';
    }

    public function getBreadcrumb(): ?string
    {
        return trans("Mange OrcamentoItem");
    }

    protected function getTableQuery(): Builder
    {
        return OrcamentoItem::query()->where([
            // ['subject_type', '=', OrcamentoItem::class],
            ['orcamento_id', '=', $this->record->id],
        ]);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('lei_tipo')
                ->enum(LeiEnum::enumList(tranlate: true)),

            TextColumn::make('lei_numero'),
            TextColumn::make('lei_data')
                ->date('d/m/Y'),
            TextColumn::make('content')
                ->tooltip(fn (?Model $record) => $record?->content)
                ->limit(40),

            // TextColumn::make('event'),
            // TextColumn::make('subject_type')->label('Subject')
            // ->description(fn (Activity $record) => $record->subject_id),

            TextColumn::make('id')
                ->toggleable()
                ->toggledHiddenByDefault(),

            TextColumn::make('created_at')
                ->toggleable()
                ->toggledHiddenByDefault(),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            SelectFilter::make('log_name')
                ->options([
                    'Resource' => 'Resource',
                    'Access' => 'Access',
                ])
                ->searchable(),
            SelectFilter::make('event')
                ->options([
                    'Created' => 'Created',
                    'Updated' => 'Updated',
                    'Login' => 'Login',
                ])
                ->searchable(),

            Filter::make('created_at')
                ->form([
                    DatePicker::make('created_from')->label(trans('From Date')),
                    DatePicker::make('created_until')->label(trans('To Date'))->default(now()),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['created_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                        )
                        ->when(
                            $data['created_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                        );
                })
        ];
    }

    public function isTableSearchable(): bool
    {
        return true;
    }

    protected function applySearchToTableQuery(Builder $query): Builder
    {
        if (filled($searchQuery = $this->getTableSearchQuery())) {
            $query->where('event', $searchQuery);
        }

        return $query;
    }

    protected function getTableFiltersFormColumns(): int
    {
        return 2;
    }

    protected function getTableActions(): array
    {
        return [
            ViewAction::make()->form(function () {
                return [
                    TextInput::make('id'),
                    TextInput::make('log_name'),
                    TextInput::make('event'),
                    TextInput::make('description'),
                    TextInput::make('subject_type'),
                    TextInput::make('subject_id'),
                    TextInput::make('causer_type')
                    // ->view('components.alerts.warning')
                    ,
                    // Card::make()
                    //     ->statePath('currency')
                    //     ->schema([
                    //         TextInput::make('code'),
                    //         TextInput::make('name'),
                    //         TextInput::make('symbol'),
                    //     ]),
                    TextInput::make('created_at'),
                    TextInput::make('updated_at'),
                ];
            }),
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('id'),
            TextInput::make('log_name'),
        ];
    }
}
