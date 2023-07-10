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
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
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
        return __('general.orcamento_item.list_title');
    }

    public function getBreadcrumb(): ?string
    {
        return __('general.orcamento_item.list_title');
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
                ->label(__('general.orcamento_item.lei_tipo'))
                ->enum(LeiEnum::enumList(tranlate: true)),

            TextColumn::make('lei_numero')
                ->label(__('general.orcamento_item.lei_numero'))
                ->sortable()
                ->searchable(),

            TextColumn::make('lei_data')
                ->label(__('general.orcamento_item.lei_data'))
                ->sortable()
                ->date(__('general.orcamento_item.date_format')),

            TextColumn::make('content')
                ->label(__('general.orcamento_item.content'))
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
            SelectFilter::make('lei_tipo')
                ->label(__('general.orcamento_item.lei_tipo'))
                ->options(LeiEnum::enumList(tranlate: true))
                ->searchable(),

            Filter::make('lei_numero')
                ->form([
                    TextInput::make('lei_numero_val')
                        ->numeric()
                        ->label(__('general.orcamento_item.lei_numero')),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            (is_numeric($data['lei_numero_val'] ?? null) ? (int) $data['lei_numero_val'] : null),
                            fn (Builder $query, $leiNumero): Builder => $query->where('lei_numero', 'like', "{$leiNumero}%"),
                        );
                }),

            Filter::make('lei_data')
                ->form([
                    Fieldset::make('lei_data')
                        ->label(__('general.orcamento_item.lei_data'))
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    DatePicker::make('lei_data_from')
                                        ->label(__('general.from')),
                                    DatePicker::make('lei_data_until')
                                        // ->default(now())
                                        ->label(__('general.until')),
                                ]),
                        ]),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['lei_data_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('lei_data', '>=', $date),
                        )
                        ->when(
                            $data['lei_data_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('lei_data', '<=', $date),
                        );
                })->columnSpan(2),

            Filter::make('created_at')
                ->form([
                    Fieldset::make('created_at')
                        ->label(__('general.orcamento_item.created_at'))
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    DatePicker::make('created_at_from')
                                        ->label(__('general.from')),
                                    DatePicker::make('created_at_until')
                                        // ->default(now())
                                        ->label(__('general.until')),
                                ]),
                        ]),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['created_at_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                        )
                        ->when(
                            $data['created_at_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                        );
                })->columnSpan(2),
        ];
    }

    public function isTableSearchable(): bool
    {
        return true;
    }

    protected function applySearchToTableQuery(Builder $query): Builder
    {
        if (filled($searchQuery = $this->getTableSearchQuery())) {
            $query->where(function (Builder $subQuery) use ($searchQuery) {
                $subQuery = $subQuery->where('content', $searchQuery);

                if (is_numeric($searchQuery) && $searchQuery > 0) {
                    $numericSearchQuery = (int) $searchQuery;
                    $subQuery = $subQuery->orWhere('lei_numero', 'like', "{$numericSearchQuery}%");
                }

                return $subQuery;
            });
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
            ViewAction::make()
                ->modalWidth('4xl')
                ->modalHeading(__('general.orcamento_item.detail_title'))
                ->form(function () {
                    return [
                        \Filament\Forms\Components\ViewField::make('detail')
                            ->view('components.siged.orcamento-items.detail.load', [
                                'orcamento' => $this->record,
                            ])
                            ->columnSpanFull(),
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
