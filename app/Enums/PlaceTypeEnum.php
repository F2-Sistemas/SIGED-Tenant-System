<?php

namespace App\Enums;

use App\Enums\Concers\EnumHelpers;

enum PlaceTypeEnum: int
{
    use EnumHelpers;

    case STREET = 10;
    case AVENUE = 20;
}
