<?php

use FinanCalc\FinanCalc;
use FinanCalc\Utils\Serializers\XMLSerializer;

/**
 * Class SerializersTest
 */
class SerializersTest extends PHPUnit_Framework_TestCase
{
    public function testXMLSerializer() {
        $debtAmortizatorFactory = FinanCalc
            ::getInstance()
            ->getFactory('DebtAmortizatorFactory')
            ->newYearlyDebtAmortization(
                40000,
                6,
                0.12);

        $xml_output = $debtAmortizatorFactory
            ->getSerializedResult(new XMLSerializer());
        $expected = <<<EOT
<?xml version="1.0" encoding="UTF-8"?>
<root>
  <debtPrincipal>40000</debtPrincipal>
  <debtNoOfCompoundingPeriods>6</debtNoOfCompoundingPeriods>
  <debtPeriodLength>
    <years>1.00000000</years>
    <months>12.00000000</months>
    <days>360</days>
  </debtPeriodLength>
  <debtInterest>0.12</debtInterest>
  <debtDiscountFactor>0.89285714</debtDiscountFactor>
  <debtDuration>
    <years>6.00000000</years>
    <months>72.00000000</months>
    <days>2160.00000000</days>
  </debtDuration>
  <debtSingleRepayment>9729.02853234</debtSingleRepayment>
  <debtRepayments>
    <_0>
      <principalAmount>4929.02853234</principalAmount>
      <interestAmount>4800.00</interestAmount>
      <totalAmount>9729.02853234</totalAmount>
    </_0>
    <_1>
      <principalAmount>5520.51195623</principalAmount>
      <interestAmount>4208.51657611</interestAmount>
      <totalAmount>9729.02853234</totalAmount>
    </_1>
    <_2>
      <principalAmount>6182.97339097</principalAmount>
      <interestAmount>3546.05514137</interestAmount>
      <totalAmount>9729.02853234</totalAmount>
    </_2>
    <_3>
      <principalAmount>6924.93019789</principalAmount>
      <interestAmount>2804.09833445</interestAmount>
      <totalAmount>9729.02853234</totalAmount>
    </_3>
    <_4>
      <principalAmount>7755.92182164</principalAmount>
      <interestAmount>1973.10671070</interestAmount>
      <totalAmount>9729.02853234</totalAmount>
    </_4>
    <_5>
      <principalAmount>8686.63244023</principalAmount>
      <interestAmount>1042.39609211</interestAmount>
      <totalAmount>9729.02853234</totalAmount>
    </_5>
  </debtRepayments>
</root>

EOT;

        $this->assertEquals($expected, $xml_output);
    }
}
