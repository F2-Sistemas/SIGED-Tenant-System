<?php

namespace Modules\Product\Enums;

use TiagoF2\Enums\Core\Enum;

class ProductEnum extends Enum
{
    public const UNIT_TYPE_UNITY = 1;
    public const UNIT_TYPE_BOX = 2;
    public const UNIT_TYPE_METER = 3;
    public const UNIT_TYPE_LITER = 4;
    public const UNIT_TYPE_KG = 5;

    protected static array $enums = [
        self::UNIT_TYPE_UNITY => 'un',
        self::UNIT_TYPE_BOX => 'bx',
        self::UNIT_TYPE_METER => 'm',
        self::UNIT_TYPE_LITER => 'l',
        self::UNIT_TYPE_KG => 'kg',
    ];
}
