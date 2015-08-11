<?php

use FinanCalc\Calculators\DebtAmortizator;
use FinanCalc\Constants\AnnuityPaymentTypes;
use FinanCalc\FinanCalc;

/**
 * Class DebtAmortizatorTest
 */
class DebtAmortizatorTest extends PHPUnit_Framework_TestCase {

    /**
     * Test the "factory" version
     */
    public function testRepaymentsFactory() {
        // initialize a variable representing a DebtAmortizator
        // object obtained via a FACTORY method
        $annuityCalculatorFactory = FinanCalc
            ::getInstance()
            ->getFactory('DebtAmortizatorFactory')
            ->newYearlyDebtAmortizationInArrears(
                40000,
                6,
                0.12);

        $this->processResult($annuityCalculatorFactory->getResult());
    }

    /**
     * Test the "direct" version
     */
    public function testRepaymentsDirect() {
        // initialize a variable representing a DebtAmortizator
        // object obtained via DIRECT instantiation
        $annuityCalculatorDirect = new DebtAmortizator(
            40000,
            6,
            360,
            0.12,
            new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ARREARS));

        $this->processResult($annuityCalculatorDirect->getResult());
    }

    /**
     * @param \FinanCalc\Calculators\DebtAmortizator\DebtInstance $result
     */
    private function processResult(\FinanCalc\Calculators\DebtAmortizator\DebtInstance $result) {
        $this->assertEquals($result->getDebtPrincipal(), "40000");
        $this->assertEquals($result->getDebtNoOfCompoundingPeriods(), "6");

        $this->assertEquals($result->getDebtPeriodLengthInYears(), "1");
        $this->assertEquals($result->getDebtPeriodLengthInMonths(), "12");
        $this->assertEquals($result->getDebtPeriodLengthInDays(), "360");

        $this->assertEquals($result->getDebtDurationInYears(), "6");
        $this->assertEquals($result->getDebtDurationInMonths(), "72");
        $this->assertEquals($result->getDebtDurationInDays(), "2160");

        $this->assertEquals($result->getDebtInterest(), "0.12");

        $repayments = $result->getDebtRepayments();

        $INDIVIDUAL_REPAYMENT = "9729.03";
        $this->assertEquals($repayments[0]->getPrincipalAmount(), "4929.03");
        $this->assertEquals($repayments[0]->getInterestAmount(), "4800.00");
        $this->assertEquals($repayments[0]->getTotalAmount(), $INDIVIDUAL_REPAYMENT);

        $this->assertEquals($repayments[1]->getPrincipalAmount(), "5520.51");
        $this->assertEquals($repayments[1]->getInterestAmount(), "4208.52");
        $this->assertEquals($repayments[1]->getTotalAmount(), $INDIVIDUAL_REPAYMENT);

        $this->assertEquals($repayments[2]->getPrincipalAmount(), "6182.97");
        $this->assertEquals($repayments[2]->getInterestAmount(), "3546.06");
        $this->assertEquals($repayments[2]->getTotalAmount(), $INDIVIDUAL_REPAYMENT);

        $this->assertEquals($repayments[3]->getPrincipalAmount(), "6924.93");
        $this->assertEquals($repayments[3]->getInterestAmount(), "2804.10");
        $this->assertEquals($repayments[3]->getTotalAmount(), $INDIVIDUAL_REPAYMENT);

        $this->assertEquals($repayments[4]->getPrincipalAmount(), "7755.92");
        $this->assertEquals($repayments[4]->getInterestAmount(), "1973.11");
        $this->assertEquals($repayments[4]->getTotalAmount(), $INDIVIDUAL_REPAYMENT);

        $this->assertEquals($repayments[5]->getPrincipalAmount(), "8686.63");
        $this->assertEquals($repayments[5]->getInterestAmount(), "1042.4");
        $this->assertEquals($repayments[5]->getTotalAmount(), $INDIVIDUAL_REPAYMENT);
    }

}
