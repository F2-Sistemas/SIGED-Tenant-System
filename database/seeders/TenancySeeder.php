<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Database\Seeders\DynamicContentSeeder;
use Database\Seeders\CategoriesAndPostsSeeder;

class TenancySeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Tenant::chunk(30, function ($tenants) {
            foreach ($tenants as $tenant) {
                // Alterar a conexão do banco de dados para o tenant atual
                tenancy()->initialize($tenant);

                // Lógica de seed para cada tenant/inquilino
                $this->call([
                    DynamicContentSeeder::class,
                    CategoriesAndPostsSeeder::class,
                ]);
            }
        });
    }
}
