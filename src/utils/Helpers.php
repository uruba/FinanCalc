<?php

namespace FinanCalc\Utils {
    use Exception;
    use FinanCalc\Constants\Defaults;
    use FinanCalc\Constants\Strings;
    use InvalidArgumentException;

    // TODO - resolve this temporary workaround (autoloader sometimes works and sometimes doesn't)
    require_once dirname(__FILE__) . '/../constants/Strings.php';

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
            if (Helpers::checkIfPositiveNumber($checkedVariable) || Helpers::checkIfZero($checkedVariable)) {
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
         * @return bool|null
         */
        static function checkIfNegativeNumber($checkedVariable) {
            return Helpers::checkNumberRelativityToZero($checkedVariable, -1);
        }

        /**
         * @param $checkedVariable
         * @param $expecedResult
         * @return bool|null
         */
        static function checkNumberRelativityToZero($checkedVariable, $expecedResult) {
            if(is_numeric($checkedVariable)) {
                return MathFuncs::comp($checkedVariable, "0.00") == $expecedResult;
            }

            return null;
        }

        /**
         * @param $inputValue
         * @return float
         */
        static function roundMoneyForDisplay($inputValue) {
            return round($inputValue, Defaults::MONEY_DECIMAL_PLACES_DISPLAY);
        }

    }
}