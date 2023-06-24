<?php

namespace App\Traits;

use Stancl\Tenancy\Tenancy;
use App\Models\Tenant;
use Illuminate\Support\Facades\Storage;

trait TenantStorageGet
{
    /**
     * function storagePath
     *
     * @param string $path
     *
     * @return string
     */
    public static function storagePath(string $tenantKey, string $path = '', ?string $diskName = null): string
    {
        if (!$tenantKey) {
            return '';
        }

        $current = static::getDisk($diskName)->path('/');
        $sufix = static::storageSuffix($tenantKey);

        $sufix = str_ends_with(trim($current, DIRECTORY_SEPARATOR), trim($sufix, DIRECTORY_SEPARATOR)) ? '' : $sufix;

        return str(
            implode(
                DIRECTORY_SEPARATOR,
                [
                    $current,
                    $sufix,
                    $path,
                ]
            )
        )->replace(['///', '//'], DIRECTORY_SEPARATOR)->toString();
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
        return Storage::disk(static::getDiskName($diskName));
    }

    /**
     * function storageSuffix
     *
     * @return string
     */
    public static function storageSuffix(string $tenantKey): string
    {
        if (!$tenantKey) {
            return '';
        }

        $suffixBase = config('tenancy.filesystem.suffix_base');

        if (!$suffixBase) {
            return '';
        }

        return "{$suffixBase}{$tenantKey}";
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
        return $diskName ??= 'tenant_base';
    }
}
