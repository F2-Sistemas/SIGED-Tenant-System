<?php

declare(strict_types=1);

namespace App\Traits\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Copy of
 * vendor/stancl/tenancy/src/Concerns/HasATenantArgument.php
 *
 * Date: 2023-06-25
 */
trait HasATenantArgument
{
    protected function getArguments()
    {
        return array_merge(parent::getArguments(), [
            ['name', InputArgument::REQUIRED, 'Model name', null],
            ['tenant', InputArgument::OPTIONAL, 'Tenant ID (used to get DB info)', null],
        ]);
    }

    protected function getOptions()
    {
        return array_merge(parent::getOptions(), [
            ['tenant', 'T', InputOption::VALUE_REQUIRED, 'Tenant ID (used to get DB info)', null],
        ]);
    }

    protected function getTenants(): array
    {
        $tenantId = $this->option('tenant') ?: $this->argument('tenant');

        if (!$tenantId) {
            return [];
        }

        return [tenancy()->find($tenantId)];
    }

    public function __construct()
    {
        parent::__construct();

        $this->specifyParameters();
    }
}
