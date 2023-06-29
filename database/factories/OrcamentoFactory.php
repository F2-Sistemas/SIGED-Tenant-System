<?php

namespace Database\Factories;

use Illuminate\Support\Arr;
use App\Enums\OrcamentoTipoEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Orcamento>
 */
class OrcamentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tipo' => Arr::random(OrcamentoTipoEnum::enumList(true)),
            'ano_vigencia_inicio' => now()->setYear(
                '20' . collect(range(10, date('y')))->filter(fn ($num) => ($num % 2 === 0))->random()
            )->format('Y'),

            'ano_vigencia_fim' => fn ($attr) => $attr['tipo'] == OrcamentoTipoEnum::PPA
                ? now()->setYear(
                    getIfOr($attr['ano_vigencia_inicio'], 'isEven', fn ($year) => $year - 1)
                )->addYears(4)->format('Y')
                : $attr['ano_vigencia_inicio'],

            'ative' => true,
        ];
    }
}
