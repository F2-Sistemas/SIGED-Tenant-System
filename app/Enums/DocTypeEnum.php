<?php

namespace App\Enums;

use App\Enums\Concers\EnumHelpers;

enum DocTypeEnum
{
    use EnumHelpers;

    case CNPJ;
    case CPF;
    case PASSPORT;
    case OTHER;
    case NO_ONE;
}
