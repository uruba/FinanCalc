<?php

use FinanCalc\Calculators\DebtAmortizator;
use FinanCalc\Constants\Defaults;
use FinanCalc\FinanCalc;
use FinanCalc\Utils\MathFuncs;

/**
 * Class DebtAmortizatorTest
 */
class DebtAmortizatorTest extends PHPUnit_Framework_TestCase {

    /**
     * Test the "factory" version
     */
    public function testRepaymentsFactoryYearly() {
        // initialize a variable representing a DebtAmortizator
        // object obtained via a FACTORY method
        $debtAmortizatorFactory = FinanCalc
            ::getInstance()
            ->getFactory('DebtAmortizatorFactory')
            ->newYearlyDebtAmortization(
                40000,
                6,
                0.12);

        $result = $debtAmortizatorFactory->getResult();

        $this->processResult($result);
    }

    /**
     * Test the "direct" version
     */
    public function testRepaymentsDirectYearly() {
        // initialize a variable representing a DebtAmortizator
        // object obtained via DIRECT instantiation
        $debtAmortizatorDirect = new DebtAmortizator(
            40000,
            6,
            360,
            0.12);

        $result = $debtAmortizatorDirect->getResult();

        $this->processResult($result);
    }

    /**
     * Test the monthly factory version
     */
    public function testRepaymentsFactoryMonthly() {
        // initialize a variable representing a DebtAmortizator
        // object obtained via a FACTORY method
        $debtAmortizatorFactory = FinanCalc
            ::getInstance()
            ->getFactory('DebtAmortizatorFactory')
            ->newMonthlyDebtAmortization(
                40000,
                6,
                0.12);

        $result = $debtAmortizatorFactory->getResult();

        $this->processResult($result);
    }

    /**
     * Test the daily factory version
     */
    public function testRepaymentsFactoryDaily() {
        // initialize a variable representing a DebtAmortizator
        // object obtained via a FACTORY method
        $debtAmortizatorFactory = FinanCalc
            ::getInstance()
            ->getFactory('DebtAmortizatorFactory')
            ->newDailyDebtAmortization(
                40000,
                6,
                0.12);

        $result = $debtAmortizatorFactory->getResult();

        $this->processResult($result);
    }

    /**
     * Test the yearly version, manufactured by a custom period length factory
     */
    public function testRepaymentsFactoryCustom() {
        // initialize a variable representing a DebtAmortizator
        // object obtained via a FACTORY method
        $debtAmortizatorFactory = FinanCalc
            ::getInstance()
            ->getFactory('DebtAmortizatorFactory')
            ->newDebtAmortizationCustomPeriodLength(
                40000,
                6,
                0.12,
                360);

        $result = $debtAmortizatorFactory->getResult();

        $this->processResult($result);
    }

    /**
     * @param \FinanCalc\Calculators\DebtAmortizator\DebtInstance $result
     */
    private function processResult(\FinanCalc\Calculators\DebtAmortizator\DebtInstance $result) {
        $this->assertEquals("40000", $result->getDebtPrincipal());
        $this->assertEquals("6", $result->getDebtNoOfCompoundingPeriods());

        $this->assertEquals(
            MathFuncs::div(
                $result->getDebtPeriodLengthInDays(),
                Defaults::LENGTH_YEAR_360_30
            ),
            $result->getDebtPeriodLengthInYears());
        $this->assertEquals(
            MathFuncs::div(
                $result->getDebtPeriodLengthInDays(),
                Defaults::LENGTH_MONTH_360_30
            ),
            $result->getDebtPeriodLengthInMonths());

        $this->assertEquals(
            MathFuncs::div(
                $result->getDebtDurationInDays(),
                Defaults::LENGTH_YEAR_360_30
            ),
            $result->getDebtDurationInYears());
        $this->assertEquals(
            MathFuncs::div(
                $result->getDebtDurationInDays(),
                Defaults::LENGTH_MONTH_360_30
            ),
            $result->getDebtDurationInMonths());

        $this->assertEquals("0.12", $result->getDebtInterest());

        $repayments = $result->getDebtRepayments();

        $INDIVIDUAL_REPAYMENT = "9729.03";
        $this->assertEquals("4929.03", $repayments[0]->getPrincipalAmount());
        $this->assertEquals("4800.00", $repayments[0]->getInterestAmount());
        $this->assertEquals($INDIVIDUAL_REPAYMENT, $repayments[0]->getTotalAmount());

        $this->assertEquals("5520.51", $repayments[1]->getPrincipalAmount());
        $this->assertEquals("4208.52", $repayments[1]->getInterestAmount());
        $this->assertEquals($INDIVIDUAL_REPAYMENT, $repayments[1]->getTotalAmount());

        $this->assertEquals("6182.97", $repayments[2]->getPrincipalAmount());
        $this->assertEquals("3546.06", $repayments[2]->getInterestAmount(), "3546.06");
        $this->assertEquals($INDIVIDUAL_REPAYMENT, $repayments[2]->getTotalAmount(), $INDIVIDUAL_REPAYMENT);

        $this->assertEquals("6924.93", $repayments[3]->getPrincipalAmount());
        $this->assertEquals("2804.10", $repayments[3]->getInterestAmount());
        $this->assertEquals($INDIVIDUAL_REPAYMENT, $repayments[3]->getTotalAmount());

        $this->assertEquals("7755.92", $repayments[4]->getPrincipalAmount());
        $this->assertEquals("1973.11", $repayments[4]->getInterestAmount());
        $this->assertEquals($INDIVIDUAL_REPAYMENT, $repayments[4]->getTotalAmount());

        $this->assertEquals("8686.63", $repayments[5]->getPrincipalAmount());
        $this->assertEquals("1042.4", $repayments[5]->getInterestAmount());
        $this->assertEquals($INDIVIDUAL_REPAYMENT, $repayments[5]->getTotalAmount());
    }

    /**
     * Test presence in the main factories array
     */
    public function testPresenceInMainFactoriesArray() {
        $this->assertTrue(
            isObjectTypeInArray('FinanCalc\\Calculators\\Factories\\BondYTMCalculatorFactory', \FinanCalc\FinanCalc::getInstance()->getFactories())
        );
    }
}
