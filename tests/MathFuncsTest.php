<?php
use FinanCalc\Utils\MathFuncs;

/**
 * Class MathFuncsTest
 */
class MathFuncsTest extends PHPUnit_Framework_TestCase
{
    public function testAdd() {
        $this->assertEquals("4.685", MathFuncs::add(1.368, 3.317));
    }

    public function testSub() {
        $this->assertEquals("3.317", MathFuncs::sub(4.685, 1.368));
    }

    public function testMul() {
        $this->assertEquals("9.27936", MathFuncs::mul(2.685, 3.456));
    }

    public function testDiv() {
        $this->assertEquals("2.685", MathFuncs::div(9.27936, 3.456));
    }

    public function testPow() {
        $this->assertEquals("53.157376", MathFuncs::pow(3.76, 3));
    }

    public function testComp() {
        $this->assertEquals("-1", MathFuncs::comp(3.456, 4.568));
        $this->assertEquals("0",  MathFuncs::comp(3.456, 3.456));
        $this->assertEquals("1", MathFuncs::comp(4.568, 3.456));
    }

    public function testRound() {
        $this->assertEquals("3.68", MathFuncs::round(3.675624));
    }
}
