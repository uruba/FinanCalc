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
         * @param string $identifier
         * @param string|null $locale
         * @return string
         */
        public static function getFormattedString($identifier, $locale)
        {
            $formatArgs = array_slice(func_get_args(), 2);

            $unformattedString = Strings::getString($identifier, $locale);

            return is_null($unformattedString) ?
                null : vsprintf($unformattedString, $formatArgs);
        }

        /**
         * @param string $identifier
         * @param string|null $locale
         * @return string
         * @throws \Exception
         */
        public static function getString($identifier, $locale = null)
        {
            if (is_null($locale)) {
                $locale = Config::getConfigField("locale");
            }

            $localePath = FinanCalc::getPath() . "/locale/$locale.php";

            if (!file_exists($localePath)) {
                return null;
            }

            /** @noinspection PhpIncludeInspection */
            $strings = include($localePath);

            if (!is_array($strings) || !array_key_exists($identifier, $strings)) {
                return null;
            }

            return $strings[$identifier];
        }
    }
}
