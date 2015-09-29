<?php

use FinanCalc\Calculators\AnnuityCalculator;
use FinanCalc\Constants\AnnuityPaymentTypes;
use FinanCalc\Utils\Time\TimeSpan;

/**
 * Class AnnuityCalculatorTest
 */
class AnnuityCalculatorTest extends PHPUnit_Framework_TestCase {
    /** @var  AnnuityCalculator */
    private $annuityCalculatorDirectYearly,
            $annuityCalculatorFactoryYearly,
            $perpetuityCalculator;

    /**
     * Test the annuity length
     */
    public function testAnnuityLengthDirect() {
        $this->assertLengthAndEndDate($this->annuityCalculatorDirectYearly);
    }

    public function testAnnuityLengthFactory() {
        $this->assertLengthAndEndDate($this->annuityCalculatorFactoryYearly);
    }

    /**
     * @param AnnuityCalculator $annuityCalculator
     */
    private function assertLengthAndEndDate(AnnuityCalculator $annuityCalculator) {
        $this->assertLengthYears($annuityCalculator);
        $this->assertLengthMonths($annuityCalculator);
        $this->assertLengthDays($annuityCalculator);
        $this->assertEndDate($annuityCalculator);
    }

    /**
     * @param AnnuityCalculator $annuityCalculator
     */
    private function assertLengthYears(AnnuityCalculator $annuityCalculator) {
        $this->assertEquals(5, $annuityCalculator->getAnnuityLengthInYears());
    }

    /**
     * @param AnnuityCalculator $annuityCalculator
     */
    private function assertLengthMonths(AnnuityCalculator $annuityCalculator) {
        $this->assertEquals(60, $annuityCalculator->getAnnuityLengthInMonths());
    }

    /**
     * @param AnnuityCalculator $annuityCalculator
     */
    private function assertLengthDays(AnnuityCalculator $annuityCalculator) {
        $this->assertEquals(1800, $annuityCalculator->getAnnuityLengthInDays());
    }

    /**
     * @param AnnuityCalculator $annuityCalculator
     */
    private function assertEndDate(AnnuityCalculator $annuityCalculator) {
        $dateStart = new DateTime();
        $dateEnd = clone $dateStart;
        $dateEnd->add(new DateInterval("P" . (int)$annuityCalculator->getAnnuityLengthInDays() . "D"));

        $this->assertEquals(
            $dateEnd,
            $annuityCalculator->getAnnuityEndDate($dateStart)
        );
    }

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
            TimeSpan::asDuration(0,1,0),
            $annuityCalculatorFactoryMonthly
                ->getAnnuityPeriodLength()
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
            TimeSpan::asDuration(0,0,1),
            $annuityCalculatorFactoryDaily
                ->getAnnuityPeriodLength()
        );

        $this->assertEquals(
            1,
            $annuityCalculatorFactoryDaily
                ->getAnnuityPeriodLengthInDays()
        );
    }

    public function testAnnuityToPerpetuity() {
        $annuityCalculatorYearly = $this->newAnnuityCalculatorFactoryYearly();
        $annuityCalculatorPerpetuity = $this->newPerpetuity();

        $annuityCalculatorYearly->setAnnuityNoOfCompoundingPeriods(0);
        $annuityCalculatorYearly->setAnnuitySinglePaymentAmount(50);
        $annuityCalculatorYearly->setAnnuityInterest(0.08);

        $this->assertEquals($annuityCalculatorPerpetuity, $annuityCalculatorYearly);
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
     * @return \FinanCalc\Calculators\AnnuityCalculator
     */
    private function newAnnuityCalculatorDirectYearly() {
        return new AnnuityCalculator(100000, 5, TimeSpan::asDuration(1), 0.15);
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
