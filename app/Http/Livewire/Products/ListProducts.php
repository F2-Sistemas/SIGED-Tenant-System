<?php

namespace App\Http\Livewire\Products;

use Filament\Tables;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Modules\Product\Entities\Product;
use Modules\Product\Enums\ProductEnum;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Concerns\InteractsWithTable;

class ListProducts extends Component implements HasTable
{
    use InteractsWithTable;

    protected function getTableQuery(): Builder
    {
        return Product::query();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')->searchable(),
            Tables\Columns\TextColumn::make('unit_type')->enum([
                ProductEnum::UNIT_TYPE_UNITY => ProductEnum::getValue(ProductEnum::UNIT_TYPE_UNITY),
                ProductEnum::UNIT_TYPE_BOX => ProductEnum::getValue(ProductEnum::UNIT_TYPE_BOX),
                ProductEnum::UNIT_TYPE_METER => ProductEnum::getValue(ProductEnum::UNIT_TYPE_METER),
                ProductEnum::UNIT_TYPE_LITER => ProductEnum::getValue(ProductEnum::UNIT_TYPE_LITER),
                ProductEnum::UNIT_TYPE_KG => ProductEnum::getValue(ProductEnum::UNIT_TYPE_KG),
            ]),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            // ...
        ];
    }

    protected function getTableActions(): array
    {
        return [
            // ...
        ];
    }

    protected function getTableBulkActions(): array
    {
        return [
            // ...
        ];
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [5, 10, 25, 50, 100, 150];
    }

    protected function getDefaultTableRecordsPerPageSelectOption(): int
    {
        // Limpa a paginação escolhida que foi salva na seção
        session()->remove($this->getTablePerPageSessionKey());

        $perPage = session()->get(
            $this->getTablePerPageSessionKey(),
            $this->defaultTableRecordsPerPageSelectOption ?: 25,
        );

        if (in_array($perPage, $this->getTableRecordsPerPageSelectOptions())) {
            return $perPage;
        }

        session()->remove($this->getTablePerPageSessionKey());

        return $this->getTableRecordsPerPageSelectOptions()[0];
    }

    public function render(): View
    {
        return view(
            'livewire.products.index',
        );
    }
}
