<?php

use FinanCalc\Calculators\DebtAmortizator;
use FinanCalc\FinanCalc;
use FinanCalc\Utils\Serializers\JSONSerializer;
use FinanCalc\Utils\Serializers\XMLSerializer;

/**
 * Class SerializersTest
 */
class SerializersTest extends PHPUnit_Framework_TestCase
{
    /** @var  DebtAmortizator */
    // we will test the serializer on the most complex class with nested elements
    // the example is the same as in the DebtAmortizatorTest
    private $debtAmortizatorFactory;

    public function testXMLSerializer()
    {
        $xml_output = $this
            ->debtAmortizatorFactory
            ->getSerializedResult(new XMLSerializer());

        $xmlObject = new SimpleXMLElement($xml_output);

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
            $this->round2DP($xmlObject->debtDiscountFactor)
        );
        // Debt duration
        $this->assertEquals(
            "6",
            $xmlObject->debtLength->years
        );
        $this->assertEquals(
            "72",
            $xmlObject->debtLength->months
        );
        $this->assertEquals(
            "2160",
            $xmlObject->debtLength->days
        );
        // Debt amount of single repayment
        $INDIVIDUAL_REPAYMENT = "9729.03";
        $this->assertEquals(
            $INDIVIDUAL_REPAYMENT,
            $this->round2DP($xmlObject->debtSingleRepayment)
        );
        // Debt repayments (principal part, interest part, total = principal part + interest part)
        $this->assertEquals(
            "4929.03",
            $this->round2DP($xmlObject->debtRepayments->_1->principalAmount)
        );
        $this->assertEquals(
            "4800.00",
            $this->round2DP($xmlObject->debtRepayments->_1->interestAmount)
        );
        $this->assertEquals(
            $INDIVIDUAL_REPAYMENT,
            $this->round2DP($xmlObject->debtRepayments->_1->totalAmount)
        );

        $this->assertEquals(
            "5520.51",
            $this->round2DP($xmlObject->debtRepayments->_2->principalAmount)
        );
        $this->assertEquals(
            "4208.52",
            $this->round2DP($xmlObject->debtRepayments->_2->interestAmount)
        );
        $this->assertEquals(
            $INDIVIDUAL_REPAYMENT,
            $this->round2DP($xmlObject->debtRepayments->_2->totalAmount)
        );

        $this->assertEquals(
            "6182.97",
            $this->round2DP($xmlObject->debtRepayments->_3->principalAmount)
        );
        $this->assertEquals(
            "3546.06",
            $this->round2DP($xmlObject->debtRepayments->_3->interestAmount)
        );
        $this->assertEquals(
            $INDIVIDUAL_REPAYMENT,
            $this->round2DP($xmlObject->debtRepayments->_3->totalAmount)
        );

        $this->assertEquals(
            "6924.93",
            $this->round2DP($xmlObject->debtRepayments->_4->principalAmount)
        );
        $this->assertEquals(
            "2804.10",
            $this->round2DP($xmlObject->debtRepayments->_4->interestAmount)
        );
        $this->assertEquals(
            $INDIVIDUAL_REPAYMENT,
            $this->round2DP($xmlObject->debtRepayments->_4->totalAmount)
        );

        $this->assertEquals(
            "7755.92",
            $this->round2DP($xmlObject->debtRepayments->_5->principalAmount)
        );
        $this->assertEquals(
            "1973.11",
            $this->round2DP($xmlObject->debtRepayments->_5->interestAmount)
        );
        $this->assertEquals(
            $INDIVIDUAL_REPAYMENT,
            $this->round2DP($xmlObject->debtRepayments->_5->totalAmount)
        );

