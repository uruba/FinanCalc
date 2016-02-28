<?php

namespace FinanCalc\Calculators\Factories {

    use FinanCalc\Calculators\SimpleInterestCalculator;
    use FinanCalc\Interfaces\Calculator\CalculatorFactoryAbstract;
    use FinanCalc\Utils\Time\TimeSpan;

    /**
     * Class SimpleInterestCalculatorFactory
     * @package FinanCalc\Calculators\Factories
     */
    class SimpleInterestCalculatorFactory extends CalculatorFactoryAbstract
    {
        const MANUFACTURED_CLASS_NAME = 'FinanCalc\\Calculators\\SimpleInterestCalculator';

        /**
         * @param $principal
         * @param $annualInterestRate
         * @param TimeSpan $time
         * @return SimpleInterestCalculator
         */
        public function newSimpleInterest($principal, $annualInterestRate, TimeSpan $time)
        {
            return $this->manufactureInstance(
                [
                    $principal,
                    $annualInterestRate,
                    $time
                ]
            );
        }
    }
}
