<?php

namespace FinanCalc\Calculators\Factories {
    use FinanCalc\Constants\AnnuityPaymentTypes;
    use \FinanCalc\Constants\Defaults;
    use \FinanCalc\Calculators\DebtAmortizator;
    use FinanCalc\Interfaces\CalculatorFactoryAbstract;

    /**
     * Class DebtAmortizationFactory
     * @package FinanCalc\Factories
     */
    class DebtAmortizationFactory extends CalculatorFactoryAbstract {
        const MANUFACTURED_CLASS_NAME = 'FinanCalc\\Calculators\\DebtAmortizator';

        /**
         *
         * Payments IN ARREARS
         *
         */

        public function newYearlyDebtAmortizationInArrears($debtPrincipal, $debtNoOfPeriods, $debtInterest)
        {
            return new DebtAmortizator(
                $debtPrincipal,
                $debtNoOfPeriods,
                $debtInterest,
                Defaults::LENGTH_YEAR_360_30,
                new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ARREARS));
        }

        public function newMonthlyDebtAmortizationInArrears($debtPrincipal, $debtNoOfPeriods, $debtInterest)
        {
            return new DebtAmortizator(
                $debtPrincipal,
                $debtNoOfPeriods,
                $debtInterest,
                Defaults::LENGTH_MONTH_360_30,
                new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ARREARS));
        }

        public function newDailyDebtAmortizationInArrears($debtPrincipal, $debtNoOfPeriods, $debtInterest)
        {
            return new DebtAmortizator(
                $debtPrincipal,
                $debtNoOfPeriods,
                $debtInterest,
                Defaults::LENGTH_DAY_360_30,
                new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ARREARS));
        }

        public function newDebtAmortizationInArrearsCustomPeriodLength($debtPrincipal, $debtNoOfPeriods, $debtInterest, $debtSinglePeriodLength) {
            return new DebtAmortizator(
                $debtPrincipal,
                $debtNoOfPeriods,
                $debtInterest,
                $debtSinglePeriodLength,
                new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ARREARS));
        }

        /**
         *
         * Payments IN ADVANCE
         *
         */

        public function newYearlyDebtAmortizationInAdvance($debtPrincipal, $debtNoOfPeriods, $debtInterest)
        {
            return new DebtAmortizator(
                $debtPrincipal,
                $debtNoOfPeriods,
                $debtInterest,
                Defaults::LENGTH_YEAR_360_30,
                new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ADVANCE));
        }

        public function newMonthlyDebtAmortizationInAdvance($debtPrincipal, $debtNoOfPeriods, $debtInterest)
        {
            return new DebtAmortizator(
                $debtPrincipal,
                $debtNoOfPeriods,
                $debtInterest,
                Defaults::LENGTH_MONTH_360_30,
                new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ADVANCE));
        }

        public function newDailyDebtAmortizationInAdvance($debtPrincipal, $debtNoOfPeriods, $debtInterest)
        {
            return new DebtAmortizator(
                $debtPrincipal,
                $debtNoOfPeriods,
                $debtInterest,
                Defaults::LENGTH_DAY_360_30,
                new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ADVANCE));
        }

        public function newDebtAmortizationInAdvanceCustomPeriodLength($debtPrincipal, $debtNoOfPeriods, $debtInterest, $debtSinglePeriodLength) {
            return new DebtAmortizator(
                $debtPrincipal,
                $debtNoOfPeriods,
                $debtInterest,
                $debtSinglePeriodLength,
                new AnnuityPaymentTypes(AnnuityPaymentTypes::IN_ADVANCE));
        }
    }
}