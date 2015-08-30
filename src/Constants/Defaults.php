<?php

namespace FinanCalc\Constants {
    /**
     * Class Defaults
     * @package FinanCalc\Constants
     */
    class Defaults
    {
        /**
         * MONEY defaults
         */
        const MONEY_DECIMAL_PLACES_PRECISION = 8;
        const MONEY_DECIMAL_PLACES_DISPLAY = 2;

        /**
         * PAYMENT defaults
         */
        const PAYMENT_TYPE = AnnuityPaymentTypes::IN_ARREARS;

        /**
         * CONFIG defaults
         */
        public static $configDefault = array(
            // Factories
            'factories_relative_path' => '/Calculators/Factories',
            'factories_namespace' => 'FinanCalc\\Calculators\\Factories',
            // Serializers
            'serializers_root_elem_name' => 'root',
            // time config
            'day_count_convention' => '30/360',
            'available_day_count_conventions' => [
                '30/360' => [
                    'days_in_a_year' => '360',
                    'days_in_a_month' => '30'
                ]
                /**
                 Not working yet
                ,
                'Actual/365' => [
                    'days_in_a_year' => '365',
                    'days_in_a_month' => '0'
                ]
                 *
                 */
            ]
        );
    }
}