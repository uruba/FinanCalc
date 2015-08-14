<?php

use FinanCalc\Calculators\BondYTMCalculator\BondInstance;

/**
 * Class BondYTMCalculatorTest
 */
class BondYTMCalculatorTest extends PHPUnit_Framework_TestCase {
    private $bondInstanceDirectAnnually,
            $bondInstanceFactoryAnnually;

    public function testApproxBondYTMDirect() {
        $this->assertApproxBondYTM($this->bondInstanceDirectAnnually);
    }

    public function testApproxBondYTMFactory() {
        $this->assertApproxBondYTM($this->bondInstanceFactoryAnnually);
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
            ->newAnnualCouponsBond(10000,10800, 0.146, 3)
            ->getResult();
    }

    protected function setUp() {
        $this->bondInstanceDirectAnnually = $this->getBondInstanceDirectAnnually();
        $this->bondInstanceFactoryAnnually = $this->getBondInstanceFactoryAnnually();

        parent::setUp();
    }
}
