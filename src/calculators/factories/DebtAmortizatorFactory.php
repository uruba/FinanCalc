<?php

namespace FinanCalc\Calculators\Factories {
    use \FinanCalc\Constants\Defaults;
    use \FinanCalc\Calculators\DebtAmortizator;
    use FinanCalc\Interfaces\CalculatorFactoryAbstract;

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
            return new DebtAmortizator(
                $debtPrincipal,
                $debtNoOfPeriods,
                Defaults::LENGTH_YEAR_360_30,
                $debtInterest);
        }

        /**
         * @param $debtPrincipal
         * @param $debtNoOfPeriods
         * @param $debtInterest
         * @return DebtAmortizator
         */
        public function newMonthlyDebtAmortization($debtPrincipal, $debtNoOfPeriods, $debtInterest)
        {
            return new DebtAmortizator(
                $debtPrincipal,
                $debtNoOfPeriods,
                Defaults::LENGTH_MONTH_360_30,
                $debtInterest);
        }

        /**
         * @param $debtPrincipal
         * @param $debtNoOfPeriods
         * @param $debtInterest
         * @return DebtAmortizator
         */
        public function newDailyDebtAmortization($debtPrincipal, $debtNoOfPeriods, $debtInterest)
        {
            return new DebtAmortizator(
                $debtPrincipal,
                $debtNoOfPeriods,
                Defaults::LENGTH_DAY_360_30,
                $debtInterest);
        }

        /**
         * @param $debtPrincipal
         * @param $debtNoOfPeriods
         * @param $debtInterest
         * @param $debtSinglePeriodLength
         * @return DebtAmortizator
         */
        public function newDebtAmortizationCustomPeriodLength($debtPrincipal, $debtNoOfPeriods, $debtInterest, $debtSinglePeriodLength) {
            return new DebtAmortizator(
                $debtPrincipal,
                $debtNoOfPeriods,
                $debtSinglePeriodLength,
                $debtInterest);
        }
    }
}