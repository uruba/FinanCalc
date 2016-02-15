<?php

namespace FinanCalc\Constants {

    use FinanCalc\Utils\Strings;

    /**
     * Class ErrorMessages
     * @package FinanCalc\Constants
     */
    class ErrorMessages
    {
        /**
         * @param $expectedTypeName [Name of expected class as a string]
         * @param $foundTypeName    [Name of the class that was used instead]
         * @return string           [Concatenated message as a string]
         */
        static function getIncompatibleTypesMessage($expectedTypeName, $foundTypeName) {
            return sprintf(
                Strings::getString('message_incompatible_types'),
                $expectedTypeName,
                $foundTypeName
            );
        }

        /**
         * @param $foundValue [Name of the expected value as a string]
         * @return string     [Concatenated message as a string]
         */
        static function getMustBePositiveNumberMessage($foundValue) {
            return sprintf(
                Strings::getString('message_must_be_positive_number'),
                $foundValue
            );
        }


        /**
         * @param $foundValue [Name of the expected value as a string]
         * @return string     [Concatenated message as a string]
         */
        static function getMustNotBeNegativeNumberMessage($foundValue) {
            return sprintf(
                Strings::getString('message_must_not_be_negative'),
                $foundValue
            );
        }

        /**
         * @param $configField [Name of the expected value as a string]
         * @return string      [Concatenated message as a string]
         */
        static function getConfigFieldNotFoundMessage($configField) {
            return sprintf(
                Strings::getString('message_config_field_not_found'),
                $configField
            );
        }


        /**
         * @param $propertyName [Name of the property as a string]
         * @param $className    [Name of the class as a string]
         * @return string       [Concatenated message as a string]
         */
        static function getNonExistentPropertyMessage($propertyName, $className) {
            return sprintf(Strings::getString('message_nonexistent_property'), $propertyName, $className);
        }
    }
}