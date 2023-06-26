<?php

namespace App\Traits\Commands;

trait CantIgnoreEmptyTenantList
{
    /**
     * If can continue without tenant on list.
     *
     * @return bool
     */
    protected function ignoreEmptyTenantList(): bool
    {
        return false;
    }
}
