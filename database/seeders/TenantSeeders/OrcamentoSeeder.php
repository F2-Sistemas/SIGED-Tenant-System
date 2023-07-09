<?php

namespace Database\Seeders\TenantSeeders;

use App\Models\Orcamento;
use App\Models\OrcamentoItem;
use Illuminate\Database\Seeder;

class OrcamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Orcamento::factory(10) ->has(OrcamentoItem::factory(rand(2, 15)), 'items') ->create();

        // Orcamento::find($id)->items()->createMany(OrcamentoItem::factory(5)->make()->toArray());
    }
}
