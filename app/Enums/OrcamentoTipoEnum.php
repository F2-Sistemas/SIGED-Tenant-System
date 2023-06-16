<?php

namespace App\Enums;

use TiagoF2\Enums\Core\Enum;

class OrcamentoTipoEnum extends Enum
{
    public const LOA = 1;
    public const LDO = 2;
    public const PPA = 3;

    protected static array $enums = [
        self::LOA => 'loa',
        self::LDO => 'ldo',
        self::PPA => 'ppa',
    ];
}
