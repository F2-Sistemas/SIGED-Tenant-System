<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Stancl\Tenancy\Contracts\Tenant;

class TenantList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenants:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List tenants.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Listing all tenants.');
        tenancy()
            ->query()
            ->cursor()
            ->each(function (Tenant $tenant) {
                if (!$tenant->domains) {
                    $this->line("[Tenant] {$tenant->getTenantKeyName()}: {$tenant->getTenantKey()}");

                    return;
                }

                $domains = \is_array($tenant->domains)
                    ? array_combine(['domain'], $tenant->domains)
                    : $tenant->domains;

                $domains = ($domains['domain'] ?? null) ? \collect([$domains]) : \collect($domains);

                $this->line(\implode(' | ', [
                    "[Tenant] {$tenant->getTenantKeyName()}: {$tenant->getTenantKey()}",
                    "Domains: " . implode('; ', $domains->pluck('domain')->toArray() ?? []),
                ]));
            });
    }
}