        $this->assertEquals(
            "8686.63",
            $this->round2DP($xmlObject->debtRepayments->_6->principalAmount)
        );
        $this->assertEquals(
            "1042.4",
            $this->round2DP($xmlObject->debtRepayments->_6->interestAmount)
        );
        $this->assertEquals(
            $INDIVIDUAL_REPAYMENT,
            $this->round2DP($xmlObject->debtRepayments->_6->totalAmount)
        );
    }

    public function testJSONSerializer()
    {
        $json_output = $this
            ->debtAmortizatorFactory
            ->getSerializedResult(new JSONSerializer());

        $jsonObject = json_decode($json_output, true);

        // WE WILL TEST EACH AND EVERY PROPERTY OF THIS OBJECT

        // Debt principal
        $this->assertEquals(
            "40000",
            $jsonObject["debtPrincipal"]
        );
        // Debt number of compounding periods
        $this->assertEquals(
            "6",
            $jsonObject["debtNoOfCompoundingPeriods"]
        );
        // Debt length period
        $this->assertEquals(
            "1",
            $jsonObject["debtPeriodLength"]["years"]
        );
        $this->assertEquals(
            "12",
            $jsonObject["debtPeriodLength"]["months"]
        );
        $this->assertEquals(
            "360",
            $jsonObject["debtPeriodLength"]["days"]
        );
        // Debt interest
        $this->assertEquals(
            "0.12",
            $jsonObject["debtInterest"]
        );
        // Debt discount factor
        $this->assertEquals(
            "0.89",
            $this->round2DP($jsonObject["debtDiscountFactor"])
        );
        // Debt duration
        $this->assertEquals(
            "6",
            $jsonObject["debtLength"]["years"]
        );
        $this->assertEquals(
            "72",
            $jsonObject["debtLength"]["months"]
        );
        $this->assertEquals(
            "2160",
            $jsonObject["debtLength"]["days"]
        );
        // Debt amount of single repayment
        $INDIVIDUAL_REPAYMENT = "9729.03";
        $this->assertEquals(
            $INDIVIDUAL_REPAYMENT,
            $this->round2DP($jsonObject["debtSingleRepayment"])
        );
        // Debt repayments (principal part, interest part, total = principal part + interest part)
        $this->assertEquals(
            "4929.03",
            $this->round2DP($jsonObject["debtRepayments"]["1"]["principalAmount"])
        );
        $this->assertEquals(
            "4800.00",
            $this->round2DP($jsonObject["debtRepayments"]["1"]["interestAmount"])
        );
        $this->assertEquals(
            $INDIVIDUAL_REPAYMENT,
            $this->round2DP($jsonObject["debtRepayments"]["1"]["totalAmount"])
        );

        $this->assertEquals(
            "5520.51",
            $this->round2DP($jsonObject["debtRepayments"]["2"]["principalAmount"])
        );
        $this->assertEquals(
            "4208.52",
            $this->round2DP($jsonObject["debtRepayments"]["2"]["interestAmount"])
        );
        $this->assertEquals(
            $INDIVIDUAL_REPAYMENT,
            $this->round2DP($jsonObject["debtRepayments"]["2"]["totalAmount"])
        );

        $this->assertEquals(
            "6182.97",
            $this->round2DP($jsonObject["debtRepayments"]["3"]["principalAmount"])
        );
        $this->assertEquals(
            "3546.06",
            $this->round2DP($jsonObject["debtRepayments"]["3"]["interestAmount"])
        );
        $this->assertEquals(
            $INDIVIDUAL_REPAYMENT,
            $this->round2DP($jsonObject["debtRepayments"]["3"]["totalAmount"])
        );

        $this->assertEquals(
            "6924.93",
            $this->round2DP($jsonObject["debtRepayments"]["4"]["principalAmount"])
        );
        $this->assertEquals(
            "2804.10",
            $this->round2DP($jsonObject["debtRepayments"]["4"]["interestAmount"])
        );
        $this->assertEquals(
            $INDIVIDUAL_REPAYMENT,
            $this->round2DP($jsonObject["debtRepayments"]["4"]["totalAmount"])
        );

        $this->assertEquals(
            "7755.92",
            $this->round2DP($jsonObject["debtRepayments"]["5"]["principalAmount"])
        );
        $this->assertEquals(
            "1973.11",
            $this->round2DP($jsonObject["debtRepayments"]["5"]["interestAmount"])
        );
        $this->assertEquals(
            $INDIVIDUAL_REPAYMENT,
            $this->round2DP($jsonObject["debtRepayments"]["5"]["totalAmount"])
        );

        $this->assertEquals(
            "8686.63",
            $this->round2DP($jsonObject["debtRepayments"]["6"]["principalAmount"])
        );
        $this->assertEquals(
            "1042.4",
            $this->round2DP($jsonObject["debtRepayments"]["6"]["interestAmount"])
        );
        $this->assertEquals(
            $INDIVIDUAL_REPAYMENT,
            $this->round2DP($jsonObject["debtRepayments"]["6"]["totalAmount"])
        );
    }

    /**
     * @param $roundedObject
     * @return float
     */
    private function round2DP($roundedObject)
    {
        return round((float)$roundedObject, 2);
    }

    protected function setUp()
    {
        $this->debtAmortizatorFactory = FinanCalc
            ::getInstance()
            ->getFactory('DebtAmortizatorFactory')
            ->newYearlyDebtAmortization(
                40000,
                6,
                0.12);

        parent::setUp();
    }
}
