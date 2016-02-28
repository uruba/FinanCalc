<?php

namespace FinanCalc\Calculators\Factories {

    use FinanCalc\Calculators\SimpleDiscountCalculator;
    use FinanCalc\Interfaces\Calculator\CalculatorFactoryAbstract;
    use FinanCalc\Utils\Time\TimeSpan;

    /**
     * Class SimpleDiscountCalculatorFactory
     * @package FinanCalc\Calculators\Factories
     */
    class SimpleDiscountCalculatorFactory extends CalculatorFactoryAbstract
    {
        const MANUFACTURED_CLASS_NAME = 'FinanCalc\\Calculators\\SimpleDiscountCalculator';

        /**
         * @param $amountDue
         * @param $annualDiscountRate
         * @param TimeSpan $time
         * @return SimpleDiscountCalculator
         */
        public function newSimpleDiscount($amountDue, $annualDiscountRate, TimeSpan $time)
        {
            return $this->manufactureInstance(
                [
                    $amountDue,
                    $annualDiscountRate,
                    $time
                ]
            );
        }
    }
}
