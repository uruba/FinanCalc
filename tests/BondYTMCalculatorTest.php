<?php

use FinanCalc\Calculators\BondYTMCalculator\BondInstance;

/**
 * Class BondYTMCalculatorTest
 */
class BondYTMCalculatorTest extends PHPUnit_Framework_TestCase {
    private $bondInstanceDirectAnnually,
            $bondInstanceFactoryAnnually;

    public function testApproxBondYTMDirectAnnually() {
        $this->assertApproxBondYTM($this->bondInstanceDirectAnnually);
    }

    public function testApproxBondYTMFactoryAnnually() {
        $this->assertApproxBondYTM($this->bondInstanceFactoryAnnually);
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
            ->newSemiAnnualCouponsBond(10000, 10800, 0.292, 1.5)
            ->getResult());
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
            ->newQuarterlyCouponsBond(10000, 10800, 0.584, 0.75)
            ->getResult());
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
            ->newMonthlyCouponsBond(10000, 10800, 1.752, 0.25)
            ->getResult());
    }

    /**
     * Test custom coupon frequency bond factory
     * We test the annual coupon bond factory,
     * but manufactured by the custom bond coupon frequency
     * factory
     */
    public function testApproxBondYTMFactoryCustom(){
        return \FinanCalc\FinanCalc
            ::getInstance()
            ->getFactory('BondYTMCalculatorFactory')
            ->newCustomCouponFrequencyBond(10000, 10800, 0.146, 3, 1)
            ->getResult();
    }

    /**
     * @param BondInstance $bondInstance
     */
    private function assertApproxBondYTM(BondInstance $bondInstance) {
        $approxBondYTM = $bondInstance->getApproxBondYTM();

        $this->assertEquals(0.1147, round($approxBondYTM, 4));
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
     * @return BondInstance
     */
    private function getBondInstanceDirectAnnually() {
        $bondYTMCalculator = new \FinanCalc\Calculators\BondYTMCalculator(10000,10800, 0.146, 3, 1);
        return $bondYTMCalculator->getResult();
    }

    /**
     * @return mixed
     * @throws Exception
     */
    private function getBondInstanceFactoryAnnually() {
        return \FinanCalc\FinanCalc
            ::getInstance()
            ->getFactory('BondYTMCalculatorFactory')
            ->newAnnualCouponsBond(10000, 10800, 0.146, 3)
            ->getResult();
    }

    protected function setUp() {
        $this->bondInstanceDirectAnnually = $this->getBondInstanceDirectAnnually();
        $this->bondInstanceFactoryAnnually = $this->getBondInstanceFactoryAnnually();

        parent::setUp();
    }
}
