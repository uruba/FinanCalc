<?php

namespace FinanCalc\Utils {
    use FinanCalc\Constants\Defaults;

    class MathFuncs {
        public static function add($leftOperand, $rightOperand) {
            return bcadd($leftOperand, $rightOperand, Defaults::MONEY_DECIMAL_PLACES_PRECISION);
        }

        public static function sub($leftOperand, $rightOperand) {
            return bcsub($leftOperand, $rightOperand, Defaults::MONEY_DECIMAL_PLACES_PRECISION);
        }

        public static function mul($leftOperand, $rightOperand) {
            return bcmul($leftOperand, $rightOperand, Defaults::MONEY_DECIMAL_PLACES_PRECISION);
        }

        public static function div($leftOperand, $rightOperand) {
            return bcdiv($leftOperand, $rightOperand, Defaults::MONEY_DECIMAL_PLACES_PRECISION);
        }

        public static function pow($leftOperand, $rightOperand) {
            return bcpow($leftOperand, $rightOperand, Defaults::MONEY_DECIMAL_PLACES_PRECISION);
        }

        public static function comp($leftOperand, $rightOperand) {
            return bccomp($leftOperand, $rightOperand, Defaults::MONEY_DECIMAL_PLACES_PRECISION);
        }
    }
}
