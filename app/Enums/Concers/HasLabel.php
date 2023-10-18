<?php

namespace App\Enums\Concers;

trait HasLabel
{
    use CanTranslateLabel;

    public function getLabel()
    {
        return static::trans($this->name);
    }

    public function label(): string
    {
        return $this->getLabel();
    }
}
