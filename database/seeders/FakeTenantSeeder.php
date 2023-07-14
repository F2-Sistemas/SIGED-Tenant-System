<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class FakeTenantSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $this->command->withProgressBar(['a', 'b'], fn ($item) => dump($item));

        // For secure reasons, NO SAVE this ENV on config
        $forceSeedInProd = env('FORCE_SEED_IN_PROD');

        if (app()->isProduction()) {
            $this->command->alert("!!!! CAUTION !!!!");

            $this->command->alert("Not running. Application in production mode");
            $choise = $this->command->ask(
                question: 'Do you want continue? This can\'t be reverted! [yes/no]',
                default: $forceSeedInProd ? 'yes' : 'no',
            );

            if (!in_array($choise, ['yes', 'no'])) {
                $this->command->error('Wrong answer');

                exit(400);
            }

            if ($choise === 'no') {
                exit(0);
            }

            $num1 = rand(1, 10);
            $num2 = rand(1, 10);

            $answer = $this->command->ask(
                question: sprintf('To continue, answer: what is the result [ %s + %s ]?', $num1, $num2),
            );

            $rigthResult = $num1 + $num2;

            if ($answer != $rigthResult) {
                $this->command->error('Wrong answer');

                exit(501);
            }

            $this->command->newLine(1);
            $this->command->alert("This application is in PRODUCTION mode");
            \sleep(1);
            $this->command->alert("Running in");
            $wait = 5;

            if (is_numeric($wait) && $wait > 0) {
                $this->command->newLine(1);

                foreach (range(0, (int) $wait) as $i) {
                    echo(($wait - $i) ?: '') . \PHP_EOL;
                    \sleep(1);
                }

                \sleep(1);
            }
            $this->command->alert("Running now");
        }

        collect([
            [
                'id' => 'cliente1',
                'domains' => [
                    'cliente1.app.local',
                    'client01.siged.local',
                ],
            ],
            [
                'id' => 'cliente2',
                'domains' => [
                    'cliente2.app.local',
                    'client02.siged.local',
                ],
            ],
        ])->each(function ($tenantData) {
            /**
             * @var Collection $tenantData
             */
            $tenantData = \collect($tenantData);

            echo "Tenant ID: {$tenantData->get('id')}" . PHP_EOL;

            $tenant = Tenant::updateOrCreate(
                [
                    'id' => $tenantData->get('id'),
                ],
                $tenantData->except([
                    'domains',
                ])->toArray()
            );

            dump($tenant?->id);

            foreach ($tenantData->get('domains', []) as $domain) {
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
