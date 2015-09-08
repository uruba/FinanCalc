<?php


namespace FinanCalc\Utils\Time {

    use DateInterval;
    use DateTime;
    use Exception;
    use FinanCalc\Utils\Helpers;
    use FinanCalc\Utils\MathFuncs;
    use InvalidArgumentException;

    /**
     * Class TimeSpan
     * @package FinanCalc\Utils\Time
     */
    class TimeSpan {
        /** @var  DateTime */
        private $startDate, $endDate;
        /** @var  DateInterval */
        private $dateInterval;

        /**
         * PRIVATE constructor
         */
        private function __construct() {

        }

        /**
         * @param integer $years
         * @param integer $months
         * @param integer $days
         * @return TimeSpan
         */
        public static function asDuration(
            $years,
            $months = 0,
            $days = 0
        ) {
            foreach (func_get_args() as $arg) {
                Helpers::checkIfNotNegativeNumberOrThrowAnException($arg);
            }

            $newThis = new TimeSpan();
            $newThis->newDateIntervalAbsolute($years, $months, $days);

            return $newThis;
        }

        /**
         * @param DateTime $startDate
         * @param $years
         * @param $months
         * @param int $days
         * @return TimeSpan
         */
        public static function asDurationWithStartDate(
            DateTime $startDate,
            $years,
            $months = 0,
            $days = 0
        ) {
            $newThis = TimeSpan::asDuration($years, $months, $days);
            $newThis->setStartDate($startDate);

            return $newThis;
        }

        /**
         * @param DateTime $startDate
         * @param DateTime $endDate
         * @return TimeSpan
         */
        public static function asInterval(
            DateTime $startDate,
            DateTime $endDate
        ) {
            $newThis = new TimeSpan();
            $newThis->checkStartEndDateAndSetInterval($startDate, $endDate);
            $newThis->setStartDate($startDate);
            $newThis->setEndDate($endDate);

            return $newThis;
        }

        /**
         * @param DateTime $startDate
         */
        public function setStartDate(DateTime $startDate) {
            if ($this->endDate !== null) {
                $this->checkStartEndDateAndSetInterval($startDate, $this->endDate);
            } else {
                $endDate = clone $startDate;
                $this->endDate = $endDate->add($this->dateInterval);
            }

            $this->startDate = $startDate;
        }

        /**
         * @param DateTime $endDate
         */
        public function setEndDate(DateTime $endDate) {
            if ($this->startDate !== null) {
                $this->checkStartEndDateAndSetInterval($this->startDate, $endDate);
            } else {
                $dateInterval = $this->dateInterval;
                $dateInterval->invert = 1;
                $startDate = clone $endDate;
                $this->startDate = $startDate->add($dateInterval);
                $dateInterval->invert = 0;
            }

            $this->endDate = $endDate;
        }

        /**
         * @return DateTime
         */
        public function getStartDate() {
            return $this->startDate;
        }

        /**
         * @return DateTime
         */
        public function getEndDate() {
            return $this->endDate;
        }

        /**
         * @return string
         */
        public function getYearsComponent() {
            return (string)$this->dateInterval->y;
        }

        /**
         * @return string
         */
        public function getMonthsComponent() {
            return (string)$this->dateInterval->m;
        }

        /**
         * @return string
         */
        public function getDaysComponent() {
            return (string)$this->dateInterval->d;
        }

        /**
         * @return string
         * @throws Exception
         */
        public function toYears() {
            $monthsComponent = MathFuncs::div(
                $this->getMonthsComponent(),
                12
            );
            $daysComponent = TimeUtils::getCurrentDayCountConvention()['days_in_a_year'] == 0 ?
                0 :
                MathFuncs::div(
                    $this->getDaysComponent(),
                    TimeUtils::getCurrentDayCountConvention()['days_in_a_year']
                );

            return MathFuncs::add($this->getYearsComponent(), MathFuncs::add($monthsComponent, $daysComponent));
        }

        /**
         * @return string
         * @throws Exception
         */
        public function toMonths() {
            $yearsComponent = MathFuncs::mul($this->getYearsComponent(), 12);
            $daysComponent = TimeUtils::getCurrentDayCountConvention()['days_in_a_month'] == 0 ?
                0 :
                MathFuncs::div(
                    $this->getDaysComponent(),
                    TimeUtils::getCurrentDayCountConvention()['days_in_a_month']
                );

            return MathFuncs::add($this->getMonthsComponent(), MathFuncs::add($yearsComponent, $daysComponent));
        }

        /**
         * @return string
         * @throws Exception
         */
        public function toDays() {
            $yearsComponent = MathFuncs::mul(
                $this->getYearsComponent(),
                TimeUtils::getCurrentDayCountConvention()['days_in_a_year']
            );
            $monthsComponent = MathFuncs::mul(
                $this->getMonthsComponent(),
                TimeUtils::getCurrentDayCountConvention()['days_in_a_month']
            );

            return MathFuncs::add($this->getDaysComponent(), MathFuncs::add($yearsComponent, $monthsComponent));
        }

        public function clearStartEndDate() {
            $this->startDate = $this->endDate = null;
        }

        /** PRIVATE methods */

        /**
         * @param DateInterval $dateInterval
         */
        private function setDateInterval(DateInterval $dateInterval) {
            $this->dateInterval = $dateInterval;
        }

        /**
         * @param $years
         * @param $months
         * @param $days
         */
        private function newDateIntervalAbsolute($years, $months, $days) {
            $this->setdateInterval(
                new DateInterval(
                    "P" .
                    (string)$years . "Y" .
                    (string)$months . "M" .
                    (string)$days . "D"
                )
            );
        }

        /**
         * @param DateTime $startDate
         * @param DateTime $endDate
         */
        private function newDateIntervalDifference(DateTime $startDate, DateTime $endDate) {
            $this->setDateInterval(
                $this->roundDateInterval(
                    $startDate->diff($endDate)
                )
            );
        }

        /**
         * @param DateTime $startDate
         * @param DateTime $endDate
         */
        private function checkStartEndDateAndSetInterval(DateTime $startDate, DateTime $endDate) {
            if ($startDate < $endDate) {
                $this->newDateIntervalDifference($startDate, $endDate);
            } else {
                throw new InvalidArgumentException("Start date has to be lower than the end date!");
            }
        }

        /**
         * @param DateInterval $dateInterval
         * @return DateInterval
         */
        private function roundDateInterval(DateInterval $dateInterval) {
            // TODO: make more intelligent rounding based on the start and end date
            if (in_array($dateInterval->d, [30, 31])) {
                $dateInterval->d = 0;
                $dateInterval->m += 1;
            }

            if ($dateInterval->m == 12) {
                $dateInterval->y += 1;
                $dateInterval->m = 0;
            }

            return $dateInterval;
        }

        /**
         * @return string
         */
        public function __toString() {
            return $this->toDays();
        }
    }
}