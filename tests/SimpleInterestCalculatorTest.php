<?php

use FinanCalc\Calculators\SimpleInterestCalculator;
use FinanCalc\Utils\Time\TimeSpan;

/**
 * Class SimpleInterestCalculatorTest
 */
class SimpleInterestCalculatorTest extends PHPUnit_Framework_TestCase
{
    /** @var  SimpleInterestCalculator */
    private $simpleInterestCalculatorDirect,
            $simpleInterestCalculatorFactory;

    /**
     *  Test interest amount
     */
    public function testSimpleInterestAmountDirect() {
        $this->assertInterestAmount($this->simpleInterestCalculatorDirect);
    }

    public function testSimpleInterestAmountFactory() {
        $this->assertInterestAmount($this->simpleInterestCalculatorFactory);
    }

    /**
     * @param SimpleInterestCalculator $interestCalculator
     */
    private function assertInterestAmount(SimpleInterestCalculator $interestCalculator) {
        $this->assertEquals(3.75, $interestCalculator->getInterestAmount());
    }

    /**
     * Test presence in the main Factories array
     */
    public function testPresenceInMainFactoriesArray() {
        $this->assertTrue(
            isObjectTypeInArray('FinanCalc\\Calculators\\Factories\\SimpleInterestCalculatorFactory', \FinanCalc\FinanCalc::getInstance()->getFactories())
        );
    }

    /**
     * @return SimpleInterestCalculator
     */
    private function newSimpleInterestCalculatorDirect() {
        return new SimpleInterestCalculator(100, 0.0375, TimeSpan::asDuration(1));
    }

    private function newSimpleInterestCalculatorFactory() {
        return \FinanCalc\FinanCalc
            ::getInstance()
            ->getFactory('SimpleInterestCalculatorFactory')
            ->newSimpleInterest(100, 0.0375, TimeSpan::asDuration(1));
    }

    protected function setUp() {
        $this->simpleInterestCalculatorDirect = $this->newSimpleInterestCalculatorDirect();
        $this->simpleInterestCalculatorFactory = $this->newSimpleInterestCalculatorFactory();

        parent::setUp();
    }
}
