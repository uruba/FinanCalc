<?php


use FinanCalc\FinanCalc;

/**
 * Class FinanCalcTest
 */
class FinanCalcTest extends PHPUnit_Framework_TestCase
{
    public function testFinanCalcClone() {
        $finanCalc = FinanCalc::getInstance();
        $finanCalcClone = invokeMethod($finanCalc, "__clone");

        $this->assertNull($finanCalcClone);
    }

    public function testGetInvalidFactory() {
        $this->setExpectedException("Exception");

        FinanCalc::getInstance()->getFactory("NonExistentFactory");
    }
}
