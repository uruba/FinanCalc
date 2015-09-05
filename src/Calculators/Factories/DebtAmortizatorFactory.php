<?php

namespace FinanCalc\Calculators\Factories {
    use \FinanCalc\Calculators\DebtAmortizator;
    use FinanCalc\Interfaces\Calculator\CalculatorFactoryAbstract;
    use FinanCalc\Utils\Time\TimeUtils;

    /**
     * Class DebtAmortizatorFactory
     * @package FinanCalc\Calculators\Factories
     */
    class DebtAmortizatorFactory extends CalculatorFactoryAbstract {
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
                    TimeUtils::getDaysFromYears(1),
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
                    TimeUtils::getDaysFromMonths(1),
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
                    1,
                    $debtInterest
                ]
            );
        }

        /**
         * @param $debtPrincipal
         * @param $debtNoOfPeriods
         * @param $debtInterest
         * @param $debtSinglePeriodLength
         * @return DebtAmortizator
         */
        public function newDebtAmortizationCustomPeriodLength($debtPrincipal, $debtNoOfPeriods, $debtInterest, $debtSinglePeriodLength) {
            return $this->manufactureInstance(
                [
                    $debtPrincipal,
                    $debtNoOfPeriods,
                    $debtSinglePeriodLength,
                    $debtInterest
                ]
            );
        }
    }
}