<?php
namespace FinanCalc\Constants {

    use FinanCalc\Utils\Helpers;

    /**
     * Class Lambdas
     * @package FinanCalc\Constants
     */
    class Lambdas {

        /**
         * @return \Closure
         */
        public static function checkIfNotNegative() {
            return function($param) {
                Helpers::checkIfNotNegativeNumberOrThrowAnException($param);
            };
        }

        /**
         * @return \Closure
         */
        public static function checkIfPositive() {
            return function($param) {
                Helpers::checkIfPositiveNumberOrThrowAnException($param);
            };
        }

    }
}

