<?php

namespace Jmonday\ValueObjects;

class NumberValue extends AbstractValue
{
    public int $precision = 0;

    public static function castValue($value): ?float
    {
        return is_null($value) ? null : (float) $value;
    }

    public function toString(): string
    {
        return number_format($this->value, $this->precision);
    }

    public function setPrecision(int $precision): self
    {
        $this->precision = $precision;
        $this->reformatValue();

        return $this;
    }
}
