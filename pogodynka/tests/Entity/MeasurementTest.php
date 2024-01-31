<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Measurement;

class MeasurementTest extends TestCase
{   
    /**
    * @dataProvider dataGetFahrenheit
    */
    public function testGetFahrenheit($celsius, $expectedFahrenheit): void
    {

        $m = new Measurement();
        $m->setCelsius($celsius);
        $this->assertTrue($m->getFahrenheit()==$expectedFahrenheit);

    }

    public function dataGetFahrenheit(): array
{
    return [
        ['0', 32],
        ['-100', -148],
        ['10', 50],
        ['25', 77],
        ['30', 86],
        ['35', 95],
        ['40', 104],
        ['180', 356],
        ['100', 212],
        ['33', 91.4],
    ];
}

}
