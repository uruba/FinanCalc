<?php

namespace FinanCalc\Utils {
    use FinanCalc\Constants\Defaults;

    class Config {
        private static $configArray = array();

        private function __construct() {}

        public static function init($defaultValues = null) {
            if ($defaultValues == null) {
                $defaultValues = Defaults::$configDefault;
            } else {
                $defaultValues = array_merge($defaultValues, Defaults::$configDefault);
            }
            self::$configArray = $defaultValues;
        }

        public static function getConfigField($key){
            if(empty(self::$configArray)) {
                Config::init();
            }
            return self::$configArray[$key];
        }

        public static function setConfigField($key, $value){
            if(empty(self::$configArray)) {
                Config::init();
            }
            self::$configArray[$key] = $value;
        }
    }
}