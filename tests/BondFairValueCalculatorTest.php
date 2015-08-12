<?php

use FinanCalc\Calculators\BondFairValueCalculator\BondInstance;

/**
 * Class BondFairValueCalculatorTest
 */
class BondFairValueCalculatorTest extends PHPUnit_Framework_TestCase {
    private $bondInstanceDirectSemiAnnually,
            $bondInstanceFactorySemiAnnually;

    public function testFairValueDirect() {
        $this->assertFairValue($this->bondInstanceDirectSemiAnnually);
    }

    public function testFairValueFactory() {
        $this->assertFairValue($this->bondInstanceFactorySemiAnnually);
    }

    /**
     * @param BondInstance $bondInstance
     */
    private function assertFairValue(BondInstance $bondInstance) {
        $fairValue = $bondInstance->getBondFairValue();

        $this->assertEquals("11038", round($fairValue, 0));
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
