<?php

use FinanCalc\Constants\AnnuityPaymentTypes;
use FinanCalc\Constants\AnnuityValueTypes;

/**
 * Class EnumTest
 */
class EnumTest extends PHPUnit_Framework_TestCase {

    public function testAnnuityValueTypes() {
        // test PV
        $annuityValueType = new AnnuityValueTypes(AnnuityValueTypes::PRESENT_VALUE);
        $this->assertEquals(
            AnnuityValueTypes::PRESENT_VALUE,
            $annuityValueType->getValue());

        // test FV
        $annuityValueType->setValue(AnnuityValueTypes::FUTURE_VALUE);
        $this->assertEquals(
            AnnuityValueTypes::FUTURE_VALUE,
            $annuityValueType->getValue());
    }

    public function testMagicProperty() {
        $annuityValueType = new AnnuityValueTypes(AnnuityValueTypes::FUTURE_VALUE);
        // the enum's value should now be able to be channged by so much as assigning a magic property
        // lets change it from the future value to present value and see if it comes through
        $annuityValueType->magicProperty = AnnuityValueTypes::PRESENT_VALUE;
        $this->assertEquals(
            AnnuityValueTypes::PRESENT_VALUE,
            $annuityValueType->getValue()
        );
    }

    public function testToString() {
        $annuityValueType = new AnnuityValueTypes(AnnuityValueTypes::PRESENT_VALUE);

        $this->expectOutputString('1');
        echo($annuityValueType);
    }

    public function testAnnuityValueTypesException() {
        $this->setExpectedException('Exception');

        // this should throw an exception
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

        // this should throw an exception
        $annuityPaymentType = new AnnuityPaymentTypes(3);
    }

}
