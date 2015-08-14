<?php
use FinanCalc\Calculators\BondDurationCalculator\BondInstance;


/**
 * Class BondDurationCalculatorTest
 */
class BondDurationCalculatorTest extends PHPUnit_Framework_TestCase {
    private $bondInstanceDirectAnnually,
            $bondInstanceFactoryAnnually;

    public function testDurationDirect() {
        $this->assertDuration($this->bondInstanceDirectAnnually);
    }

    public function testDurationFactory() {

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
