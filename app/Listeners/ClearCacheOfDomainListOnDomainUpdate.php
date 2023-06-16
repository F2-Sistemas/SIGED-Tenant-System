<?php

namespace App\Listeners;

use App\Models\Domain;
use Illuminate\Queue\InteractsWithQueue;
use \Stancl\Tenancy\Events\DomainUpdated;
use \Stancl\Tenancy\Events\UpdatingDomain;
use Illuminate\Contracts\Queue\ShouldQueue;

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
            'domainsList',
            $domain->tenant_id,
        ]);

        \Illuminate\Support\Facades\Cache::forget($cacheKey);
    }
}
