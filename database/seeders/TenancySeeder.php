<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;

class TenancySeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (tenancy()->initialized) {
            $this->command->error('This class is only for global seeder. Try running "tenants:seed"');

            exit(401);
        }

        Tenant::chunk(30, function ($tenants) {
            foreach ($tenants as $tenant) {
                // Alterar a conexão do banco de dados para o tenant atual
                tenancy()->initialize($tenant);

                // Lógica de seed para cada tenant/inquilino
                $this->call(DatabaseSeederForTenants::seedersForTenants());
            }
        });
    }
}
