<?php

namespace Jmonday\ValueObjects;

abstract class AbstractValue implements ValueInterface
{
    /** Human-readable readable string representing the value of the value.  */
    public string $formatted;

    public \Callable | \Closure | null $formatter;

    public mixed $value;

    public function __construct($value)
    {
        $this->setValue($value);
    }

    abstract public static function castValue($value): mixed;

    /** Convert the value object to a human-readable string when self::$formatter is `null`. */
    abstract public function toString(): string;

    public function __toString(): string
    {
        return $this->toString();
    }

    public function format(\Callable | \Closure | null $formatter = null): string
    {
        $this->formatter = $formatter;

        return is_callable($formatter)
            ? $formatter($this)
            : $this->toString();
    }

    public function formatWith(\Callable | \Closure $formatter): self
    {
        $this->formatter = $formatter;
        $this->formatted = $formatter($this);

        return $this;
    }

    public static function from($value): static
    {
        return new static(is_null($value) ? null : $value);
    }

    public function reformatValue(): self
    {
        $this->formatted = $this->setFormattedValue($this->value);

        return $this;
    }

    public function setFormattedValue($value): self
    {
        $this->formatted = ! is_null($value)
            ? $this->format()
            : '';

        return $this;
    }

    public function setValue($value): self
    {
        // Use `settype()` somehow instead of `castValue()`?
        $this->value = static::castValue($value);
        $this->setFormattedValue($value);

        return $this;
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'formatted' => $this->formatted,
            'value'     => $this->value,
        ];
    }
}
