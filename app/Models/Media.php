<?php

namespace App\Models;

use App\Traits\TenantStorageSet;

class Media extends \Spatie\MediaLibrary\MediaCollections\Models\Media
{
    use TenantStorageSet;
}
