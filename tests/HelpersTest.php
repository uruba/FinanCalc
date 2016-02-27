<?php

use FinanCalc\Calculators\AnnuityCalculator;
use FinanCalc\Constants\ErrorMessages;
use FinanCalc\Utils\Helpers;
use FinanCalc\Utils\Time\TimeSpan;

/**
 * Class HelpersTest
 */
class HelpersTest extends PHPUnit_Framework_TestCase
{

    public function testCheckInstancePositive()
    {
        $isInstance = Helpers::checkIfInstanceOfAClassOrThrowAnException(
            new AnnuityCalculator(100000, 5, TimeSpan::asDuration(1), 0.15),
            "FinanCalc\\Calculators\\AnnuityCalculator"
        );

        $this->assertTrue($isInstance);
    }

    public function testCheckInstanceException()
    {
        $this->setExpectedException('InvalidArgumentException',
            ErrorMessages::getIncompatibleTypesMessage("Non\\Existing\\Class",
                "FinanCalc\\Calculators\\AnnuityCalculator"));

        Helpers::checkIfInstanceOfAClassOrThrowAnException(
            new AnnuityCalculator(100000, 5, TimeSpan::asDuration(1), 0.15),
            "Non\\Existing\\Class"
        );
    }

    public function testCheckPositiveNumberPositive()
    {
        $values = array("6.23", 8);

        foreach ($values as $value) {
            $isPositive = Helpers::checkIfPositiveNumber($value);
            $this->assertTrue($isPositive);

            $isPositive = Helpers::checkIfPositiveNumberOrThrowAnException($value);
            $this->assertTrue($isPositive);
        }
    }

    public function testCheckIfPositiveNumberNegative()
    {
        $values = array("-86.5", -43);

        foreach ($values as $value) {
            $isPositive = Helpers::checkIfPositiveNumber($value);

            $this->assertFalse($isPositive);
        }
    }

    public function testCheckIfPositiveNumberException()
    {
        $this->setExpectedException('InvalidArgumentException', ErrorMessages::getMustBePositiveNumberMessage("0"));

        Helpers::checkIfPositiveNumberOrThrowAnException(0);
    }

    public function testCheckIfNotNegativeNumberPositive()
    {
        $values = array("0", 0, "26", 84.3);

        foreach ($values as $value) {
            $isNotNegative = Helpers::checkIfNotNegativeNumberOrThrowAnException($value);

            $this->assertTrue($isNotNegative);
        }
    }

    public function testCheckIfNotNegativeNumberException()
    {
        $this->setExpectedException('InvalidArgumentException', ErrorMessages::getMustNotBeNegativeNumberMessage("-6"));

        Helpers::checkIfNotNegativeNumberOrThrowAnException(-6);
    }

    public function testCheckIfZeroPositive()
    {
        $values = array("0", 0);

        foreach ($values as $value) {
            $isZero = Helpers::checkIfZero($value);

            $this->assertTrue($isZero);
        }
    }

    public function testCheckIfZeroNegative()
    {
        $values = array("-26.3", -45, "55", 13.3);

        foreach ($values as $value) {
            $isZero = Helpers::checkIfZero($value);

            $this->assertFalse($isZero);
        }
    }

    public function testCheckIfNegativeNumberPositive()
    {
        $values = array("-38.66", -5);

        foreach ($values as $value) {
            $isNegative = Helpers::checkIfNegativeNumber($value);

            $this->assertTrue($isNegative);
        }
    }

    public function testCheckIfNegativeNumberNegative()
    {
        $values = array("0", 0, "13", 87.6);

        foreach ($values as $value) {
            $isNegative = Helpers::checkIfNegativeNumber($value);

            $this->assertFalse($isNegative);
        }
    }

    public function testCheckNumberRelativityToZero()
    {
        $negativeValue = -53;

        $this->assertTrue(
            Helpers::checkNumberRelativityToZero($negativeValue, -1)
        );

        $zeroValue = 0;

        $this->assertTrue(
            Helpers::checkNumberRelativityToZero($zeroValue, 0)
        );

        $positiveValue = 53;

        $this->assertTrue(
            Helpers::checkNumberRelativityToZero($positiveValue, 1)
        );

        $nonNumericValue = "This is a non-numeric value.";

        $this->assertNull(
            Helpers::checkNumberRelativityToZero($nonNumericValue, 0)
        );
    }

    public function testRoundMoneyFOrDisplayPositive()
    {
        $unroundedNumber = 666.6666;

        $this->assertEquals(
            Helpers::roundMoneyForDisplay($unroundedNumber),
            "666.67"
        );

        $unroundedNumber = 444.4444;

        $this->assertEquals(
            Helpers::roundMoneyForDisplay($unroundedNumber),
            "444.44"
        );
    }

    public function testRoundMoneyFOrDisplayNegative()
    {
        $unroundedNumber = 666.6666;

        $this->assertNotEquals(
            Helpers::roundMoneyForDisplay($unroundedNumber),
            "666.6666"
        );

        $unroundedNumber = 444.4444;

        $this->assertNotEquals(
            Helpers::roundMoneyForDisplay($unroundedNumber),
            "444.4444"
        );
    }

    public function testIsObjectTypeInArrayFalse()
    {
        $this->assertFalse(
            isObjectTypeInArray('Fake', [])
        );
    }

}
