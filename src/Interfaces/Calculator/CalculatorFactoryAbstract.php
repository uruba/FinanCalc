<?php

namespace FinanCalc\Interfaces\Calculator {
    /**
     * Class CalculatorFactoryAbstract
     * @package FinanCalc\Interfaces
     */
    abstract class CalculatorFactoryAbstract {
        const MANUFACTURED_CLASS_NAME = null;

        /**
         * @throws \Exception
         */
        public function __construct() {
            if (!is_string(static::MANUFACTURED_CLASS_NAME)) {
                throw new \Exception("String class constant MANUFACTURED_CLASS_NAME has to be defined!");
            }

            if (!class_exists(static::MANUFACTURED_CLASS_NAME)) {
                throw new \Exception("Class" . static::MANUFACTURED_CLASS_NAME .  " not defined");
            }
        }
    }
}