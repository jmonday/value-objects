<?php

namespace Jmonday\Tests\Unit\ValueObjects;

use Jmonday\ValueObjects\CurrencyValue;
use PHPUnit\Framework\TestCase;

class CurrencyValueTest extends TestCase
{
    public function testFrom(): void
    {
        $currency = CurrencyValue::from(null);
        $this->assertEquals('', $currency->formatted);
        $this->assertEquals(null, $currency->value);

        $currency = CurrencyValue::from(0);
        $this->assertEquals('$0.00', $currency->formatted);
        $this->assertEquals(0.00, $currency->value);

        $currency = CurrencyValue::from(1.0);
        $this->assertEquals('$1.00', $currency->formatted);
        $this->assertEquals(1.00, $currency->value);

        $currency = CurrencyValue::from(234726);
        $this->assertEquals('$234,726.00', $currency->formatted);
        $this->assertEquals(234726, $currency->value);

        $currency = CurrencyValue::from(-98.76);
        $this->assertEquals('-$98.76', $currency->formatted);
        $this->assertEquals(-98.76, $currency->value);
    }

    public function testFormat(): void
    {
        $this->assertEquals(
            expected: 'Discount: $25',
            actual: CurrencyValue::from(25.00)
                ->setPrecision(0)
                ->format(fn (CurrencyValue $c) => "Discount: $c")
        );

        $currency = CurrencyValue::from(5.71)
            ->formatWith(fn(CurrencyValue $c) => "$c suffix")
            ->toArray();
        $this->assertEquals('$5.71 suffix', $currency['formatted']);
    }

    public function testLocale(): void
    {
        $currency = CurrencyValue::from(1234.56);
        $this->assertEquals('$1,234.56', $currency->formatted);
        $this->assertEquals(1234.56, $currency->value);

        $currency->setLocale('en-AU');
        $this->assertEquals('$1,234.56', $currency->formatted);
        $this->assertEquals(1234.56, $currency->value);

        $currency->setLocale('en-GB');
        $this->assertEquals('£1,234.56', $currency->formatted);
        $this->assertEquals(1234.56, $currency->value);

        $currency->setLocale('bad-locale');
        $this->assertEquals('¤1,234.56', $currency->formatted);
        $this->assertEquals(1234.56, $currency->value);
    }
}
