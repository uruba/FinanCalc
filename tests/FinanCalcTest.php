<?php


use FinanCalc\FinanCalc;
use FinanCalc\Interfaces\Calculator\CalculatorFactoryAbstract;

/**
 * Class FinanCalcTest
 */
class FinanCalcTest extends PHPUnit_Framework_TestCase
{
    public function testFinanCalcClone()
    {
        $finanCalc = FinanCalc::getInstance();
        $finanCalcClone = invokeMethod($finanCalc, "__clone");

        $this->assertNull($finanCalcClone);
    }

    public function testGetInvalidFactory()
    {
        $this->setExpectedException("Exception");

        FinanCalc::getInstance()->getFactory("NonExistentFactory");
    }

    public function testCalculatorAbstract()
    {
        $calculatorAbstractMock = $this->getMockForAbstractClass("FinanCalc\\Interfaces\\Calculator\\CalculatorAbstract");

        $this->assertEmpty($calculatorAbstractMock->getResultAsArray());
        $this->assertEmpty($calculatorAbstractMock->getResultAsArray(["nonExistentField"]));
    }

    public function testCalculatorFactoryAbstractConstantNotDefined()
    {
        $this->setExpectedException("Exception");

        new MockCalculatorFactoryUndefinedConstant();
    }

    public function testCalculatorFactoryAbstractConstantWrong()
    {
        $this->setExpectedException("Exception");

        new MockCalculatorFactoryBadConstant();
    }
}

/**
 * Class MockCalculatorFactoryUndefinedConstant
 */
class MockCalculatorFactoryUndefinedConstant extends CalculatorFactoryAbstract
{

}

/**
 * Class MockCalculatorFactoryBadConstant
 */
class MockCalculatorFactoryBadConstant extends CalculatorFactoryAbstract
{
    const MANUFACTURED_CLASS_NAME = "NonExistentName";
}