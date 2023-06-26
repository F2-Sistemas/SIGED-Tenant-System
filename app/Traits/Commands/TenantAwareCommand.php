<?php

declare(strict_types=1);

namespace App\Traits\Commands;

use Stancl\Tenancy\Contracts\Tenant;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Copy of
 * vendor/stancl/tenancy/src/Concerns/TenantAwareCommand.php
 *
 * Date: 2023-06-25
 */
trait TenantAwareCommand
{
    /** @return int */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $tenants = $this->getTenants();
        $exitCode = 0;
        $errorExitCode = 4;

        if (!$tenants || !($tenants[0] ?? null)) {
            if ($this->ignoreEmptyTenantList()) {
                $result = (int) $this->laravel->call([$this, 'handle']);

                if ($result !== 0) {
                    $exitCode = $result;
                }

                return $exitCode;
            }

            $this->newLine(1);
            $this->error('Empty tenant list');
            $this->newLine(1);

            return $errorExitCode;
        }

        foreach ($tenants as $tenant) {
            $result = (int) $tenant->run(fn() => $this->laravel->call([$this, 'handle']));

            if ($result !== 0) {
                $exitCode = $result;
            }
        }

        return $exitCode;
    }

    /**
     * Get an array of tenants for which the command should be executed.
     *
     * @return Tenant[]|mixed
     */
    abstract protected function getTenants();

    /**
     * If can continue without tenant on list.
     *
     * When a tenant is required (or not) to run
     *
     * @return bool
     */
    abstract protected function ignoreEmptyTenantList(): bool;
}
