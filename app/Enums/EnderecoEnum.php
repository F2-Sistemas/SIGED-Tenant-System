<?php

namespace App\Enums;

use TiagoF2\Enums\Core\Enum;

class EnderecoEnum extends Enum
{
    public const TIPO_RUA = 1;
    public const TIPO_AVENIDA = 2;
    public const TIPO_TRAVESSA = 3;
    public const TIPO_BECO = 4;

    protected static array $enums = [
        self::TIPO_RUA => 'Rua',
        self::TIPO_AVENIDA => 'Avenida',
        self::TIPO_TRAVESSA => 'Travessa',
        self::TIPO_BECO => 'Beco',
    ];
}
