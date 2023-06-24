<?php

namespace App\Traits;

use Stancl\Tenancy\Tenancy;
use App\Models\Tenant;
use Illuminate\Support\Facades\Storage;

trait TenantStorageSet
{
    /**
     * function initializeTenantStorageSet
     */
    public static function initializeTenantStorageSet(): void
    {
        static::tenantDiskInit();
    }

    /**
     * function tenantDiskInit
     *
     * @return void
     */
    public static function tenantDiskInit(): void
    {
        static::tenantDiskReset();

        /**
         * @var Tenancy $tenancy
         */
        $tenancy = tenancy();

        /**
         * @var Tenant $tenant
         */
        $tenant = $tenancy?->tenant;

        if (!$tenancy->initialized || !$tenant) {
            return;
        }

        $url = config()->get('filesystems.disks.tenant_base.url');
        $urlBkp = config()->get('filesystems.disks.tenant_base.url_bkp');

        if (!$url || !$tenant?->id) {
            return;
        }

        if (!$urlBkp) {
            config()->set(
                'filesystems.disks.tenant_base.url_bkp',
                $url
            );
        }

        config()->set(
            'filesystems.disks.tenant_base.url',
            implode('/', [
                $url,
                $tenant?->id,
            ])
        );
    }

    /**
     * function tenantDiskReset
     *
     * @return void
     */
    public static function tenantDiskReset(): void
    {
        $url = config()->get('filesystems.disks.tenant_base.url');
        $urlBkp = config()->get('filesystems.disks.tenant_base.url_bkp');

        config()->set('filesystems.disks.tenant_base.url_bkp', null);

        if ($urlBkp && ($url === $urlBkp)) {
            return;
        }

        config()->set(
            'filesystems.disks.tenant_base.url',
            $urlBkp ?: implode(
                '/',
                [
                    config('app.url'),
                    'tn_storage',
                ]
            )
        );
    }
}
