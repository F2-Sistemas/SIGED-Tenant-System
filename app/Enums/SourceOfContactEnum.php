<?php

namespace App\Enums;

use App\Libs\Enums\Enum;

class SourceOfContactEnum extends Enum
{
    public const SUPERPROF = 1;
    public const LINKEDIN = 2;
    public const GOOGLE = 3;
    public const TELEGRAM = 4;
    public const INDICACAO = 5;
    public const OUTROS = 6;

    protected static array $enums = [
        self::SUPERPROF => 'SuperProf',
        self::LINKEDIN => 'LinkedIn',
        self::GOOGLE => 'Google',
        self::TELEGRAM => 'Telegram',
        self::INDICACAO => 'indicacao',
        self::OUTROS => 'outros',
    ];
}
