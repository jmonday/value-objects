<?php

namespace Jmonday\Tests\Unit\ValueObjects;

use Jmonday\ValueObjects\NumberValue;
use PHPUnit\Framework\TestCase;

class AbstractValueTest extends TestCase
{
    public function testSetValue(): void
    {
        $number = NumberValue::from(721);
        $this->assertEquals(721, $number->value);
        $this->assertEquals('721', $number->formatted);

        $number->setValue(1021);
        $this->assertEquals(1021, $number->value);
        $this->assertEquals('1,021', $number->formatted);
    }

    public function testToArray(): void
    {
        $number = NumberValue::from(186_282)->toArray();
        $this->assertEquals(186282, $number['value']);
        $this->assertEquals(186_282, $number['value']);
        $this->assertEquals('186,282', $number['formatted']);

        $number = NumberValue::from(1016)
            ->formatWith(fn (NumberValue $n) => "Total: $n adventurous anemones")
            ->toArray();
        $this->assertEquals(1016, $number['value']);
        $this->assertEquals('Total: 1,016 adventurous anemones', $number['formatted']);

        $number = NumberValue::from(9876)
            ->formatWith(fn (NumberValue $i) => 'Prefix: '.number_format(num: $i->value, thousands_separator: '_'))
            ->toArray();
        $this->assertEquals('Prefix: 9_876', $number['formatted']);
    }
}
