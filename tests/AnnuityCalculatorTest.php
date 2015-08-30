<?php

use FinanCalc\Calculators\AnnuityCalculator;
use FinanCalc\Constants\AnnuityPaymentTypes;
use FinanCalc\Utils\TimeUtils;

/**
 * Class AnnuityCalculatorTest
 */
class AnnuityCalculatorTest extends PHPUnit_Framework_TestCase {
    private $annuityCalculatorDirectYearly,
            $annuityCalculatorFactoryYearly,
            $perpetuityCalculator;

    /**
     * Test the PV in arrears
     */
    public function testPVInArrearsDirect() {
        $this->assertPVInArrears($this->annuityCalculatorDirectYearly);
    }

    public function testPVInArrearsFactory() {
        $this->assertPVInArrears($this->annuityCalculatorFactoryYearly);
    }


    /**
     * @param AnnuityCalculator $annuityCalculator
     */
    private function assertPVInArrears(AnnuityCalculator $annuityCalculator) {
        $PV_direct = $annuityCalculator->getAnnuityPresentValue(
            new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ARREARS)
        );

        $PV_array = $annuityCalculator
            ->getResultAsArray()["annuityPresentValue"]["in_arrears"];

        $expected = "335216";
        $this->assertEquals($expected, round($PV_direct, 0));
        $this->assertEquals($expected, round($PV_array, 0));
    }

    /**
     * Test the FV in arrears
     */
    public function testFVInArrearsDirect() {
        $this->assertFVInArrears($this->annuityCalculatorDirectYearly);
    }

    public function testFVInArrearsFactory() {
        $this->assertFVInArrears($this->annuityCalculatorFactoryYearly);
    }


    /**
     * @param AnnuityCalculator $annuityCalculator
     */
    private function assertFVInArrears(AnnuityCalculator $annuityCalculator) {
        $FV_direct = $annuityCalculator->getAnnuityFutureValue(
            new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ARREARS)
        );

        $FV_array = $annuityCalculator
            ->getResultAsArray()["annuityFutureValue"]["in_arrears"];

        $expected = "674238";
        $this->assertEquals($expected, round($FV_direct, 0));
        $this->assertEquals($expected, round($FV_array, 0));
    }

    /**
     * Test the PV in advance
     */
    public function testPVInAdvanceDirect() {
        $this->assertPVInAdvance($this->annuityCalculatorDirectYearly);
    }

    public function testPVInAdvanceFactory() {
        $this->assertPVInAdvance($this->annuityCalculatorFactoryYearly);
    }


    /**
     * @param AnnuityCalculator $annuityCalculator
     */
    private function assertPVInAdvance(AnnuityCalculator $annuityCalculator) {
        $PV_direct = $annuityCalculator->getAnnuityPresentValue(
            new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ADVANCE)
        );

        $PV_array = $annuityCalculator
            ->getResultAsArray()["annuityPresentValue"]["in_advance"];

        $expected = "385498";
        $this->assertEquals($expected, round($PV_direct, 0));
        $this->assertEquals($expected, round($PV_array, 0));
    }

    /**
     * Test the FV in advance
     */
    public function testFVInAdvanceDirect() {
        $this->assertFVInAdvance($this->annuityCalculatorDirectYearly);
    }

    public function testFVInAdvanceFactory() {
        $this->assertFVInAdvance($this->annuityCalculatorFactoryYearly);
    }


    /**
     * @param AnnuityCalculator $annuityCalculator
     */
    private function assertFVInAdvance(AnnuityCalculator $annuityCalculator) {
        $FV_direct = $annuityCalculator->getAnnuityFutureValue(
            new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ADVANCE)
        );

        $FV_array = $annuityCalculator
            ->getResultAsArray()["annuityFutureValue"]["in_advance"];

        $expected = "775374";
        $this->assertEquals($expected, round($FV_direct, 0));
        $this->assertEquals($expected, round($FV_array, 0));
    }

    /**
     * Test perpetuity
     */
    public function testPVPerpetuity() {
        $PV_direct = $this->perpetuityCalculator->getAnnuityPresentValue();

        $PV_array_advance = $this->perpetuityCalculator->getResultAsArray()["annuityPresentValue"]["in_advance"];
        $PV_array_arrears = $this->perpetuityCalculator->getResultAsArray()["annuityPresentValue"]["in_arrears"];

        $expected = "625";
        $this->assertEquals($expected, $PV_direct);
        $this->assertEquals($expected, $PV_array_advance);
        $this->assertEquals($expected, $PV_array_arrears);
    }

    public function testFVPerpetuity() {
        $FV_direct = $this->perpetuityCalculator->getAnnuityFutureValue();

        $FV_array_advance = $this->perpetuityCalculator->getResultAsArray()["annuityFutureValue"]["in_advance"];
        $FV_array_arrears = $this->perpetuityCalculator->getResultAsArray()["annuityFutureValue"]["in_arrears"];

        $this->assertNull($FV_direct);
        $this->assertNull($FV_array_advance);
        $this->assertNull($FV_array_arrears);
    }

    /**
     * Test monthly annuity factory
     */
    public function testMonthlyAnnuityFactory() {
        $annuityCalculatorFactoryMonthly = $this->newAnnuityCalculatorFactoryMonthly();

        $this->assertFVInAdvance(
            $annuityCalculatorFactoryMonthly
        );

        $this->assertFVInArrears(
            $annuityCalculatorFactoryMonthly
        );

        $this->assertPVInAdvance(
            $annuityCalculatorFactoryMonthly
        );

        $this->assertPVInArrears(
            $annuityCalculatorFactoryMonthly
        );

        $this->assertEquals(
            1,
            $annuityCalculatorFactoryMonthly

                ->getAnnuityPeriodLengthInMonths()
        );
    }

    /**
     * @return mixed
     * @throws Exception
     */
    private function newAnnuityCalculatorFactoryMonthly() {
        return \FinanCalc\FinanCalc
            ::getInstance()
            ->getFactory('AnnuityCalculatorFactory')
            ->newMonthlyAnnuity(100000, 5, 0.15);
    }

    /**
     * Test daily annuity factory
     */
    public function testDailyAnnuityFactory() {
        $annuityCalculatorFactoryDaily = $this->newAnnuityCalculatorFactoryDaily();

        $this->assertFVInAdvance(
            $annuityCalculatorFactoryDaily
        );

        $this->assertFVInArrears(
            $annuityCalculatorFactoryDaily
        );

        $this->assertPVInAdvance(
            $annuityCalculatorFactoryDaily
        );

        $this->assertPVInArrears(
            $annuityCalculatorFactoryDaily
        );

        $this->assertEquals(
            1,
            $annuityCalculatorFactoryDaily

                ->getAnnuityPeriodLengthInDays()
        );
    }

    /**
     * @return mixed
     * @throws Exception
     */
    private function newAnnuityCalculatorFactoryDaily() {
        return \FinanCalc\FinanCalc
            ::getInstance()
            ->getFactory('AnnuityCalculatorFactory')
            ->newDailyAnnuity(100000, 5, 0.15);
    }

    /**
     * Test presence in the main Factories array
     */
    public function testPresenceInMainFactoriesArray() {
        $this->assertTrue(
            isObjectTypeInArray('FinanCalc\\Calculators\\Factories\\AnnuityCalculatorFactory', \FinanCalc\FinanCalc::getInstance()->getFactories())
        );
    }

    /**
     * @return \FinanCalc\Calculators\AnnuityCalculator
     */
    private function newAnnuityCalculatorDirectYearly() {
        return new AnnuityCalculator(100000, 5, TimeUtils::getDaysFromYears(1), 0.15);
    }

    /**
     * @return \FinanCalc\Calculators\AnnuityCalculator
     * @throws Exception
     */
    private function newAnnuityCalculatorFactoryYearly() {
        return \FinanCalc\FinanCalc
            ::getInstance()
            ->getFactory('AnnuityCalculatorFactory')
            ->newYearlyAnnuity(100000, 5, 0.15);
    }

    /**
     * @return \FinanCalc\Calculators\AnnuityCalculator
     * @throws Exception
     */
    private function newPerpetuity() {
        return \FinanCalc\FinanCalc
            ::getInstance()
            ->getFactory('AnnuityCalculatorFactory')
            ->newPerpetuity(50, 0.08);
    }

    protected function setUp() {
        $this->annuityCalculatorDirectYearly = $this->newAnnuityCalculatorDirectYearly();
        $this->annuityCalculatorFactoryYearly = $this->newAnnuityCalculatorFactoryYearly();
        $this->perpetuityCalculator = $this->newPerpetuity();

        parent::setUp();
    }
}
