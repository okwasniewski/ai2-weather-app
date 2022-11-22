<?php

// namespace App\Tests;

use App\Entity\Measurement;
use PHPUnit\Framework\TestCase;

class FahrenheitTest extends TestCase
{
    /** @test
     * @dataProvider dataProvider
     */
    public function isConversionCorrect($value, $expected): void
    {
        $measurement = new Measurement();
        $measurement->setCelsius($value);

        $fahrenheit = $measurement->getFahrenheit();
        $this->assertEquals($expected, $fahrenheit);
    }

    public function dataProvider()
    {
        return [
            [10, 50],
            [15, 59],
            [10, 50],
            [21, 69.8],
            [25, 77],
            [20, 68],
        ];
    }
}
