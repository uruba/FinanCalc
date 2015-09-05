<?php


namespace FinanCalc\Utils\Time {

    use DateInterval;
    use DateTime;
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
            $months,
            $days = 0
        ) {
            $newThis = new TimeSpan();
            $newThis->setDateInterval($years, $months, $days);

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
            $months,
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
            if ($startDate === null) {
                throw new InvalidArgumentException('$startDate cannot be assigned null, use the clearStartEndDate() method instead!');
            }

            $endDate = $this->endDate;
            if ($endDate !== null) {
                $this->checkStartEndDateAndSetInterval($startDate, $endDate);
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
            if ($endDate === null) {
                throw new InvalidArgumentException('$endDate cannot be assigned null, use the clearStartEndDate() method instead!');
            }

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
         * @return int
         */
        public function getYears() {
            return $this->dateInterval->y;
        }

        /**
         * @return int
         */
        public function getMonths() {
            return $this->dateInterval->m;
        }

        /**
         * @return int
         */
        public function getDays() {
            return $this->dateInterval->d;
        }

        public function clearStartEndDate() {
            $this->startDate = $this->endDate = null;
        }

        /** PRIVATE methods */

        /**
         * @param $years
         * @param $months
         * @param $days
         */
        private function setDateInterval($years, $months, $days) {
            $this->dateInterval = new DateInterval(
                                        "P" .
                                        (string)$years . "Y" .
                                        (string)$months . "M" .
                                        (string)$days . "D"
                                    );
        }

        /**
         * @param DateTime $startDate
         * @param DateTime $endDate
         */
        function setDateIntervalSE(DateTime $startDate, DateTime $endDate) {
            $this->dateInterval = $startDate->diff($endDate, true);
        }

        /**
         * @param DateTime $startDate
         * @param DateTime $endDate
         */
        private function checkStartEndDateAndSetInterval(DateTime $startDate, DateTime $endDate) {
            if ($startDate < $endDate) {
                $this->setDateIntervalSE($startDate, $endDate);
            } else {
                throw new InvalidArgumentException("Start date has to be lower than the end date! " . var_dump($endDate));
            }
        }
    }
}