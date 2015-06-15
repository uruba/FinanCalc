<?php

namespace FinanCalc\Constants {
    /**
     * Class Strings
     * @package FinanCalc\Constants
     */
    class Strings
    {
        /**
         * @param $expectedTypeName [Name of expected class as a string]
         * @param $foundTypeName    [Name of the class that was used instead]
         * @return string           [Concatenated message as a string]
         */
        static function getIncompatibleTypesMessage($expectedTypeName, $foundTypeName) {
            $INCOMPATIBLE_TYPES_MESSAGE = "The value has to be of the type %s, but currently is of the type %s instead.";
            
            return sprintf($INCOMPATIBLE_TYPES_MESSAGE, $expectedTypeName, $foundTypeName);
        }

        /**
         * @param $foundValue [Name of the expected value as a string]
         * @return string     [Concatenated message as a string]
         */
        static function getMustBePositiveNumberMessage($foundValue) {
            $MUST_BE_POSITIVE_NUMBER_MESSAGE = "Expected positive number value, found '%s' instead.";

            return sprintf($MUST_BE_POSITIVE_NUMBER_MESSAGE, $foundValue);
        }


        /**
         * @param $foundValue [Name of the expected value as a string]
         * @return string     [Concatenated message as a string]
         */
        static function getMustNotBeNegativeNumberMessage($foundValue) {
            $MUST_BE_NOT_NEGATIVE_NUMBER_MESSAGE = "Expected positive number value or zero, found '%s' instead.";

            return sprintf($MUST_BE_NOT_NEGATIVE_NUMBER_MESSAGE, $foundValue);
        }
    }
}