<?php

namespace App\Helpers;

class Faker
{
    /**
     * function paragraphs that
     *
     * @param int $count
     * @param ?string $implodeWith
     *
     * @return Illuminate\Support\Collection|string
     */
    public static function paragraphs(
        int $count = 3,
        ?string $implodeWith = \null,
        array $attributes = [],
    ): \Illuminate\Support\Collection|string {
        $attributes = \collect($attributes)
            ->map(function ($value, $att) {
                $value = \is_object($value) || \is_array($value) ? \json_encode($value) : $value;

                if (is_numeric($att)) {
                    return $value;
                }

                return \sprintf('%s="%s"', $att, $value);
            })->implode(' ');

        $generated = collect(
            \fake()->paragraphs($count)
        )
            ->map(
                fn ($line) => \sprintf(
                    '<p%s>%s</p>',
                    $attributes ? " {$attributes}" : '',
                    $line,
                )
            );

        if ($implodeWith !== \null) {
            return $generated->implode($implodeWith);
        }

        return $generated;
    }
}
