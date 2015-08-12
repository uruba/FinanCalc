<?php

use FinanCalc\Calculators\AnnuityCalculator\AnnuityInstance;
use FinanCalc\Constants\AnnuityPaymentTypes;

/**
 * Class AnnuityCalculatorTest
 */
class AnnuityCalculatorTest extends PHPUnit_Framework_TestCase {
    private $annuityInstanceDirectYearly,
            $annuityInstanceFactoryYearly,
            $perpetuityInstance;

    /**
     * Test the PV in arrears
     */
    public function testPVInArrearsDirect() {
        $this->assertPVInArrears($this->annuityInstanceDirectYearly);
    }

    public function testPVInArrearsFactory() {
        $this->assertPVInArrears($this->annuityInstanceFactoryYearly);
    }

    /**
     * @param AnnuityInstance $annuityInstance
     */
    private function assertPVInArrears(AnnuityInstance $annuityInstance) {
        $PV = $annuityInstance->getPresentValue(
            new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ARREARS)
        );

        $this->assertEquals("335216", round($PV, 0));
    }

    /**
     * Test the FV in arrears
     */
    public function testFVInArrearsDirect() {
        $this->assertFVInArrears($this->annuityInstanceDirectYearly);
    }

    public function testFVInArrearsFactory() {
        $this->assertFVInArrears($this->annuityInstanceFactoryYearly);
    }

    /**
     * @param AnnuityInstance $annuityInstance
     */
    private function assertFVInArrears(AnnuityInstance $annuityInstance) {
        $FV = $annuityInstance->getFutureValue(
            new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ARREARS)
        );

        $this->assertEquals("674238", round($FV, 0));
    }

    /**
     * Test the PV in advance
     */
    public function testPVInAdvanceDirect() {
        $this->assertPVInAdvance($this->annuityInstanceDirectYearly);
    }

    public function testPVInAdvanceFactory() {
        $this->assertPVInAdvance($this->annuityInstanceFactoryYearly);
    }

    /**
     * @param AnnuityInstance $annuityInstance
     */
    private function assertPVInAdvance(AnnuityInstance $annuityInstance) {
        $PV = $annuityInstance->getPresentValue(
            new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ADVANCE)
        );

        $this->assertEquals("385498", round($PV, 0));
    }

    /**
     * Test the FV in advance
     */
    public function testFVInAdvanceDirect() {
        $this->assertFVInAdvance($this->annuityInstanceDirectYearly);
    }

    public function testFVInAdvanceFactory() {
        $this->assertFVInAdvance($this->annuityInstanceFactoryYearly);
    }

    /**
     * @param AnnuityInstance $annuityInstance
     */
    private function assertFVInAdvance(AnnuityInstance $annuityInstance) {
        $FV = $annuityInstance->getFutureValue(
            new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ADVANCE)
        );

        $this->assertEquals("775374", round($FV, 0));
    }

    /**
     * Test perpetuity
     */
    public function testPVPerpetuity() {
        $PV = $this->perpetuityInstance->getPresentValue();

        $this->assertEquals("625", $PV);
    }

    public function testFVPerpetuity() {
        $FV = $this->perpetuityInstance->getFutureValue();

        $this->assertNull($FV);
    }

    /**
     * @return \FinanCalc\Calculators\AnnuityCalculator\AnnuityInstance
     */
    private function getAnnuityInstanceDirectYearly() {
        $annuityCalculator = new \FinanCalc\Calculators\AnnuityCalculator(100000, 5, 0.15, 360);
        return $annuityCalculator->getResult();
    }

    /**
     * @return \FinanCalc\Calculators\AnnuityCalculator\AnnuityInstance
     * @throws \FinanCalc\Exception
     */
    private function getAnnuityInstanceFactoryYearly() {
        return \FinanCalc\FinanCalc
            ::getInstance()
            ->getFactory('AnnuityCalculatorFactory')
            ->newYearlyAnnuity(100000, 5, 0.15)
            ->getResult();
    }

    /**
     * @return \FinanCalc\Calculators\AnnuityCalculator\AnnuityInstance
     * @throws \FinanCalc\Exception
     */
    private function getPerpetuity() {
        return \FinanCalc\FinanCalc
            ::getInstance()
            ->getFactory('AnnuityCalculatorFactory')
            ->newPerpetuity(50, 0.08)
            ->getResult();
    }

    protected function setUp() {
        $this->annuityInstanceDirectYearly = $this->getAnnuityInstanceDirectYearly();
        $this->annuityInstanceFactoryYearly = $this->getAnnuityInstanceFactoryYearly();
        $this->perpetuityInstance = $this->getPerpetuity();


        parent::setUp();
    }
}
