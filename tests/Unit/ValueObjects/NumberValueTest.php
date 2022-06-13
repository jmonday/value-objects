<?php

namespace Jmonday\Tests\Unit\ValueObjects;

use Jmonday\ValueObjects\NumberValue;
use PHPUnit\Framework\TestCase;

class NumberValueTest extends TestCase
{
    public function testFrom(): void
    {
        $float = NumberValue::from(null);
        $this->assertEquals('', $float->formatted);
        $this->assertEquals(null, $float->value);

        $float = NumberValue::from(0.0);
        $this->assertEquals('0', $float->formatted);
        $this->assertEquals(0, $float->value);

        $float = NumberValue::from(1.0);
        $this->assertEquals('1', $float->formatted);
        $this->assertEquals(1, $float->value);

        $float = NumberValue::from(0.123456)->setPrecision(4);
        $this->assertEquals('0.1235', $float->formatted);
        $this->assertEquals(0.123456, $float->value);

        $float = NumberValue::from(-98.76);
        $this->assertEquals('-99', $float->formatted);
        $this->assertEquals(-98.76, $float->value);

        $this->assertEquals(
            expected: 'Pi: 3.14159',
            actual: NumberValue::from(3.14159)
                ->setPrecision(5)
                ->format(fn (NumberValue $p) => "Pi: $p")
        );

        $float = NumberValue::from(5.65)
            ->setPrecision(2)
            ->formatWith(fn(NumberValue $p) => "pH: $p")
            ->toArray();
        $this->assertEquals('pH: 5.65', $float['formatted']);
    }

    public function testPrecision(): void
    {
        $float = NumberValue::from(0.123456789);
        $this->assertEquals('0', $float->setPrecision(0)->formatted);
        $this->assertEquals('0.1', $float->setPrecision(1)->formatted);
        $this->assertEquals('0.12', $float->setPrecision(2)->formatted);
        $this->assertEquals('0.123', $float->setPrecision(3)->formatted);
        $this->assertEquals('0.1235', $float->setPrecision(4)->formatted);
        $this->assertEquals('0.12346', $float->setPrecision(5)->formatted);
        $this->assertEquals('0.123457', $float->setPrecision(6)->formatted);
        $this->assertEquals('0.1234568', $float->setPrecision(7)->formatted);
        $this->assertEquals('0.12345679', $float->setPrecision(8)->formatted);
        $this->assertEquals('0.123456789', $float->setPrecision(9)->formatted);
    }
}
