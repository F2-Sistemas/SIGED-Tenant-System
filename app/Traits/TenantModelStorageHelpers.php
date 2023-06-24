<?php

namespace App\Traits;

use App\Models\Tenant;
use App\Helpers\TenantHelpers;

trait TenantModelStorageHelpers
{
    /**
     * function storagePath
     *
     * @param string $path
     *
     * @return string
     */
    public function storagePath(string $path = '', ?string $diskName = null): string
    {
        if (!is_a($this, Tenant::class)) {
            return '';
        }

        return TenantHelpers::storagePath($this->storageSuffix(), $path, $diskName);
    }

    /**
     * function getDisk
     *
     * @param ?string $diskName
     *
     * @return \Illuminate\Filesystem\FilesystemAdapter
     */
    public static function getDisk(?string $diskName = null): \Illuminate\Filesystem\FilesystemAdapter
    {
        return TenantHelpers::getDiskName($diskName);
    }

    /**
     * function storageSuffix
     *
     * @return string
     */
    public function storageSuffix(): string
    {
        if (!is_a($this, Tenant::class)) {
            return '';
        }

        return TenantHelpers::storageSuffix($this->getTenantKey());
    }

    /**
     * function getDiskName
     *
     * @param ?string $diskName
     *
     * @return string
     */
    public static function getDiskName(?string $diskName = null): string
    {
        return TenantHelpers::getDiskName($diskName);
    }
}
