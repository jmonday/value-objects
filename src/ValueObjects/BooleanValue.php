<?php

namespace Jmonday\ValueObjects;

class BooleanValue extends AbstractValue
{
    public static function castValue($value): ?bool
    {
        return is_null($value) ? null : (bool) $value;
    }

    public function toString(): string
    {
        return $this->value ? 'true' : 'false';
    }
}
