<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Database\Seeders\DynamicContentSeeder;
use Database\Seeders\CategoriesAndPostsSeeder;
use Illuminate\Support\Collection;

class FakeTenantSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // For secure reasons, NO SAVE this ENV on config
        $forceSeedInProd = env('FORCE_SEED_IN_PROD');

        if (app()->isProduction()) {
            if (!$forceSeedInProd) {
                \dump("Not running. Application in production mode");
                exit(0);
            }

            echo \PHP_EOL;
            \dump("!!!! CAUTION !!!!");
            echo \PHP_EOL;
            \dump("This application is in PRODUCTION mode");
            \sleep(1);
            \dump("Running in");
            $wait = 5;

            if (is_numeric($wait) && $wait > 0) {
                echo \PHP_EOL;
                foreach(range(0, (int) $wait) as $i) {
                    echo (($wait - $i) ?: '') . \PHP_EOL;
                    \sleep(1);
                }

                \sleep(1);
            }
            \dump("Running now");
        }

        collect([
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
        ])->each(function ($tenantData) {
            /**
             * @var Collection $tenantData
             */
            $tenantData = \collect($tenantData);
            $tenant = Tenant::updateOrCreate(
                [
                    'id' => $tenantData->get('id'),
                ],
                $tenantData->except([
                    'domains',
                ])->toArray()
            );

            foreach (($tenant['domains'] ?? []) as $domain) {
                $tenant->domains()->updateOrCreate([
                    'domain' => $domain,
                ], [
                    'domain' => $domain,
                ]);
            }
        });

        // $this->call([
        //     TenancySeeder::class,
        // ]);
    }
}
