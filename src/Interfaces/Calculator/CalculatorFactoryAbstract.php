<?php

namespace FinanCalc\Interfaces\Calculator {

    use Exception;
    use FinanCalc\Constants\ErrorMessages;
    use ReflectionClass;

    /**
     * Class CalculatorFactoryAbstract
     * @package FinanCalc\Interfaces
     */
    abstract class CalculatorFactoryAbstract {
        const MANUFACTURED_CLASS_NAME = null;

        /**
         * @throws Exception
         */
        public final function __construct() {
            if (!is_string(static::MANUFACTURED_CLASS_NAME)) {
                throw new Exception(ErrorMessages::getMustDefineManufacturedClassNameMessage());
            }

            if (!class_exists(static::MANUFACTURED_CLASS_NAME)) {
                throw new Exception(ErrorMessages::getClassNotDefinedMessage(static::MANUFACTURED_CLASS_NAME));
            }
        }

        /**
         * @param array $args
         * @return CalculatorAbstract
         */
        protected final function manufactureInstance(array $args) {
            $manufacturedClass = new ReflectionClass(static::MANUFACTURED_CLASS_NAME);
            return $manufacturedClass->newInstanceArgs($args);
        }
    }
}