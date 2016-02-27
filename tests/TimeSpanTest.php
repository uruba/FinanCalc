<?php
use FinanCalc\Utils\Time\TimeSpan;

/**
 * Class TimeSpanTest
 */
class TimeSpanTest extends PHPUnit_Framework_TestCase
{
    public function testExceptionStartDateNotLowerThanEndDate()
    {
        $this->setExpectedException("InvalidArgumentException");

        $testDate = new DateTime();
        TimeSpan::asInterval($testDate, $testDate);
    }

    public function testTimeSpanAsDuration()
    {
        $timeSpan = TimeSpan::asDuration(0, 6);
        $this->assertNull($timeSpan->getStartDate());
        $this->assertNull($timeSpan->getEndDate());
        $this->assertEquals(0, $timeSpan->getYearsComponent());
        $this->assertEquals(6, $timeSpan->getMonthsComponent());
        $this->assertEquals(0, $timeSpan->getDaysComponent());

        $timeSpan->setStartDate(new DateTime("2012-01-01"));

        $this->assertTimeSpan($timeSpan);
    }

    /**
     * @param TimeSpan $timeSpan
     */
    private function assertTimeSpan(TimeSpan $timeSpan)
    {
        $this->assertEquals(new DateTime("2012-01-01"), $timeSpan->getStartDate());
        $this->assertEquals(new DateTime("2012-07-01"), $timeSpan->getEndDate());
        $this->assertEquals(0, $timeSpan->getYearsComponent());
        $this->assertEquals(6, $timeSpan->getMonthsComponent());
        $this->assertEquals(0, $timeSpan->getDaysComponent());

        $timeSpan->setEndDate(new DateTime("2012-06-01"));
        $this->assertEquals(new DateTime("2012-01-01"), $timeSpan->getStartDate());
        $this->assertEquals(new DateTime("2012-06-01"), $timeSpan->getEndDate());
        $this->assertEquals(0, $timeSpan->getYearsComponent());
        $this->assertEquals(5, $timeSpan->getMonthsComponent());
        $this->assertEquals(0, $timeSpan->getDaysComponent());

        $timeSpan->setEndDate(new DateTime("2013-01-01"));
        $this->assertEquals(new DateTime("2012-01-01"), $timeSpan->getStartDate());
        $this->assertEquals(new DateTime("2013-01-01"), $timeSpan->getEndDate());
        $this->assertEquals(1, $timeSpan->getYearsComponent());
        $this->assertEquals(0, $timeSpan->getMonthsComponent());
        $this->assertEquals(0, $timeSpan->getDaysComponent());

        $timeSpan->clearStartEndDate();
        $this->assertNull($timeSpan->getStartDate());
        $this->assertNull($timeSpan->getEndDate());
        $this->assertEquals(1, $timeSpan->getYearsComponent());
        $this->assertEquals(0, $timeSpan->getMonthsComponent());
        $this->assertEquals(0, $timeSpan->getDaysComponent());

        $timeSpan->setEndDate(new DateTime("2013-01-01"));
        $this->assertEquals(new DateTime("2012-01-01"), $timeSpan->getStartDate());
        $this->assertEquals(new DateTime("2013-01-01"), $timeSpan->getEndDate());
        $this->assertEquals(1, $timeSpan->getYearsComponent());
        $this->assertEquals(0, $timeSpan->getMonthsComponent());
        $this->assertEquals(0, $timeSpan->getDaysComponent());

        $timeSpan->setStartDate(new DateTime("2012-01-01"));
        $this->assertEquals(new DateTime("2012-01-01"), $timeSpan->getStartDate());
        $this->assertEquals(new DateTime("2013-01-01"), $timeSpan->getEndDate());
        $this->assertEquals(1, $timeSpan->getYearsComponent());
        $this->assertEquals(0, $timeSpan->getMonthsComponent());
        $this->assertEquals(0, $timeSpan->getDaysComponent());

        $timeSpan->setStartDate(new DateTime("2012-01-02"));
        $this->assertEquals(new DateTime("2012-01-02"), $timeSpan->getStartDate());
        $this->assertEquals(new DateTime("2013-01-01"), $timeSpan->getEndDate());
        $this->assertEquals(1, $timeSpan->getYearsComponent());
        $this->assertEquals(0, $timeSpan->getMonthsComponent());
        $this->assertEquals(0, $timeSpan->getDaysComponent());
    }

    public function testTimeSpanAsDurationWithStartDate()
    {
        $this->assertTimeSpan(
            TimeSpan::asDurationWithStartDate(
                new DateTime("2012-01-01"),
                0,
                6
            )
        );
    }

    public function testTimeSpanAsInterval()
    {
        $this->assertTimeSpan(
            TimeSpan::asInterval(
                new DateTime("2012-01-01"),
                new DateTime("2012-07-01")
            )
        );
    }

    protected function setUp()
    {
        date_default_timezone_set("Europe/London");

        parent::setUp();
    }
}
