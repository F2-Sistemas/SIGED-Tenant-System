<?php

namespace App\Enums\Concers;

trait NamesAndValues
{
    public function call(string $method): mixed
    {
        return method_exists($this, $method) ? $this->{$method}() : null;
    }

    public static function getNames(): array
    {
        foreach (static::cases() as $case) {
            $value = $case->name ?? null;

            if (is_null($value)) {
                continue;
            }

            $names[] = $value;
        }

        return (array) ($names ?? []);
    }

    public static function getValues(): array
    {
        foreach (static::cases() as $case) {
            $value = $case->value ?? null;

            if (is_null($value)) {
                continue;
            }

            $values[] = $value;
        }

        return (array) ($values ?? []);
    }

    public static function getLabels(): array
    {
        foreach (static::cases() as $case) {
            $value = $case->call('getLabel') ?? null;

            if (is_null($value)) {
                continue;
            }

            $labels[] = $value;
        }

        return (array) ($labels ?? []);
    }

    public static function getEnums(bool $onlyValues = false): array
    {
        return $onlyValues ? static::getValues() : static::cases();
    }

    /**
     * @method static names(): array
     * Alias to getNames method
     *
     * @return array
     */
    public static function names(): array
    {
        return static::getNames();
    }

    /**
     * @method static nlues(): array
     * Alias to getValues method
     *
     * @return array
     */
    public static function values(): array
    {
        return static::getValues();
    }

    /**
     * @method static nbels(): array
     * Alias to getLabels method
     *
     * @return array
     */
    public static function labels(): array
    {
        return static::getLabels();
    }

    /**
     * @method static enums(): array
     * Alias to getEnums method
     *
     * @return array
     */
    public static function enums(bool $onlyValues = false): array
    {
        return static::getEnums($onlyValues);
    }

    /**
     * @method static all(): array
     * Alias to getEnums method
     *
     * @return array
     */
    public static function all(bool $onlyValues = false): array
    {
        return static::getEnums($onlyValues);
    }

    public static function pair(
        string $asKey = 'value',
        string $asValue = 'label',
    ): array {
        foreach (static::cases() as $case) {
            $key = match ($asKey) {
                'name', 'names' => $case?->name,
                'value', 'values' => $case?->value,
                'label', 'labels' => $case?->getLabel(),
                default => $case?->value,
            };

            $value = match ($asValue) {
                'name', 'names' => $case?->name,
                'value', 'values' => $case?->value,
                'label', 'labels' => $case?->getLabel(),
                default => $case?->getLabel(),
            };

            if (is_null($key) || is_null($value)) {
                continue;
            }

            $data[$key] = $value;
        }

        return (array) ($data ?? []);
    }
}
