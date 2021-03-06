<?php

namespace Jmonday\ValueObjects;

use NumberFormatter;

class CurrencyValue extends NumberValue
{
    public string $locale = 'en-US';

    public int $precision = 2;

    public function toString(): string
    {
        $numberFormatter = new NumberFormatter($this->locale, NumberFormatter::CURRENCY);
        $numberFormatter->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, $this->precision);

        return $numberFormatter->format($this->value);
    }

    public function setLocale(string $locale): self
    {
        $this->locale = $locale;
        $this->reformatValue();

        return $this;
    }
}
