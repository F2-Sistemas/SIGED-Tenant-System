<?php

namespace Database\Seeders\TenantSeeders;

use Illuminate\Database\Seeder;
use App\Models\Orcamento;
use App\Enums\OrcamentoTipoEnum;
use App\Models\OrcamentoItem;

class OrcamentoItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect(
            range(2015, date('Y') + 4)
        )->each(function ($year) {
            collect(OrcamentoTipoEnum::enums(true))->each(function ($tipo) use (
                $year,
            ) {
                $orcamento = Orcamento::factory()->createOne([
                    'ano_vigencia_inicio' => $year,
                    'tipo' => $tipo,
                    'active' => true,
                ]);

                OrcamentoItem::factory(rand(2, 15))->create([
                    'orcamento_id' => $orcamento->id,
                ]);
            });
        });
    }
}
