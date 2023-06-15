<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Database\Seeders\DynamicContentSeeder;
use Database\Seeders\CategoriesAndPostsSeeder;

class FakeTenantSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $tenants = [
            [
                'id' => 'cliente1',
                'domains' => [
                    'cliente1.app.local',
                ],
            ],
            [
                'id' => 'cliente2',
                'domains' => [
                    'cliente2.app.local',
                ],
            ],
        ];

        foreach ($tenants as $tenant) {
            $tenant = Tenant::updateOrCreate([
                'id' => $tenant['id'],
            ], $tenant);

            foreach (($tenant['domains'] ?? []) as $domain) {
                $tenant->domains()->updateOrCreate([
                    'domain' => $domain,
                ], [
                    'domain' => $domain,
                ]);
            }
        }

        $this->call([
            TenancySeeder::class,
        ]);
    }
}
