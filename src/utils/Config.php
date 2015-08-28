<?php

namespace FinanCalc\Utils {

    use Exception;
    use FinanCalc\Constants\Defaults;
    use FinanCalc\Constants\Strings;

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
                $defaultValues = array_merge(Defaults::$configDefault, $defaultValues);
            }
            static::$configArray = $defaultValues;
        }

        /**
         * @param $key
         * @return mixed
         * @throws Exception
         */
        public static function getConfigField($key){
            /** Shouldn't be needed when it's properly bootstrapped
            if(empty(static::$configArray)) {
                Config::init();
            }*/
            $configField = static::$configArray[$key];

            if ($configField === null) {
                throw new Exception(Strings::getConfigFieldNotFoundMessage($key));
            }

            return $configField;
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