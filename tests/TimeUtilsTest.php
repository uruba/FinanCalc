<?php

use FinanCalc\Utils\Time\TimeSpan;
use FinanCalc\Utils\Time\TimeUtils;

/**
 * Class TimeUtilsTest
 */
class TimeUtilsTest extends PHPUnit_Framework_TestCase {
    /** @var  TimeSpan */
    private $timeSpan;

    private $YEARS = 1;
    private $MONTHS = 12;
    private $DAYS = 360;

    public function testYearsFromTimeSpan() {
        $this->assertEquals(1.75, $this->timeSpan->toYears());
    }

    public function testMonthsFromTimeSpan() {
        $this->assertEquals(21, $this->timeSpan->toMonths());
    }

    public function testDaysFromTimeSpan() {
        $this->assertEquals(630, $this->timeSpan->toDays());
    }

    public function testGetYearsFromDays() {
        $this->assertEquals(
            $this->YEARS,
            TimeUtils::getYearsFromDays($this->DAYS)
        );
    }

    public function testGetYearsFromMonths() {
        $this->assertEquals(
            $this->YEARS,
            TimeUtils::getYearsFromMonths($this->MONTHS)
        );
    }

    public function testGetYearsFromYears() {
        $this->assertEquals(
            $this->YEARS,
            TimeUtils::getYearsFromYears($this->YEARS)
        );
    }

    public function testGetMonthsFromDays() {
        $this->assertEquals(
            $this->MONTHS,
            TimeUtils::getMonthsFromDays($this->DAYS)
        );
    }

    public function testGetMonthsFromMonths() {
        $this->assertEquals(
            $this->MONTHS,
            TimeUtils::getMonthsFromMonths($this->MONTHS)
        );
    }

    public function testGetMonthsFromYears() {
        $this->assertEquals(
            $this->MONTHS,
            TimeUtils::getMonthsFromYears($this->YEARS)
        );
    }

    public function testGetDaysFromDays() {
        $this->assertEquals(
            $this->DAYS,
            TimeUtils::getDaysFromDays($this->DAYS)
        );
    }

    public function testGetDaysFromMonths() {
        $this->assertEquals(
            $this->DAYS,
            TimeUtils::getDaysFromMonths($this->MONTHS)
        );
    }

    public function testGetDaysFromYears() {
        $this->assertEquals(
            $this->DAYS,
            TimeUtils::getDaysFromYears($this->YEARS)
        );
    }

    protected function setUp() {
        $this->timeSpan = TimeSpan::asDuration(1, 6, 90);

        parent::setUp();
    }
}
