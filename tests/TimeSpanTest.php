<?php
use FinanCalc\Utils\Time\TimeSpan;

/**
 * Class TimeSpanTest
 */
class TimeSpanTest extends PHPUnit_Framework_TestCase
{
    public function testTimeSpanAsDuration() {
        $timeSpan = TimeSpan::asDuration(0, 6);
        $this->assertNull($timeSpan->getStartDate());
        $this->assertNull($timeSpan->getEndDate());
        $this->assertEquals(0, $timeSpan->getYears());
        $this->assertEquals(6, $timeSpan->getMonths());
        $this->assertEquals(0, $timeSpan->getDays());

        $timeSpan->setStartDate(new DateTime("2012-01-01"));

        $this->assertTimeSpan($timeSpan);
    }

    public function testTimeSpanAsDurationWithStartDate() {
        $this->assertTimeSpan(
            TimeSpan::asDurationWithStartDate(
                new DateTime("2012-01-01"),
                0,
                6
            )
        );
    }

    public function testTimeSpanAsInterval() {
        $this->assertTimeSpan(
            TimeSpan::asInterval(
                new DateTime("2012-01-01"),
                new DateTime("2012-07-01")
            )
        );
    }

    /**
     * @param TimeSpan $timeSpan
     */
    private function assertTimeSpan(TimeSpan $timeSpan) {
        $this->assertEquals(new DateTime("2012-01-01"), $timeSpan->getStartDate());
        $this->assertEquals(new DateTime("2012-07-01"), $timeSpan->getEndDate());
        $this->assertEquals(0, $timeSpan->getYears());
        $this->assertEquals(6, $timeSpan->getMonths());
        $this->assertEquals(0, $timeSpan->getDays());

        $timeSpan->setEndDate(new DateTime("2012-06-01"));
        $this->assertEquals(new DateTime("2012-01-01"), $timeSpan->getStartDate());
        $this->assertEquals(new DateTime("2012-06-01"), $timeSpan->getEndDate());
        $this->assertEquals(0, $timeSpan->getYears());
        $this->assertEquals(4, $timeSpan->getMonths());
        $this->assertEquals(31, $timeSpan->getDays());

        $timeSpan->setEndDate(new DateTime("2013-01-01"));
        $this->assertEquals(new DateTime("2012-01-01"), $timeSpan->getStartDate());
        $this->assertEquals(new DateTime("2013-01-01"), $timeSpan->getEndDate());
        $this->assertEquals(1, $timeSpan->getYears());
        $this->assertEquals(0, $timeSpan->getMonths());
        $this->assertEquals(0, $timeSpan->getDays());

        $timeSpan->clearStartEndDate();
        $this->assertNull($timeSpan->getStartDate());
        $this->assertNull($timeSpan->getEndDate());
        $this->assertEquals(1, $timeSpan->getYears());
        $this->assertEquals(0, $timeSpan->getMonths());
        $this->assertEquals(0, $timeSpan->getDays());

        $timeSpan->setEndDate(new DateTime("2013-01-01"));
        $this->assertEquals(new DateTime("2012-01-01"), $timeSpan->getStartDate());
        $this->assertEquals(new DateTime("2013-01-01"), $timeSpan->getEndDate());
        $this->assertEquals(1, $timeSpan->getYears());
        $this->assertEquals(0, $timeSpan->getMonths());
        $this->assertEquals(0, $timeSpan->getDays());

        $timeSpan->setStartDate(new DateTime("2011-01-01"));
        $this->assertEquals(new DateTime("2011-01-01"), $timeSpan->getStartDate());
        $this->assertEquals(new DateTime("2013-01-01"), $timeSpan->getEndDate());
        $this->assertEquals(2, $timeSpan->getYears());
        $this->assertEquals(0, $timeSpan->getMonths());
        $this->assertEquals(0, $timeSpan->getDays());
    }

    protected function setUp() {
        date_default_timezone_set("Europe/London");

        parent::setUp();
    }
}
