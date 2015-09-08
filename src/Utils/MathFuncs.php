<?php

namespace FinanCalc\Utils {
    use FinanCalc\Constants\Defaults;

    /**
     * Class MathFuncs
     * @package FinanCalc\Utils
     */
    class MathFuncs {
        /**
         * @param $leftOperand
         * @param $rightOperand
         * @return string
         */
        public static function add($leftOperand, $rightOperand) {
            return bcadd($leftOperand, $rightOperand, Defaults::MONEY_DECIMAL_PLACES_PRECISION);
        }

        /**
         * @param $leftOperand
         * @param $rightOperand
         * @return string
         */
        public static function sub($leftOperand, $rightOperand) {
            return bcsub($leftOperand, $rightOperand, Defaults::MONEY_DECIMAL_PLACES_PRECISION);
        }

        /**
         * @param $leftOperand
         * @param $rightOperand
         * @return string
         */
        public static function mul($leftOperand, $rightOperand) {
            return bcmul($leftOperand, $rightOperand, Defaults::MONEY_DECIMAL_PLACES_PRECISION);
        }

        /**
         * @param $leftOperand
         * @param $rightOperand
         * @return string
         */
        public static function div($leftOperand, $rightOperand) {
            return bcdiv($leftOperand, $rightOperand, Defaults::MONEY_DECIMAL_PLACES_PRECISION);
        }

        /**
         * @param $leftOperand
         * @param $rightOperand
         * @return string
         */
        public static function pow($leftOperand, $rightOperand) {
            return bcpow($leftOperand, $rightOperand, Defaults::MONEY_DECIMAL_PLACES_PRECISION);
        }

        /**
         * @param $leftOperand
         * @param $rightOperand
         * @return int
         */
        public static function comp($leftOperand, $rightOperand) {
            return bccomp($leftOperand, $rightOperand, Defaults::MONEY_DECIMAL_PLACES_PRECISION);
        }

        /**
         * @param $roundedNumber
         * @param $precision
         * @return string
         */
        public static function round($roundedNumber, $precision = 2) {
            return (string)round((float)$roundedNumber, $precision);
        }
    }
}
