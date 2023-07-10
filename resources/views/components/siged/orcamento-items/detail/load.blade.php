@props([
    'orcamento' => null,
    'orcamentoItem' => null, // $getRecord()
])

@php
$orcamentoItem ??= $getRecord() ?? null;

if (is_a($orcamentoItem, \App\Models\OrcamentoItem::class)):
    $orcamento ??= $orcamentoItem->orcamento;
@endphp
    @switch($orcamento?->tipo ?? null)
        @case(App\Enums\OrcamentoTipoEnum::LOA)
            <x-siged.orcamento-items.detail.tipo-loa
                :orcamento="$orcamento"
                :orcamentoItem="$orcamentoItem"
            />
            @break
        @case(App\Enums\OrcamentoTipoEnum::LDO)
            <x-siged.orcamento-items.detail.tipo-ldo
                :orcamento="$orcamento"
                :orcamentoItem="$orcamentoItem"
            />
            @break
        @case(App\Enums\OrcamentoTipoEnum::PPA)
            <x-siged.orcamento-items.detail.tipo-ppa
                :orcamento="$orcamento"
                :orcamentoItem="$orcamentoItem"
            />
            @break
    @endswitch
@php
endif;
@endphp
