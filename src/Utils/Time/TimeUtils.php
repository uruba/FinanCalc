<?php


namespace FinanCalc\Utils\Time {

    use Exception;
    use FinanCalc\Constants\ErrorMessages;
    use FinanCalc\Utils\Config;
    use FinanCalc\Utils\MathFuncs;

    /**
     * Class TimeUtils
     * @package FinanCalc\Utils
     */
    class TimeUtils {

        /**
         * @param $numberOfDays
         * @return string
         * @throws Exception
         */
        public static function getYearsFromDays($numberOfDays) {
            return MathFuncs::div(
                $numberOfDays,
                self::getCurrentDayCountConvention()['days_in_a_year']
            );
        }

        /**
         * @param $numberOfMonths
         * @return string
         */
        public static function getYearsFromMonths($numberOfMonths) {
            return MathFuncs::div(
                $numberOfMonths,
                12
            );
        }

        /**
         * @param $numberOfYears
         * @return string
         */
        public static function getYearsFromYears($numberOfYears) {
            return MathFuncs::div(
                $numberOfYears,
                1
            );
        }

        /**
         * @param $numberOfDays
         * @return string
         * @throws Exception
         */
        public static function getMonthsFromDays($numberOfDays) {
            return MathFuncs::div(
                $numberOfDays,
                self::getCurrentDayCountConvention()['days_in_a_month']
            );
        }

        /**
         * @param $numberOfMonths
         * @return string
         */
        public static function getMonthsFromMonths($numberOfMonths) {
            return MathFuncs::div(
                $numberOfMonths,
                1
            );
        }

        /**
         * @param $numberOfYears
         * @return string
         */
        public static function getMonthsFromYears($numberOfYears) {
            return MathFuncs::mul(
                $numberOfYears,
                12
            );
        }

        /**
         * @param $numberOfDays
         * @return string
         */
        public static function getDaysFromDays($numberOfDays) {
            return MathFuncs::div(
                $numberOfDays,
                1
            );
        }

        /**
         * @param $numberOfMonths
         * @return string
         * @throws Exception
         */
        public static function getDaysFromMonths($numberOfMonths) {
            return MathFuncs::mul(
                $numberOfMonths,
                self::getCurrentDayCountConvention()['days_in_a_month']
            );
        }

        /**
         * @param $numberOfYears
         * @return string
         * @throws Exception
         */
        public static function getDaysFromYears($numberOfYears) {
            return MathFuncs::mul(
                $numberOfYears,
                self::getCurrentDayCountConvention()['days_in_a_year']
            );
        }

        /**
         * @return mixed
         * @throws Exception
         */
        public static function getCurrentDayCountConvention() {
            $dayCountConventionIdentifier = Config::getConfigField('day_count_convention');
            $availableDayCountConventions = Config::getConfigField('available_day_count_conventions');
            $dayCountConvention = $availableDayCountConventions[$dayCountConventionIdentifier];

            if (self::isDayCountConventionValid($dayCountConvention)) {
                $dayCountConvention['days_in_a_month'] = MathFuncs::div($dayCountConvention['days_in_a_year'], 12);
                return $dayCountConvention;
            }

            throw new Exception(ErrorMessages::getDayCountConventionNotDefined());
        }

        /**
         * @param $dayCountConvention
         * @return bool
         */
        public static function isDayCountConventionValid($dayCountConvention) {
            if (is_array($dayCountConvention)) {
                $dayCountConventionField = $dayCountConvention['days_in_a_year'];
                if (!is_string($dayCountConventionField) || !ctype_digit($dayCountConventionField)) {
                    return false;
                }

                return true;
            }

            return false;
        }
    }
}