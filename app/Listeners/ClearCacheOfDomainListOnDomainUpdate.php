<?php

namespace App\Listeners;

use App\Models\Domain;
use Stancl\Tenancy\Events\DomainUpdated;
use Stancl\Tenancy\Events\UpdatingDomain;

class ClearCacheOfDomainListOnDomainUpdate
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UpdatingDomain|DomainUpdated $event): void
    {
        /**
         * @var $domain Domain
         */
        $domain = $event->domain;

        $cacheKey = implode('-', [
            'Tenant',
            'domainList',
            $domain->tenant_id,
        ]);

        \Illuminate\Support\Facades\Cache::forget($cacheKey);
    }
}
