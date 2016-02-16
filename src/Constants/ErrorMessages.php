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
         * @param $expectedTypeName [Name of the expected class as a string]
         * @param $foundTypeName    [Name of the class that was used instead]
         * @return string           [Concatenated message as a string]
         */
        static function getIncompatibleTypesMessage($expectedTypeName, $foundTypeName) {
            return Strings::getFormattedString(
                'message_incompatible_types',
                null,
                $expectedTypeName,
                $foundTypeName
            );
        }

        /**
         * @param $foundValue [Name of the expected value as a string]
         * @return string     [Concatenated message as a string]
         */
        static function getMustBePositiveNumberMessage($foundValue) {
            return Strings::getFormattedString(
                'message_must_be_positive_number',
                null,
                $foundValue
            );
        }


        /**
         * @param $foundValue [Name of the expected value as a string]
         * @return string     [Concatenated message as a string]
         */
        static function getMustNotBeNegativeNumberMessage($foundValue) {
            return Strings::getFormattedString(
                'message_must_not_be_negative',
                null,
                $foundValue
            );
        }

        /**
         * @param $configField [Name of the expected value as a string]
         * @return string      [Concatenated message as a string]
         */
        static function getConfigFieldNotFoundMessage($configField) {
            return Strings::getFormattedString(
                'message_config_field_not_found',
                null,
                $configField
            );
        }

        /**
         * @param $propertyName [Name of the property as a string]
         * @param $className    [Name of the class as a string]
         * @return string       [Concatenated message as a string]
         */
        static function getNonExistentPropertyMessage($propertyName, $className) {
            return Strings::getFormattedString(
                'message_nonexistent_property',
                null,
                $propertyName,
                $className
            );
        }

        /**
         * @param $factoryClassName [Name of the uninitialized factory class as a string]
         * @return string           [Concatenated message as a string]
         */
        static function getFactoryClassNotInitializedMessage($factoryClassName) {
            return Strings::getFormattedString(
                'message_factory_class_not_initialized',
                null,
                $factoryClassName
            );
        }

        /**
         * @param $factoryClassName   [Name of the factory class as a string]
         * @param $factoriesNamespace [Name of the namespace that the factory class is supposed to be in as a string]
         * @return string             [Concatenated message as a string]
         */
        static function getFactoryClassExpectedInNamespaceMessage($factoryClassName, $factoriesNamespace) {
            return Strings::getFormattedString(
                'message_factory_class_expected_in_namespace',
                null,
                $factoryClassName,
                $factoriesNamespace
            );
        }

        /**
         * @param $factoryClassName         [Name of the factory class as a string]
         * @param $factoryClassAncestorName [Name of the factory class' expected parent class name as a string]
         * @return string                   [Concatenated message as a string]
         */
        static function getFactoryClassExpectedAncestorMessage($factoryClassName, $factoryClassAncestorName) {
            return Strings::getFormattedString(
                'message_factory_class_expected_ancestor',
                null,
                $factoryClassName,
                $factoryClassAncestorName
            );
        }

        /**
         * @return string [Message as a string]
         */
        static function getMustDefineManufacturedClassNameMessage() {
            return Strings::getString('message_must_define_manufactured_class_name');
        }

        /**
         * @param $className [Name of the class that has not been defined]
         * @return string    [Concatenated message as a string]
         */
        static function getClassNotDefinedMessage($className) {
            return Strings::getFormattedString(
                'message_class_not_defined',
                null,
                $className
            );
        }

        /**
         * @return string [Message as a string]
         */
        static function getInvalidTypeMessage() {
            return Strings::getString('message_invalid_type_specified');
        }

        /**
         * @return string [Message as a string]
         */
        static function getStartDateMustBeBeforeEndDateMessage() {
            return Strings::getString('message_start_date_must_be_before_end_date');
        }

        /**
         * @return string [Message as a string]
         */
        static function getDayCountConventionNotDefinedMessage() {
            return Strings::getString('message_day_count_convention_not_defined');
        }

        /**
         * @return string [Message as a string]
         */
        static function getPropresultarrayNotSuppliedMessage() {
            return Strings::getString('message_propresultarray_not_supplied');
        }

        /**
         * @param $methodName [Name of the method]
         * @param $className  [Name of the class]
         * @return string     [Concatenated message as a string]
         */
        static function getMethodDoesNotExistMessage($methodName, $className) {
            return Strings::getFormattedString(
                'message_method_does_not_exist',
                null,
                $methodName,
                $className
            );
        }
    }
}