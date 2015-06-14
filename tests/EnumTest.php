<?php

use FinanCalc\Constants\AnnuityPaymentTypes;
use FinanCalc\Constants\AnnuityValueTypes;

class EnumTest extends PHPUnit_Framework_TestCase {

    public function testAnnuityValueTypes() {
        $annuityValueType = new AnnuityValueTypes(AnnuityValueTypes::PRESENT_VALUE);
        $this->assertEquals(
            AnnuityValueTypes::PRESENT_VALUE,
            $annuityValueType->getValue());

        $annuityValueType->setValue(AnnuityValueTypes::FUTURE_VALUE);
        $this->assertEquals(
            AnnuityValueTypes::FUTURE_VALUE,
            $annuityValueType->getValue());
    }

    public function testAnnuityValueTypesException() {
        $this->setExpectedException('Exception');

        $annuityValueType = new AnnuityValueTypes(3);
    }


    public function testAnnuityPaymentTypes() {
        $annuityPaymentType = new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ADVANCE);
        $this->assertEquals(
            AnnuityPaymentTypes::IN_ADVANCE,
            $annuityPaymentType->getValue());

        $annuityPaymentType->setValue(AnnuityPaymentTypes::IN_ARREARS);
        $this->assertEquals(
            AnnuityPaymentTypes::IN_ARREARS,
            $annuityPaymentType->getValue());
    }

    public function testAnnuityPaymentTypesException() {
        $this->setExpectedException('Exception');

        $annuityPaymentType = new AnnuityPaymentTypes(3);
    }

}
