<?php

namespace FinanCalc\Utils {
    use FinanCalc\Constants\Defaults;

    /**
     * Class Config
     * @package FinanCalc\Utils
     */
    class Config {
        private static $configArray = array();

        /**
         * PRIVATE constructor
         */
        private function __construct() {}

        /**
         * @param null $defaultValues
         */
        public static function init($defaultValues = null) {
            if ($defaultValues == null) {
                $defaultValues = Defaults::$configDefault;
            } else {
                $defaultValues = array_merge($defaultValues, Defaults::$configDefault);
            }
            static::$configArray = $defaultValues;
        }

        /**
         * @param $key
         * @return mixed
         */
        public static function getConfigField($key){
            /** Shouldn't be needed when it's properly bootstrapped
            if(empty(static::$configArray)) {
                Config::init();
            }*/
            return static::$configArray[$key];
        }

        /**
         * @param $key
         * @param $value
         */
        public static function setConfigField($key, $value){
            /** Shouldn't be needed when it's properly bootstrapped
            if(empty(static::$configArray)) {
                Config::init();
            }}*/
            static::$configArray[$key] = $value;
        }

        /**
         * @return array
         */
        public static function getConfigArray() {
            return static::$configArray;
        }
    }
}