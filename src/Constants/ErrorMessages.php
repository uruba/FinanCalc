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
            return sprintf(
                Strings::getString('message_nonexistent_property'),
                $propertyName,
                $className
            );
        }

        /**
         * @param $factoryClassName [Name of the uninitialized factory class as a string]
         * @return string           [Concatenated message as a string]
         */
        static function getFactoryClassNotInitializedMessage($factoryClassName) {
            return sprintf(
                Strings::getString('message_factory_class_not_initialized'),
                $factoryClassName
            );
        }

        /**
         * @param $factoryClassName   [Name of the factory class as a string]
         * @param $factoriesNamespace [Name of the namespace that the factory class is supposed to be in as a string]
         * @return string             [Concatenated message as a string]
         */
        static function getFactoryClassExpectedInNamespaceMessage($factoryClassName, $factoriesNamespace) {
            return sprintf(
                Strings::getString('message_factory_class_expected_in_namespace'),
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
            return sprintf(
                Strings::getString('message_factory_class_expected_ancestor'),
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
            return sprintf(
                Strings::getString('message_class_not_defined'),
                $className
            );
        }
    }
}