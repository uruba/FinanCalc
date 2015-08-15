<?php

use FinanCalc\Calculators\BondFairValueCalculator\BondInstance;

/**
 * Class BondFairValueCalculatorTest
 */
class BondFairValueCalculatorTest extends PHPUnit_Framework_TestCase {
    private $bondInstanceDirectSemiAnnually,
            $bondInstanceFactorySemiAnnually;

    public function testFairValueDirectSemiAnnually() {
        $this->assertFairValue($this->bondInstanceDirectSemiAnnually);
    }

    public function testFairValueFactorySemiAnnually() {
        $this->assertFairValue($this->bondInstanceFactorySemiAnnually);
    }

    /** Test other factory methods */

    /**
     * Test annual coupons bond factory
     * (to get the same result as with the semi-annual coupons bond,
     * we need to halve the 'annual coupon rate' and 'VIR' values
     * and double the 'years to maturity')
     */
    public function testFairValueFactoryAnnually() {
        $this->assertFairValue(\FinanCalc\FinanCalc
            ::getInstance()
            ->getFactory('BondFairValueCalculatorFactory')
            ->newAnnualCouponsBond(10000, 0.06, 0.05, 15)
            ->getResult());
    }

    /**
     * Test quarterly coupons bond factory
     * (to get the same result as with the semi-annual coupons bond,
     * we need to double the 'annual coupon rate' and 'VIR' values
     * and halve the 'years to maturity')
     */
    public function testFairValueFactoryQuarterly() {
        $this->assertFairValue(\FinanCalc\FinanCalc
            ::getInstance()
            ->getFactory('BondFairValueCalculatorFactory')
            ->newQuarterlyCouponsBond(10000, 0.24, 0.2, 3.75)
            ->getResult());
    }

    /**
     * Test monthly coupons bond factory
     * (to get the same result as with the semi-annual coupons bond,
     * we need to sextuple the 'annual coupon rate' and 'VIR' values
     * and divide the 'years to maturity' by six)
     */
    public function testFairValueFactoryMonthly() {
        $this->assertFairValue(\FinanCalc\FinanCalc
            ::getInstance()
            ->getFactory('BondFairValueCalculatorFactory')
            ->newMonthlyCouponsBond(10000, 0.72, 0.6, 1.25)
            ->getResult());
    }

    /**
     * Test custom coupon frequency bond factory
     * We test the semi-annual coupon bond factory,
     * but manufactured by the custom bond coupon frequency
     * factory
     */
    public function testFairValueFactoryCustom() {
        return \FinanCalc\FinanCalc
            ::getInstance()
            ->getFactory('BondFairValueCalculatorFactory')
            ->newCustomCouponFrequencyBond(10000, 0.12, 0.1, 7.5, 6)
            ->getResult();
    }

    /**
     * @param BondInstance $bondInstance
     */
    private function assertFairValue(BondInstance $bondInstance) {
        $fairValue = $bondInstance->getBondFairValue();

        $this->assertEquals("11038", round($fairValue, 0));
    }

    /**
     * Test presence in the main factories array
     */
    public function testPresenceInMainFactoriesArray() {
        $this->assertTrue(
            isObjectTypeInArray('FinanCalc\\Calculators\\Factories\\BondFairvalueCalculatorFactory', \FinanCalc\FinanCalc::getInstance()->getFactories())
        );
    }

    /**
     * @return BondInstance
     */
    private function getBondInstanceDirectSemiAnnually() {
        $bondFairValueCalculator = new \FinanCalc\Calculators\BondFairValueCalculator(10000, 0.12, 0.1, 7.5, 2);
        return $bondFairValueCalculator->getResult();
    }

    /**
     * @return mixed
     * @throws Exception
     */
    private function getBondInstanceFactorySemiAnnually() {
        return \FinanCalc\FinanCalc
            ::getInstance()
            ->getFactory('BondFairValueCalculatorFactory')
            ->newSemiAnnualCouponsBond(10000, 0.12, 0.1, 7.5)
            ->getResult();
    }

    protected function setUp() {
        $this->bondInstanceDirectSemiAnnually = $this->getBondInstanceDirectSemiAnnually();
        $this->bondInstanceFactorySemiAnnually = $this->getBondInstanceFactorySemiAnnually();

        parent::setUp();
    }
}
