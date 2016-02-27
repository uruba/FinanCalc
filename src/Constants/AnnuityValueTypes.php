<?php

namespace FinanCalc\Constants {

    use FinanCalc\Utils\Enum;

    /**
     * Class AnnuityValueTypes
     * @package FinanCalc\Constants
     */
    class AnnuityValueTypes extends Enum
    {
        const PRESENT_VALUE = 1;
        const FUTURE_VALUE = 2;
    }
}