<?php
use FinanCalc\Calculators\BondDurationCalculator\BondInstance;


/**
 * Class BondDurationCalculatorTest
 */
class BondDurationCalculatorTest extends PHPUnit_Framework_TestCase {
    private $bondInstanceDirectAnnually,
            $bondInstanceFactoryAnnually;

    public function testDurationDirectAnnually() {
        $this->assertDuration($this->bondInstanceDirectAnnually);
    }

    public function testDurationFactoryAnnually() {
        $this->assertDuration($this->bondInstanceFactoryAnnually);
    }

    /**
     * Test other factory methods
     */

    /**
     * Test semi-annual coupons bond factory
     * (to get the same result as with the annual coupons bond,
     * we need to halve the 'years to maturity' value
     * and double the 'annual coupon rate' and 'annual yield')
     */
    public function testDurationFactorySemiAnnually() {
        $this->assertDuration(\FinanCalc\FinanCalc
            ::getInstance()
            ->getFactory('BondDurationCalculatorFactory')
            ->newSemiAnnualCouponsBond(1000, 0.16, 0.2, 1.5)
            ->getResult());
    }

    /**
     * Test quarterly coupons bond factory
     * (to get the same result as with the annual coupons bond,
     * we need to divide the 'years to maturity' value by four
     * and quadruple the 'annual coupon rate' and 'annual yield')
     */
    public function testDurationFactoryQuarterly() {
        $this->assertDuration(\FinanCalc\FinanCalc
            ::getInstance()
            ->getFactory('BondDurationCalculatorFactory')
            ->newQuarterlyCouponsBond(1000, 0.32, 0.4, 0.75)
            ->getResult());
    }

    /**
     * Test monthly coupons bond factory
     * (to get the same result as with the annual coupons bond,
     * we need to divide the 'years to maturity' value by twelve
     * and multiply the 'annual coupon rate' and 'annual yield'
     */
    public function testDurationFactoryMonthly() {
        $this->assertDuration(\FinanCalc\FinanCalc
            ::getInstance()
            ->getFactory('BondDurationCalculatorFactory')
            ->newMonthlyCouponsBond(1000, 0.96, 1.2, 0.25)
            ->getResult());
    }

    /**
     * Test custom coupon frequency bond factory
     * We test the annual coupon bond factory,
     * but manufactured by the custom bond coupon frequency
     * factory
     */
    public function testDurationFactoryCustom() {
        $this->assertDuration(\FinanCalc\FinanCalc
            ::getInstance()
            ->getFactory('BondDurationCalculatorFactory')
            ->newCustomCouponFrequencyBond(1000, 0.08, 0.1, 3, 1)
            ->getResult());
    }

    /**
     * @param BondInstance $bondInstance
     */
    private function assertDuration(BondInstance $bondInstance) {
        $duration = $bondInstance->getBondDuration();

        $this->assertEquals("2.78", round($duration, 2));
    }

    /**
     * Test presence in the main factories array
     */
    public function testPresenceInMainFactoriesArray() {
        $this->assertTrue(
            isObjectTypeInArray('FinanCalc\\Calculators\\Factories\\BondDurationCalculatorFactory', \FinanCalc\FinanCalc::getInstance()->getFactories())
        );
    }

    /**
     * @return BondInstance
     */
    private function getBondInstanceDirectAnnually() {
        $bondDurationCalculator = new \FinanCalc\Calculators\BondDurationCalculator(1000, 0.08, 0.1, 3);
        return $bondDurationCalculator->getResult();
    }

    /**
     * @return mixed
     * @throws Exception
     */
    private function getBondInstanceFactoryAnnually() {
        return \FinanCalc\FinanCalc
            ::getInstance()
            ->getFactory('BondDurationCalculatorFactory')
            ->newAnnualCouponsBond(1000, 0.08, 0.1, 3)
            ->getResult();
    }

    protected function setUp() {
        $this->bondInstanceDirectAnnually = $this->getBondInstanceDirectAnnually();
        $this->bondInstanceFactoryAnnually = $this->getBondInstanceFactoryAnnually();

        parent::setUp();
    }
}
