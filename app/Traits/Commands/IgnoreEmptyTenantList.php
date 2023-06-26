<?php

namespace App\Traits\Commands;

trait IgnoreEmptyTenantList
{
    /**
     * If can continue without tenant on list.
     *
     * @return bool
     */
    protected function ignoreEmptyTenantList(): bool
    {
        return true;
    }
}
