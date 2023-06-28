<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Orcamento;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Enums\OrcamentoTipoEnum;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TernaryFilter;
use App\Filament\Resources\TenancyBaseResource;
use App\Filament\Resources\OrcamentoResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrcamentoResource\RelationManagers;

class OrcamentoResource extends TenancyBaseResource
{
    protected static ?string $model = Orcamento::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    // protected static string | array $middlewares = [];
    // protected static bool $shouldAuthorizeWithGate = true;
    protected static bool $shouldIgnorePolicies = false;
    protected static ?bool $tenantIsRequired = true;

    protected static function getNavigationGroup(): ?string
    {
        return trans('Budgets');
    }

    protected static function getYearRange(bool $desc = true): array
    {
        return Cache::remember(
            md5(__METHOD__ . ($desc ? 'desc' : 'asc')),
            (60 * 60 * 24) /*secs*/,
            function () use ($desc) {
                $years = array_map(fn ($item) => "20{$item}", range(10, date('y') + 4));

                if ($desc) {
                    rsort($years, SORT_NUMERIC);
                }

                $years = array_combine($years, $years);

                return $years;
            }
        );
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        Forms\Components\Select::make('tipo')
                            ->reactive()
                            ->label(__('general.orcamento.tipo'))
                            ->options(OrcamentoTipoEnum::enums(tranlate: true))
                            ->required(),

                        Forms\Components\Select::make('ano_vigencia_inicio')
                            ->options(static::getYearRange())
                            ->preload()
                            ->label(__('general.orcamento.ano_vigencia_inicio'))
                            ->required(),

                        Forms\Components\Select::make('ano_vigencia_fim')
                            ->options(static::getYearRange())
                            ->preload()
                            ->label(__('general.orcamento.ano_vigencia_fim'))
                            ->visible(fn (callable $get) => $get('tipo') == OrcamentoTipoEnum::PPA)
                            ->required(fn (callable $get) => $get('tipo') == OrcamentoTipoEnum::PPA),
                    ]),

                Forms\Components\Toggle::make('ative')
                    ->label(__('general.orcamento.ative')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('general.created_at'))
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->dateTime(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('general.updated_at'))
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->dateTime(),

                Tables\Columns\TextColumn::make('tipo')
                    ->formatStateUsing(fn ($state) => str(OrcamentoTipoEnum::get($state))->limit(3, ''))
                    ->tooltip(fn (?Model $record) => $record ? OrcamentoTipoEnum::get($record?->tipo) : '')
                    ->sortable()
                    ->label(__('general.orcamento.tipo')),

                Tables\Columns\TextColumn::make('ano_vigencia_inicio')
                    ->sortable()
                    ->searchable(isIndividual: true)
                    ->label(__('general.orcamento.ano_vigencia_inicio')),

                Tables\Columns\TextColumn::make('ano_vigencia_fim')
                    ->sortable()
                    ->searchable(isIndividual: true)
                    ->label(__('general.orcamento.ano_vigencia_fim')),

                Tables\Columns\IconColumn::make('ative')
                    ->label(__('general.orcamento.ative'))
                    ->boolean(),
            ])
            ->filters([
                // https://filamentphp.com/docs/2.x/tables/filters#custom-filter-formshttps://filamentphp.com/docs/2.x/tables/filters#custom-filter-forms
                // SelectFilter::make('ano_vigencia_inicio')
                //     ->label(__('general.orcamento.filter.ano_vigencia_inicio'))
                //     ->options(static::getYearRange('desc'))
                //     ->query(function (Builder $query, $data): Builder {
                //         return $query->whereDate('ano_vigencia_inicio', $data['ano_vigencia_inicio']);
                //     }),

                // Filter::make('is_featured')->query(fn (Builder $query): Builder => $query->where('is_featured', true)),

                Filter::make('ano_vigencia')
                    ->form([
                        Forms\Components\Select::make('ano_vigencia_inicio')->options(static::getYearRange('desc')),
                        Forms\Components\Select::make('ano_vigencia_fim')->options(static::getYearRange('desc')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['ano_vigencia_inicio'],
                                fn (Builder $query, $date): Builder => $query->where('ano_vigencia_inicio', '>=', $date),
                            )
                            ->when(
                                $data['ano_vigencia_fim'],
                                fn (Builder $query, $date): Builder => $query->where('ano_vigencia_fim', '<=', $date),
                            );
                    }),

                Filter::make('tipo')
                    ->label(__('general.orcamento.tipo'))
                    ->form([
                        Forms\Components\Checkbox::make('tipo_ldo')
                            ->label(__('general.orcamento.filter.tipo_ldo')),
                        Forms\Components\Checkbox::make('tipo_loa')
                            ->label(__('general.orcamento.filter.tipo_loa')),
                        Forms\Components\Checkbox::make('tipo_ppa')
                            ->label(__('general.orcamento.filter.tipo_ppa')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['tipo_ldo'],
                                fn (Builder $query): Builder => $query->where('tipo', OrcamentoTipoEnum::LDO),
                            )
                            ->when(
                                $data['tipo_loa'],
                                fn (Builder $query): Builder => $query->where('tipo', OrcamentoTipoEnum::LOA),
                            )
                            ->when(
                                $data['tipo_ppa'],
                                fn (Builder $query): Builder => $query->where('tipo', OrcamentoTipoEnum::PPA),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrcamentos::route('/'),
            'create' => Pages\CreateOrcamento::route('/create'),
            'edit' => Pages\EditOrcamento::route('/{record}/edit'),
        ];
    }
}
