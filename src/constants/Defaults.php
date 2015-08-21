<?php

namespace FinanCalc\Constants {
    /**
     * Class Defaults
     * @package FinanCalc\Constants
     */
    class Defaults
    {
        /**
         * TIME defaults
         */
        const LENGTH_YEAR_360_30 = 360;
        const LENGTH_MONTH_360_30 = 30;
        const LENGTH_DAY_360_30 = 1;

        const DEFAULT_PERIOD_LENGTH = self::LENGTH_YEAR_360_30;

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
            // factories
            'factories_relative_path' => '/calculators/factories',
            'factories_namespace' => 'FinanCalc\\Calculators\\Factories',
            // serializers
            'serializers_root_elem_name' => 'root'
        );
    }
}