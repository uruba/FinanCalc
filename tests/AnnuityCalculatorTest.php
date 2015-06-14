<?php

use FinanCalc\Calculators\AnnuityCalculator\AnnuityInstance;
use FinanCalc\Constants\AnnuityPaymentTypes;

class AnnuityCalculatorTest extends PHPUnit_Framework_TestCase {
    private $annuityInstanceDirect,
            $annuityInstanceFactory,
            $perpetuityInstance;

    /**
     * Test the PV in arrears
     */
    public function testPVInArrearsDirect() {
        $this->assertPVInArrears($this->annuityInstanceDirect);
    }

    public function testPVInArrearsFactory() {
        $this->assertPVInArrears($this->annuityInstanceFactory);
    }

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
        $this->assertFVInArrears($this->annuityInstanceDirect);
    }

    public function testFVInArrearsFactory() {
        $this->assertFVInArrears($this->annuityInstanceFactory);
    }

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
        $this->assertPVInAdvance($this->annuityInstanceDirect);
    }

    public function testPVInAdvanceFactory() {
        $this->assertPVInAdvance($this->annuityInstanceFactory);
    }

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
        $this->assertFVInAdvance($this->annuityInstanceDirect);
    }

    public function testFVInAdvanceFactory() {
        $this->assertFVInAdvance($this->annuityInstanceFactory);
    }

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
    private function getAnnuityInstanceDirect() {
        $annuityCalculator = new \FinanCalc\Calculators\AnnuityCalculator(100000, 5, 0.15, 360);
        return $annuityCalculator->getResult();
    }

    /**
     * @return \FinanCalc\Calculators\AnnuityCalculator\AnnuityInstance
     * @throws \FinanCalc\Exception
     */
    private function getAnnuityInstanceFactory() {
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
        $this->annuityInstanceDirect = $this->getAnnuityInstanceDirect();
        $this->annuityInstanceFactory = $this->getAnnuityInstanceFactory();
        $this->perpetuityInstance = $this->getPerpetuity();


        parent::setUp();
    }
}
