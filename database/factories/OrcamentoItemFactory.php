<?php

namespace Database\Factories;

use App\Enums\LeiEnum;
use App\Models\Orcamento;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrcamentoItem>
 */
class OrcamentoItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'orcamento_id' => Orcamento::factory(),
            'lei_tipo' => Arr::random(
                array_keys(
                    array_filter(
                        LeiEnum::enumList(),
                        fn ($item) => str_starts_with($item, 'tipo_')
                    )
                )
            ),
            'lei_numero' => rand(100, 500),
            'lei_data' => now()->subDays(rand(2, 15))->format('Y-m-d H:i:s'),
            'content' => fake()->paragraph(6),
            'aditional_data' => [
                'campo1' => 'Valor 1',
                'campo2' => 'Valor 2',
            ],
        ];
    }
}
