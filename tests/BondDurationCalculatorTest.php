<?php

use FinanCalc\Calculators\BondDurationCalculator;

/**
 * Class BondDurationCalculatorTest
 */
class BondDurationCalculatorTest extends PHPUnit_Framework_TestCase
{
    private $bondDurationCalculatorDirectAnnually,
        $bondDurationCalculatorFactoryAnnually;

    public function testDurationDirectAnnually()
    {
        $this->assertDuration($this->bondDurationCalculatorDirectAnnually);
    }

    /**
     * @param BondDurationCalculator $bondDurationCalculator
     */
    private function assertDuration(BondDurationCalculator $bondDurationCalculator)
    {
        $bondDuration_direct = $bondDurationCalculator->getBondDuration();
        $bondDuration_array = $bondDurationCalculator->getResultAsArray()["bondDuration"];

        $expected = "2.78";
        $this->assertEquals($expected, round($bondDuration_direct, 2));
        $this->assertEquals($expected, round($bondDuration_array, 2));
    }

    /**
     * Test other factory methods
     */

    public function testDurationFactoryAnnually()
    {
        $this->assertDuration($this->bondDurationCalculatorFactoryAnnually);
    }

    /**
     * Test semi-annual coupons bond factory
     * (to get the same result as with the annual coupons bond,
     * we need to halve the 'years to maturity' value
     * and double the 'annual coupon rate' and 'annual yield')
     */
    public function testDurationFactorySemiAnnually()
    {
        $this->assertDuration(\FinanCalc\FinanCalc
            ::getInstance()
            ->getFactory('BondDurationCalculatorFactory')
            ->newSemiAnnualCouponsBond(1000, 0.16, 0.2, 1.5));
    }

    /**
     * Test quarterly coupons bond factory
     * (to get the same result as with the annual coupons bond,
     * we need to divide the 'years to maturity' value by four
     * and quadruple the 'annual coupon rate' and 'annual yield')
     */
    public function testDurationFactoryQuarterly()
    {
        $this->assertDuration(\FinanCalc\FinanCalc
            ::getInstance()
            ->getFactory('BondDurationCalculatorFactory')
            ->newQuarterlyCouponsBond(1000, 0.32, 0.4, 0.75));
    }

    /**
     * Test monthly coupons bond factory
     * (to get the same result as with the annual coupons bond,
     * we need to divide the 'years to maturity' value by twelve
     * and multiply the 'annual coupon rate' and 'annual yield'
     */
    public function testDurationFactoryMonthly()
    {
        $this->assertDuration(\FinanCalc\FinanCalc
            ::getInstance()
            ->getFactory('BondDurationCalculatorFactory')
            ->newMonthlyCouponsBond(1000, 0.96, 1.2, 0.25));
    }

    /**
     * Test custom coupon frequency bond factory
     * We test the annual coupon bond factory,
     * but manufactured by the custom bond coupon frequency
     * factory
     */
    public function testDurationFactoryCustom()
    {
        $this->assertDuration(\FinanCalc\FinanCalc
            ::getInstance()
            ->getFactory('BondDurationCalculatorFactory')
            ->newCustomCouponFrequencyBond(1000, 0.08, 0.1, 3, 1));
    }

    /**
     * Test presence in the main Factories array
     */
    public function testPresenceInMainFactoriesArray()
    {
        $this->assertTrue(
            isObjectTypeInArray('FinanCalc\\Calculators\\Factories\\BondDurationCalculatorFactory',
                \FinanCalc\FinanCalc::getInstance()->getFactories())
        );
    }

    protected function setUp()
    {
        $this->bondDurationCalculatorDirectAnnually = $this->newBondInstanceDirectAnnually();
        $this->bondDurationCalculatorFactoryAnnually = $this->newBondInstanceFactoryAnnually();

        parent::setUp();
    }

    /**
     * @return BondDurationCalculator
     */
    private function newBondInstanceDirectAnnually()
    {
        return new BondDurationCalculator(1000, 0.08, 0.1, 3);
    }

    /**
     * @return mixed
     * @throws Exception
     */
    private function newBondInstanceFactoryAnnually()
    {
        return \FinanCalc\FinanCalc
            ::getInstance()
            ->getFactory('BondDurationCalculatorFactory')
            ->newAnnualCouponsBond(1000, 0.08, 0.1, 3);
    }
}
