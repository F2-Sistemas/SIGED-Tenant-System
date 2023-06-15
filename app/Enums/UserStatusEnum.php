<?php

namespace App\Enums;

use TiagoF2\Enums\Core\Enum;

class UserStatusEnum extends Enum
{
    public const INACTIVE = 0;
    public const ACTIVE = 1;

    protected static array $enums = [
        self::INACTIVE => 'inactive',
        self::ACTIVE => 'active',
    ];
}
