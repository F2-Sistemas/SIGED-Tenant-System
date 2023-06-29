<?php

namespace App\Enums;

use TiagoF2\Enums\Core\Enum;

class LeiEnum extends Enum
{
    public const TIPO_MUNICIPAL = 1;
    public const TIPO_ESTADUAL = 2;
    public const TIPO_FEDERAL = 3;

    protected static array $enums = [
        self::TIPO_MUNICIPAL => 'tipo_municipal',
        self::TIPO_ESTADUAL => 'tipo_estadual',
        self::TIPO_FEDERAL => 'tipo_federal',
    ];
}
