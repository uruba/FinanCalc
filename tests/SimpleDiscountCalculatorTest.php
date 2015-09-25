<?php

use FinanCalc\Calculators\SimpleDiscountCalculator;
use FinanCalc\Utils\Time\TimeSpan;

/**
 * Class SimpleDiscountCalculatorTest
 */
class SimpleDiscountCalculatorTest extends PHPUnit_Framework_TestCase
{
    private $simpleDiscountCalculatorDirect,
            $simpleDiscountCalculatorFactory;

    /**
     * Test discount amount
     */
    public function testSimpleDiscountAmountDirect() {
        $this->assertDiscountAmount($this->simpleDiscountCalculatorDirect);
    }

    public function testSimpleDiscountAmountFactory() {
        $this->assertDiscountAmount($this->simpleDiscountCalculatorFactory);
    }

    /**
     * @param SimpleDiscountCalculator $discountCalculator
     */
    private function assertDiscountAmount(SimpleDiscountCalculator $discountCalculator) {
        $this->assertEquals(6500, $discountCalculator->getDiscountAmount());
    }

    /**
     * Test presence in the main Factories array
     */
    public function testPresenceInMainFactoriesArray() {
        $this->assertTrue(
            isObjectTypeInArray('FinanCalc\\Calculators\\Factories\\SimpleDiscountCalculatorFactory', \FinanCalc\FinanCalc::getInstance()->getFactories())
        );
    }

    /**
     * @return SimpleDiscountCalculator
     */
    private function newSimpleDiscountCalculatorDirect() {
        return new SimpleDiscountCalculator(100000, 0.13, TimeSpan::asDuration(0, 6));
    }

    /**
     * @return mixed
     * @throws Exception
     */
    private function newSimpleDiscountCalculatorFactory() {
        return \FinanCalc\FinanCalc
            ::getInstance()
            ->getFactory('SimpleDiscountCalculatorFactory')
            ->newSimpleDiscount(100000, 0.13, TimeSpan::asDuration(0, 6));
    }

    protected function setUp() {
        $this->simpleDiscountCalculatorDirect = $this->newSimpleDiscountCalculatorDirect();
        $this->simpleDiscountCalculatorFactory = $this->newSimpleDiscountCalculatorFactory();

        parent::setUp();
    }
}
