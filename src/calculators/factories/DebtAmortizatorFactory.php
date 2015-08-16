<?php

namespace FinanCalc\Calculators\Factories {
    use FinanCalc\Constants\AnnuityPaymentTypes;
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
         * Payments IN ARREARS
         */

        /**
         * @param $debtPrincipal
         * @param $debtNoOfPeriods
         * @param $debtInterest
         * @return DebtAmortizator
         */

        public function newYearlyDebtAmortizationInArrears($debtPrincipal, $debtNoOfPeriods, $debtInterest)
        {
            return new DebtAmortizator(
                $debtPrincipal,
                $debtNoOfPeriods,
                Defaults::LENGTH_YEAR_360_30,
                $debtInterest,
                new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ARREARS));
        }

        /**
         * @param $debtPrincipal
         * @param $debtNoOfPeriods
         * @param $debtInterest
         * @return DebtAmortizator
         */
        public function newMonthlyDebtAmortizationInArrears($debtPrincipal, $debtNoOfPeriods, $debtInterest)
        {
            return new DebtAmortizator(
                $debtPrincipal,
                $debtNoOfPeriods,
                Defaults::LENGTH_MONTH_360_30,
                $debtInterest,
                new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ARREARS));
        }

        /**
         * @param $debtPrincipal
         * @param $debtNoOfPeriods
         * @param $debtInterest
         * @return DebtAmortizator
         */
        public function newDailyDebtAmortizationInArrears($debtPrincipal, $debtNoOfPeriods, $debtInterest)
        {
            return new DebtAmortizator(
                $debtPrincipal,
                $debtNoOfPeriods,
                Defaults::LENGTH_DAY_360_30,
                $debtInterest,
                new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ARREARS));
        }

        /**
         * @param $debtPrincipal
         * @param $debtNoOfPeriods
         * @param $debtInterest
         * @param $debtSinglePeriodLength
         * @return DebtAmortizator
         */
        public function newDebtAmortizationInArrearsCustomPeriodLength($debtPrincipal, $debtNoOfPeriods, $debtInterest, $debtSinglePeriodLength) {
            return new DebtAmortizator(
                $debtPrincipal,
                $debtNoOfPeriods,
                $debtSinglePeriodLength,
                $debtInterest,
                new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ARREARS));
        }

        /**
         * Payments IN ADVANCE
         */

        /**
         * @param $debtPrincipal
         * @param $debtNoOfPeriods
         * @param $debtInterest
         * @return DebtAmortizator
         */

        public function newYearlyDebtAmortizationInAdvance($debtPrincipal, $debtNoOfPeriods, $debtInterest)
        {
            return new DebtAmortizator(
                $debtPrincipal,
                $debtNoOfPeriods,
                Defaults::LENGTH_YEAR_360_30,
                $debtInterest,
                new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ADVANCE));
        }

        /**
         * @param $debtPrincipal
         * @param $debtNoOfPeriods
         * @param $debtInterest
         * @return DebtAmortizator
         */
        public function newMonthlyDebtAmortizationInAdvance($debtPrincipal, $debtNoOfPeriods, $debtInterest)
        {
            return new DebtAmortizator(
                $debtPrincipal,
                $debtNoOfPeriods,
                Defaults::LENGTH_MONTH_360_30,
                $debtInterest,
                new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ADVANCE));
        }

        /**
         * @param $debtPrincipal
         * @param $debtNoOfPeriods
         * @param $debtInterest
         * @return DebtAmortizator
         */
        public function newDailyDebtAmortizationInAdvance($debtPrincipal, $debtNoOfPeriods, $debtInterest)
        {
            return new DebtAmortizator(
                $debtPrincipal,
                $debtNoOfPeriods,
                Defaults::LENGTH_DAY_360_30,
                $debtInterest,
                new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ADVANCE));
        }

        /**
         * @param $debtPrincipal
         * @param $debtNoOfPeriods
         * @param $debtInterest
         * @param $debtSinglePeriodLength
         * @return DebtAmortizator
         */
        public function newDebtAmortizationInAdvanceCustomPeriodLength($debtPrincipal, $debtNoOfPeriods, $debtInterest, $debtSinglePeriodLength) {
            return new DebtAmortizator(
                $debtPrincipal,
                $debtNoOfPeriods,
                $debtSinglePeriodLength,
                $debtInterest,
                new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ADVANCE));
        }
    }
}