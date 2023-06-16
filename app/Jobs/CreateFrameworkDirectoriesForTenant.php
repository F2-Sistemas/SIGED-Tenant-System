<?php

namespace App\Jobs;

use App\Models\Tenant;

class CreateFrameworkDirectoriesForTenant
{
    protected $tenant;

    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;
    }

    public function handle()
    {
        $this->tenant->run(function ($tenant) {
            $storagePath = storage_path();

            if (!is_dir("{$storagePath}/framework/cache")) {
                mkdir("{$storagePath}/framework/cache", 0777, true);
            }
        });
    }
}
