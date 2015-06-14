<?php

use FinanCalc\Calculators\AnnuityCalculator;
use FinanCalc\Utils\Helpers;

class HelpersTest extends PHPUnit_Framework_TestCase {

    public function testCheckInstancePositive() {
        $isInstance = Helpers::checkIfInstanceOfAClassOrThrowAnException(
            new AnnuityCalculator(100000, 5, 0.15, 360),
            "FinanCalc\\Calculators\\AnnuityCalculator"
        );

        $this->assertTrue($isInstance);
    }

    public function testCheckInstanceException() {
        $this->setExpectedException('InvalidArgumentException');

        Helpers::checkIfInstanceOfAClassOrThrowAnException(
            new AnnuityCalculator(100000, 5, 0.15, 360),
            "Non\\Existing\\Class"
        );
    }

    public function testCheckPositiveNumberPositive() {
        $values = array("6.23", 8);

        foreach($values as $value) {
            $isPositive = Helpers::checkIfPositiveNumber($value);
            $this->assertTrue($isPositive);

            $isPositive = Helpers::checkIfPositiveNumberOrThrowAnException($value);
            $this->assertTrue($isPositive);
        }
    }

    public function testCheckIfPositiveNumberNegative() {
        $values = array("-86.5", -43);

        foreach($values as $value) {
            $isPositive = Helpers::checkIfPositiveNumber($value);

            $this->assertFalse($isPositive);
        }
    }

    public function testCheckIfPositiveNumberException() {
        $this->setExpectedException('InvalidArgumentException');

        Helpers::checkIfPositiveNumberOrThrowAnException(0);
    }

    public function testCheckIfNotNegativeNumberPositive() {
        $values = array("0", 0, "26", 84.3);

        foreach($values as $value) {
            $isNotNegative = Helpers::checkIfNotNegativeNumberOrThrowAnException($value);

            $this->assertTrue($isNotNegative);
        }
    }

    public function testCheckIfNotNegativeNumberException() {
        $this->setExpectedException('InvalidArgumentException');

        Helpers::checkIfNotNegativeNumberOrThrowAnException(-6);
    }

    public function testCheckIfZeroPositive() {
        $values = array("0", 0);

        foreach($values as $value) {
            $isZero = Helpers::checkIfZero($value);

            $this->assertTrue($isZero);
        }
    }

    public function testCheckIfZeroNegative() {
        $values = array("-26.3", -45, "55", 13.3);

        foreach($values as $value) {
            $isZero = Helpers::checkIfZero($value);

            $this->assertFalse($isZero);
        }
    }

    public function testCheckIfNegativeNumberPositive() {
        $values = array("-38.66", -5);

        foreach($values as $value) {
            $isNegative = Helpers::checkIfNegativeNumber($value);

            $this->assertTrue($isNegative);
        }
    }

    public function testCheckIfNegativeNumberNegative() {
        $values = array("0", 0, "13", 87.6);

        foreach($values as $value) {
            $isNegative = Helpers::checkIfNegativeNumber($value);

            $this->assertFalse($isNegative);
        }
    }

    public function testCheckNumberRelativityToZero() {
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
    }

    public function testRoundMoneyFOrDisplayPositive() {
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

    public function testRoundMoneyFOrDisplayNegative() {
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

    protected function setUp() {
        require_once dirname(__FILE__) . '/../src/FinanCalc.php';

        parent::setUp();
    }
}
