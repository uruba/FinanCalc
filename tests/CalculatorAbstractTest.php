<?php

use FinanCalc\Interfaces\Calculator\CalculatorAbstract;

/**
 * Class CalculatorAbstractTest
 */
class CalculatorAbstractTest extends PHPUnit_Framework_TestCase
{
    /** @var  TestCalculator */
    private $testCalculator;

    public function testExistentProperty() {
        $this->assertNull($this->testCalculator->getExistentProperty());

        $this->testCalculator->setExistentProperty();

        $this->assertEquals("some value", $this->testCalculator->getExistentProperty());
    }

    public function testNonExistentProperty() {
        $this->setExpectedException("Exception", "The property nonExistentProperty doesn't exist in the class TestCalculator!");

        $this->testCalculator->setNonExistentProperty();
    }

    protected function setUp() {
        $this->testCalculator = new TestCalculator();

        parent::setUp();
    }
}

/**
 * Class TestCalculator
 */
class TestCalculator extends CalculatorAbstract {
    protected $existentProperty;

    public function setExistentProperty() {
        $this->setProperty("existentProperty", "some value");
    }

    public function setNonExistentProperty() {
        $this->setProperty("nonExistentProperty", "some value");
    }

    public function getExistentProperty() {
        return $this->existentProperty;
    }
}
