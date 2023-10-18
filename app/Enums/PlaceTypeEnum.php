<?php

namespace App\Enums;

use TiagoF2\Enums\Core\Enum;

class PlaceTypeEnum extends Enum
{
    public const STREET = 10;
    public const AVENUE = 20;

    protected static array $enums = [
        static::STREET => 'street',
        static::AVENUE => 'avenue',
    ];
}
