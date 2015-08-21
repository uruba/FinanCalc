<?php

use FinanCalc\FinanCalc;
use FinanCalc\Utils\Serializers\XMLSerializer;

/**
 * Class SerializersTest
 */
class SerializersTest extends PHPUnit_Framework_TestCase
{
    public function testXMLSerializer() {
        // we will test the serializer on the most complex class with nested elements
        // the example is the same as in the DebtAmortizatorTest
        $debtAmortizatorFactory = FinanCalc
                                    ::getInstance()
                                    ->getFactory('DebtAmortizatorFactory')
                                    ->newYearlyDebtAmortization(
                                            40000,
                                            6,
                                            0.12);

        $xml_output = $debtAmortizatorFactory
                ->getSerializedResult(new XMLSerializer());

        $xmlObject = new SimpleXMLElement($xml_output);

        $round2DP = function ($roundedObject) {
            return round((float)$roundedObject, 2);
        };

        // WE WILL TEST EACH AND EVERY PROPERTY OF THIS OBJECT

        // Debt principal
        $this->assertEquals(
            "40000",
            $xmlObject->debtPrincipal
        );
        // Debt number of compounding periods
        $this->assertEquals(
            "6",
            $xmlObject->debtNoOfCompoundingPeriods
        );
        // Debt length period
        $this->assertEquals(
            "1",
            $xmlObject->debtPeriodLength->years
        );
        $this->assertEquals(
            "12",
            $xmlObject->debtPeriodLength->months
        );
        $this->assertEquals(
            "360",
            $xmlObject->debtPeriodLength->days
        );
        // Debt interest
        $this->assertEquals(
            "0.12",
            $xmlObject->debtInterest
        );
        // Debt discount factor
        $this->assertEquals(
            "0.89",
            $round2DP($xmlObject->debtDiscountFactor)
        );
        // Debt duration
        $this->assertEquals(
            "6",
            $xmlObject->debtDuration->years
        );
        $this->assertEquals(
            "72",
            $xmlObject->debtDuration->months
        );
        $this->assertEquals(
            "2160",
            $xmlObject->debtDuration->days
        );
        // Debt amount of single repayment
        $INDIVIDUAL_REPAYMENT = "9729.03";
        $this->assertEquals(
            $INDIVIDUAL_REPAYMENT,
            $round2DP($xmlObject->debtSingleRepayment)
        );
        // Debt repayments (principal part, interest part, total = principal part + interest part)
        $this->assertEquals(
            "4929.03",
            $round2DP($xmlObject->debtRepayments->_0->principalAmount)
        );
        $this->assertEquals(
            "4800.00",
            $round2DP($xmlObject->debtRepayments->_0->interestAmount)
        );
        $this->assertEquals(
            $INDIVIDUAL_REPAYMENT,
            $round2DP($xmlObject->debtRepayments->_0->totalAmount)
        );

        $this->assertEquals(
            "5520.51",
            $round2DP($xmlObject->debtRepayments->_1->principalAmount)
        );
        $this->assertEquals(
            "4208.52",
            $round2DP($xmlObject->debtRepayments->_1->interestAmount)
        );
        $this->assertEquals(
            $INDIVIDUAL_REPAYMENT,
            $round2DP($xmlObject->debtRepayments->_1->totalAmount)
        );

        $this->assertEquals(
            "6182.97",
            $round2DP($xmlObject->debtRepayments->_2->principalAmount)
        );
        $this->assertEquals(
            "3546.06",
            $round2DP($xmlObject->debtRepayments->_2->interestAmount)
        );
        $this->assertEquals(
            $INDIVIDUAL_REPAYMENT,
            $round2DP($xmlObject->debtRepayments->_2->totalAmount)
        );

        $this->assertEquals(
            "6924.93",
            $round2DP($xmlObject->debtRepayments->_3->principalAmount)
        );
        $this->assertEquals(
            "2804.10",
            $round2DP($xmlObject->debtRepayments->_3->interestAmount)
        );
        $this->assertEquals(
            $INDIVIDUAL_REPAYMENT,
            $round2DP($xmlObject->debtRepayments->_3->totalAmount)
        );

        $this->assertEquals(
            "7755.92",
            $round2DP($xmlObject->debtRepayments->_4->principalAmount)
        );
        $this->assertEquals(
            "1973.11",
            $round2DP($xmlObject->debtRepayments->_4->interestAmount)
        );
        $this->assertEquals(
            $INDIVIDUAL_REPAYMENT,
            $round2DP($xmlObject->debtRepayments->_4->totalAmount)
        );

        $this->assertEquals(
            "8686.63",
            $round2DP($xmlObject->debtRepayments->_5->principalAmount)
        );
        $this->assertEquals(
            "1042.4",
            $round2DP($xmlObject->debtRepayments->_5->interestAmount)
        );
        $this->assertEquals(
            $INDIVIDUAL_REPAYMENT,
            $round2DP($xmlObject->debtRepayments->_5->totalAmount)
        );
    }
}
