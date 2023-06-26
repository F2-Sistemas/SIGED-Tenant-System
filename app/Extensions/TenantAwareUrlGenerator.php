<?php

namespace App\Extensions;

use Spatie\MediaLibrary\Support\UrlGenerator\DefaultUrlGenerator;

/**
 * @see https://tenancyforlaravel.com/docs/v3/integrations/spatie#laravel-medialibrary
 */
class TenantAwareUrlGenerator extends DefaultUrlGenerator
{
    public function getUrl(): string
    {
        $url = asset($this->getPathRelativeToRoot());

        $url = $this->versionUrl($url);

        return $url;
    }
}
