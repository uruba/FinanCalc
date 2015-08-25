<?php

use FinanCalc\Calculators\BondYTMCalculator;

/**
 * Class BondYTMCalculatorTest
 */
class BondYTMCalculatorTest extends PHPUnit_Framework_TestCase {
    private $bondYTMCalculatorDirectAnnually,
            $bondYTMCalculatorFactoryAnnually;

    public function testApproxBondYTMDirectAnnually() {
        $this->assertApproxBondYTM($this->bondYTMCalculatorDirectAnnually);
    }

    public function testApproxBondYTMFactoryAnnually() {
        $this->assertApproxBondYTM($this->bondYTMCalculatorFactoryAnnually);
    }

    /**
     * Test other factory methods
     */

    /**
     * Test semi-annual coupons bond factory
     * (to get the same result as with the annual coupons bond,
     * we need to halve the 'years to maturity' value
     * and double the 'annual coupon rate')
     */
    public function testApproxBondYTMFactorySemiAnnually() {
        $this->assertApproxBondYTM(\FinanCalc\FinanCalc
            ::getInstance()
            ->getFactory('BondYTMCalculatorFactory')
            ->newSemiAnnualCouponsBond(10000, 10800, 0.292, 1.5));
    }

    /**
     * Test quarterly coupons bond factory
     * (to get the same result as with the annual coupons bond,
     * we need to divide the 'years to maturity' value by four
     * and quadruple the 'annual coupon rate')
     */
    public function testApproxBondYTMFactoryQuarterly(){
        $this->assertApproxBondYTM(\FinanCalc\FinanCalc
            ::getInstance()
            ->getFactory('BondYTMCalculatorFactory')
            ->newQuarterlyCouponsBond(10000, 10800, 0.584, 0.75));
    }

    /**
     * Test monthly coupons bond factory
     * (to get the same result as with the annual coupons bond,
     * we need to divide the 'years to maturity' value by twelve
     * and multiply the 'annual coupon rate' also by twelve)
     */
    public function testApproxBondYTMFactoryMonthly(){
        $this->assertApproxBondYTM(\FinanCalc\FinanCalc
            ::getInstance()
            ->getFactory('BondYTMCalculatorFactory')
            ->newMonthlyCouponsBond(10000, 10800, 1.752, 0.25));
    }

    /**
     * Test custom coupon frequency bond factory
     * We test the annual coupon bond factory,
     * but manufactured by the custom bond coupon frequency
     * factory
     */
    public function testApproxBondYTMFactoryCustom(){
        $this->assertApproxBondYTM(\FinanCalc\FinanCalc
            ::getInstance()
            ->getFactory('BondYTMCalculatorFactory')
            ->newCustomCouponFrequencyBond(10000, 10800, 0.146, 3, 1));
    }


    /**
     * @param BondYTMCalculator $bondYTMCalculator
     */
    private function assertApproxBondYTM(BondYTMCalculator $bondYTMCalculator) {
        $approxBondYTM_direct = $bondYTMCalculator->getApproxBondYTM();
        $approxBondYTM_array = $bondYTMCalculator->getResultAsArray()["bondApproxYTM"];

        $expected = "0.1147";
        $this->assertEquals($expected, round($approxBondYTM_direct, 4));
        $this->assertEquals($expected, round($approxBondYTM_array, 4));
    }

    /**
     * Test presence in the main factories array
     */
    public function testPresenceInMainFactoriesArray() {
        $this->assertTrue(
            isObjectTypeInArray('FinanCalc\\Calculators\\Factories\\BondYTMCalculatorFactory', \FinanCalc\FinanCalc::getInstance()->getFactories())
        );
    }

    /**
     * @return BondYTMCalculator
     */
    private function newBondYTMCalculatorDirectAnnually() {
        return new BondYTMCalculator(10000,10800, 0.146, 3, 1);
    }

    /**
     * @return mixed
     * @throws Exception
     */
    private function newBondYTMCalculatorFactoryAnnually() {
        return \FinanCalc\FinanCalc
            ::getInstance()
            ->getFactory('BondYTMCalculatorFactory')
            ->newAnnualCouponsBond(10000, 10800, 0.146, 3);
    }

    protected function setUp() {
        $this->bondYTMCalculatorDirectAnnually = $this->newBondYTMCalculatorDirectAnnually();
        $this->bondYTMCalculatorFactoryAnnually = $this->newBondYTMCalculatorFactoryAnnually();

        parent::setUp();
    }
}
