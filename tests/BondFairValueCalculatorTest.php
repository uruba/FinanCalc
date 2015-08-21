<?php

use FinanCalc\Calculators\BondFairValueCalculator;

/**
 * Class BondFairValueCalculatorTest
 */
class BondFairValueCalculatorTest extends PHPUnit_Framework_TestCase {
    private $bondFairValueCalculatorDirectSemiAnnually,
            $bondFairValueCalculatorFactorySemiAnnually;

    public function testFairValueDirectSemiAnnually() {
        $this->assertFairValue($this->bondFairValueCalculatorDirectSemiAnnually);
    }

    public function testFairValueFactorySemiAnnually() {
        $this->assertFairValue($this->bondFairValueCalculatorFactorySemiAnnually);
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
            ->newAnnualCouponsBond(10000, 0.06, 0.05, 15));
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
            ->newQuarterlyCouponsBond(10000, 0.24, 0.2, 3.75));
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
            ->newMonthlyCouponsBond(10000, 0.72, 0.6, 1.25));
    }

    /**
     * Test custom coupon frequency bond factory
     * We test the semi-annual coupon bond factory,
     * but manufactured by the custom bond coupon frequency
     * factory
     */
    public function testFairValueFactoryCustom() {
        $this->assertFairValue(\FinanCalc\FinanCalc
            ::getInstance()
            ->getFactory('BondFairValueCalculatorFactory')
            ->newCustomCouponFrequencyBond(10000, 0.12, 0.1, 7.5, 2));
    }


    /**
     * @param BondFairValueCalculator $bondFairValueCalculator
     */
    private function assertFairValue(BondFairValueCalculator $bondFairValueCalculator) {
        $fairValue_direct = $bondFairValueCalculator->getResult()->getBondFairValue();
        $fairValue_array = $bondFairValueCalculator->getResultAsArray()["bondFairValue"];

        $expected = "11038";
        $this->assertEquals($expected, round($fairValue_direct, 0));
        $this->assertEquals($expected, round($fairValue_array, 0));
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
     * @return BondFairValueCalculator
     */
    private function getBondFairValueCalculatorDirectSemiAnnually() {
        return new BondFairValueCalculator(10000, 0.12, 0.1, 7.5, 2);
    }

    /**
     * @return mixed
     * @throws Exception
     */
    private function getBondFairValueCalculatorFactorySemiAnnually() {
        return \FinanCalc\FinanCalc
            ::getInstance()
            ->getFactory('BondFairValueCalculatorFactory')
            ->newSemiAnnualCouponsBond(10000, 0.12, 0.1, 7.5);
    }

    protected function setUp() {
        $this->bondFairValueCalculatorDirectSemiAnnually = $this->getBondFairValueCalculatorDirectSemiAnnually();
        $this->bondFairValueCalculatorFactorySemiAnnually = $this->getBondFairValueCalculatorFactorySemiAnnually();

        parent::setUp();
    }
}
