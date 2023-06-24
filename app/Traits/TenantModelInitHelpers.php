<?php

namespace App\Traits;

use App\Models\Tenant;
use App\Traits\TenantStorageSet;

trait TenantModelInitHelpers
{
    use TenantStorageSet;

    /**
     * function initialize
     *
     * @return bool
     */
    public function initialize(): bool
    {
        if (!is_a($this, Tenant::class)) {
            return false;
        }

        \tenancy()->initialize($this);

        static::tenantDiskInit();

        return $this->isInitialized();
    }

    /**
     * function init
     *
     * An alias to initialize() method
     *
     * @return bool
     */
    public function init(): bool
    {
        return $this->initialize();
    }

    /**
     * function isInitialized
     *
     * @return bool
     */
    public function isInitialized(): bool
    {
        if (!is_a($this, Tenant::class)) {
            return false;
        }

        return \tenancy()->initialized && (\tenancy()->tenant?->id === $this?->id);
    }

    /**
     * function inited
     *
     * An alias to isInitialized() method
     *
     * @return bool
     */
    public function inited(): bool
    {
        return $this->isInitialized();
    }

    /**
     * function end
     *
     * End initialization
     *
     * @return bool
     */
    public function end(): bool
    {
        \tenancy()->end();
        static::tenantDiskReset();

        return !$this->isInitialized();
    }
}
