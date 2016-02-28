<?php

namespace FinanCalc\Utils {

    use Exception;
    use FinanCalc\Constants\Defaults;
    use FinanCalc\Constants\ErrorMessages;
    use InvalidArgumentException;

    /**
     * Class Helpers
     * @package FinanCalc\Utils
     */
    class Helpers
    {
        /**
         * @param $checkedVariable
         * @param $nameOfTheExpectedClass
         * @return bool
         * @throws Exception
         */
        public static function checkIfInstanceOfAClassOrThrowAnException($checkedVariable, $nameOfTheExpectedClass)
        {
            if (is_a($checkedVariable, $nameOfTheExpectedClass)) {
                return true;
            }

            throw new InvalidArgumentException(ErrorMessages::getIncompatibleTypesMessage($nameOfTheExpectedClass,
                get_class($checkedVariable)));
        }

        /**
         * @param $leftOperand
         * @param $rightOperand
         * @param string $messageOnException
         * @return bool
         */
        public static function checkIfLeftOperandGreaterOrThrowAnException($leftOperand, $rightOperand, $messageOnException)
        {
            if (MathFuncs::comp($leftOperand, $rightOperand) === 1) {
                return true;
            }

            throw new InvalidArgumentException($messageOnException);
        }

        /**
         * @param $checkedVariable
         * @return bool
         */
        public static function checkIfPositiveNumberOrThrowAnException($checkedVariable)
        {
            if (Helpers::checkIfPositiveNumber($checkedVariable)) {
                return true;
            }

            throw new InvalidArgumentException(ErrorMessages::getMustBePositiveNumberMessage($checkedVariable));
        }

        /**
         * @param $checkedVariable
         * @return bool
         */
        public static function checkIfNotNegativeNumberOrThrowAnException($checkedVariable)
        {
            if (Helpers::checkIfNotNegativeNumber($checkedVariable)) {
                return true;
            }

            throw new InvalidArgumentException(ErrorMessages::getMustNotBeNegativeNumberMessage($checkedVariable));
        }

        /**
         * @param null|\FinanCalc\Constants\AnnuityPaymentTypes $checkedVariable
         * @return bool
         */
        public static function checkIfNotNull($checkedVariable)
        {
            return $checkedVariable !== null;
        }

        /**
         * @param $checkedVariable
         * @return bool|null
         */
        public static function checkIfPositiveNumber($checkedVariable)
        {
            return Helpers::checkNumberRelativityToZero($checkedVariable, 1);
        }

        /**
         * @param $checkedVariable
         * @return bool|null
         */
        public static function checkIfZero($checkedVariable)
        {
            return Helpers::checkNumberRelativityToZero($checkedVariable, 0);
        }

        /**
         * @param $checkedVariable
         * @return bool
         */
        public static function checkIfNotNegativeNumber($checkedVariable)
        {
            return Helpers::checkIfPositiveNumber($checkedVariable) || Helpers::checkIfZero($checkedVariable);
        }

        /**
         * @param $checkedVariable
         * @return bool|null
         */
        public static function checkIfNegativeNumber($checkedVariable)
        {
            return Helpers::checkNumberRelativityToZero($checkedVariable, -1);
        }

        /**
         * @param $checkedVariable
         * @param integer $expectedResult
         * @return bool|null
         */
        public static function checkNumberRelativityToZero($checkedVariable, $expectedResult)
        {
            if (is_numeric((string)$checkedVariable)) {
                return MathFuncs::comp($checkedVariable, "0.00") == $expectedResult;
            }

            return null;
        }

        /**
         * @param string $inputValue
         * @return string
         */
        public static function roundMoneyForDisplay($inputValue)
        {
            return (string)round($inputValue, Defaults::MONEY_DECIMAL_PLACES_DISPLAY);
        }

    }
}
