<?php
/**
 * Created by PhpStorm.
 * User: uruba
 * Date: 2/15/2016
 * Time: 2:54 PM
 */

namespace FinanCalc\Utils {

    use FinanCalc\FinanCalc;

    /**
     * Class Strings
     * @package FinanCalc\Utils
     */
    class Strings
    {
        /**
         * @param $identifier
         * @param null $locale
         * @return string
         * @throws \Exception
         */
        static function getString($identifier, $locale = null) {
            if (is_null($locale)) {
                $locale = Config::getConfigField("locale");
            }

            $localePath = FinanCalc::getPath() . "/locale/$locale.php";

            if (!file_exists($localePath)) {
                return null;
            }

            /** @noinspection PhpIncludeInspection */
            $strings = include($localePath);

            if (is_null($strings)) {
                return null;
            }

            return $strings[$identifier];
        }

        /**
         * @param $identifier
         * @param null $formatArgs
         * @return string
         */
        static function getFormattedString($identifier, $formatArgs = null) {
            $formatArgs = func_get_args();
            array_shift($formatArgs);

            return vsprintf(Strings::getString($identifier), $formatArgs);
        }
    }
}