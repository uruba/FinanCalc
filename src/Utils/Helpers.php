<?php

namespace FinanCalc\Utils {
    use Exception;
    use FinanCalc\Constants\Defaults;
    use FinanCalc\Constants\Strings;
    use InvalidArgumentException;

    /**
     * Class Helpers
     * @package FinanCalc\Utils
     */
    class Helpers {
        /**
         * @param $checkedVariable
         * @param $nameOfTheExpectedClass
         * @return bool
         * @throws Exception
         */
        static function checkIfInstanceOfAClassOrThrowAnException($checkedVariable, $nameOfTheExpectedClass) {
            if (is_a($checkedVariable, $nameOfTheExpectedClass)) {
                return true;
            }

            throw new InvalidArgumentException(Strings::getIncompatibleTypesMessage($nameOfTheExpectedClass, get_class($checkedVariable)));
        }

        /**
         * @param $leftOperand
         * @param $rightOperand
         * @param $messageOnException
         * @return bool
         */
        static function checkIfLeftOperandGreaterOrThrowAnEception($leftOperand, $rightOperand, $messageOnException) {
            if (MathFuncs::comp($leftOperand, $rightOperand) === 1) {
                return true;
            }

            throw new InvalidArgumentException($messageOnException);
        }

        /**
         * @param $checkedVariable
         * @return bool
         */
        static function checkIfPositiveNumberOrThrowAnException($checkedVariable) {
            if (Helpers::checkIfPositiveNumber($checkedVariable)) {
                return true;
            }

            throw new InvalidArgumentException(Strings::getMustBePositiveNumberMessage($checkedVariable));
        }

        /**
         * @param $checkedVariable
         * @return bool
         */
        static function checkIfNotNegativeNumberOrThrowAnException($checkedVariable) {
            if (Helpers::checkIfNotNegativeNumber($checkedVariable)) {
                return true;
            }

            throw new InvalidArgumentException(Strings::getMustNotBeNegativeNumberMessage($checkedVariable));
        }

        /**
         * @param $checkedVariable
         * @return bool|null
         */
        static function checkIfPositiveNumber($checkedVariable) {
            return Helpers::checkNumberRelativityToZero($checkedVariable, 1);
        }

        /**
         * @param $checkedVariable
         * @return bool|null
         */
        static function checkIfZero($checkedVariable) {
            return Helpers::checkNumberRelativityToZero($checkedVariable, 0);
        }

        /**
         * @param $checkedVariable
         * @return bool
         */
        static function checkIfNotNegativeNumber($checkedVariable) {
            return Helpers::checkIfPositiveNumber($checkedVariable) || Helpers::checkIfZero($checkedVariable);
        }

        /**
         * @param $checkedVariable
         * @return bool|null
         */
        static function checkIfNegativeNumber($checkedVariable) {
            return Helpers::checkNumberRelativityToZero($checkedVariable, -1);
        }

        /**
         * @param $checkedVariable
         * @param $expectedResult
         * @return bool|null
         */
        static function checkNumberRelativityToZero($checkedVariable, $expectedResult) {
            if(is_numeric((string)$checkedVariable)) {
                return MathFuncs::comp($checkedVariable, "0.00") == $expectedResult;
            }

            return null;
        }


        /**
         * @param $inputValue
         * @return string
         */
        static function roundMoneyForDisplay($inputValue) {
            return (string)round($inputValue, Defaults::MONEY_DECIMAL_PLACES_DISPLAY);
        }

    }
}