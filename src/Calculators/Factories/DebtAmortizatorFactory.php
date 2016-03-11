<?php

namespace FinanCalc\Calculators\Factories {

    use FinanCalc\Calculators\DebtAmortizator;
    use FinanCalc\Interfaces\Calculator\CalculatorFactoryAbstract;
    use FinanCalc\Utils\Time\TimeSpan;

    /**
     * Class DebtAmortizatorFactory
     * @package FinanCalc\Calculators\Factories
     */
    class DebtAmortizatorFactory extends CalculatorFactoryAbstract
    {
        const MANUFACTURED_CLASS_NAME = 'FinanCalc\\Calculators\\DebtAmortizator';

        /**
         * @param $debtPrincipal
         * @param $debtNoOfPeriods
         * @param $debtInterest
         * @return DebtAmortizator
         */
        public function newYearlyDebtAmortization($debtPrincipal, $debtNoOfPeriods, $debtInterest)
        {
            return $this->manufactureInstance(
                [
                    $debtPrincipal,
                    $debtNoOfPeriods,
                    TimeSpan::asDuration(1),
                    $debtInterest
                ]
            );
        }

        /**
         * @param $debtPrincipal
         * @param $debtNoOfPeriods
         * @param $debtInterest
         * @return DebtAmortizator
         */
        public function newMonthlyDebtAmortization($debtPrincipal, $debtNoOfPeriods, $debtInterest)
        {
            return $this->manufactureInstance(
                [
                    $debtPrincipal,
                    $debtNoOfPeriods,
                    TimeSpan::asDuration(0, 1),
                    $debtInterest
                ]
            );
        }

        /**
         * @param $debtPrincipal
         * @param $debtNoOfPeriods
         * @param $debtInterest
         * @return DebtAmortizator
         */
        public function newDailyDebtAmortization($debtPrincipal, $debtNoOfPeriods, $debtInterest)
        {
            return $this->manufactureInstance(
                [
                    $debtPrincipal,
                    $debtNoOfPeriods,
                    TimeSpan::asDuration(0, 0, 1),
                    $debtInterest
                ]
            );
        }

        /**
         * @param $debtPrincipal
         * @param $debtNoOfPeriods
         * @param $debtInterest
         * @param TimeSpan $debtPeriodLength
         * @return \FinanCalc\Interfaces\Calculator\CalculatorAbstract
         */
        public function newDebtAmortizationCustomPeriodLength(
            $debtPrincipal,
            $debtNoOfPeriods,
            $debtInterest,
            TimeSpan $debtPeriodLength
        ) {
            return $this->manufactureInstance(
                [
                    $debtPrincipal,
                    $debtNoOfPeriods,
                    $debtPeriodLength,
                    $debtInterest
                ]
            );
        }
    }
}
