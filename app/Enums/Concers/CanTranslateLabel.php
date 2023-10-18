<?php

namespace App\Enums\Concers;

use TiagoF2\Helpers\StringHelpers;

trait CanTranslateLabel
{
    public static function trans(
        string $key,
        ?string $locale = null
    ): string {
        //App\Enums\PlanEnum, App\Enums\PlanEnum::class, App\Enums\PlanEnum or plan_enum
        $className = StringHelpers::classNameSlug(static::class);

        $snakeCaseOfClass = str($className)->snake(); // OperationEnum -> operation_enum

        $locale ??= app()->getLocale();

        // The translation file must be here:
        // resources/lang/[LANG]/enums/operation_enum.php

        return \str_replace(
            [
                "{$snakeCaseOfClass}."
            ],
            '',
            __("{$snakeCaseOfClass}.{$key}", [], "{$locale}/enums")
        );
    }
}
