<?php

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;

use \App\Service\CalculatorService;

class CalculatorServiceTest extends TestCase
{
    public function testSomething(): void
    {
        $this->assertTrue(true);
    }

    public function testSquare()
    {
        $calculator = new CalculatorService();
        $result = $calculator->square(5);

        // assertion
        $this->assertEquals(25, $result);
        $this->assertNotEquals("vingt-cinq", $result);
        $this->assertEquals("25", $result);
    }
}
