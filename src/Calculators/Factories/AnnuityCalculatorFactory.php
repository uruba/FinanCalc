<?php

namespace FinanCalc\Calculators\Factories {
    use FinanCalc\Calculators\AnnuityCalculator;
    use FinanCalc\Interfaces\Calculator\CalculatorFactoryAbstract;
    use FinanCalc\Utils\TimeUtils;

    /**
     * Class AnnuityCalculatorFactory
     * @package FinanCalc\Calculators\Factories
     */
    class AnnuityCalculatorFactory extends CalculatorFactoryAbstract {
        const MANUFACTURED_CLASS_NAME = 'FinanCalc\\Calculators\\AnnuityCalculator';

        /**
         * @param $annuitySinglePaymentAmount
         * @param $annuityNoOfCompoundingPeriods
         * @param $annuityInterest
         * @return AnnuityCalculator
         */
        public function newYearlyAnnuity($annuitySinglePaymentAmount, $annuityNoOfCompoundingPeriods, $annuityInterest) {
            return new AnnuityCalculator(
                $annuitySinglePaymentAmount,
                $annuityNoOfCompoundingPeriods,
                TimeUtils::getDaysFromYears(1),
                $annuityInterest);
        }

        /**
         * @param $annuitySinglePaymentAmount
         * @param $annuityNoOfCompoundingPeriods
         * @param $annuityInterest
         * @return AnnuityCalculator
         */
        public function newMonthlyAnnuity($annuitySinglePaymentAmount, $annuityNoOfCompoundingPeriods, $annuityInterest) {
            return new AnnuityCalculator(
                $annuitySinglePaymentAmount,
                $annuityNoOfCompoundingPeriods,
                TimeUtils::getDaysFromMonths(1),
                $annuityInterest);
        }

        /**
         * @param $annuitySinglePaymentAmount
         * @param $annuityNoOfCompoundingPeriods
         * @param $annuityInterest
         * @return AnnuityCalculator
         */
        public function newDailyAnnuity($annuitySinglePaymentAmount, $annuityNoOfCompoundingPeriods, $annuityInterest) {
            return new AnnuityCalculator(
                $annuitySinglePaymentAmount,
                $annuityNoOfCompoundingPeriods,
                1,
                $annuityInterest);
        }

        /**
         * @param $annuitySinglePaymentAmount
         * @param $annuityInterest
         * @return AnnuityCalculator
         */
        public function newPerpetuity($annuitySinglePaymentAmount, $annuityInterest) {
            return new AnnuityCalculator(
                $annuitySinglePaymentAmount,
                0,
                0,
                $annuityInterest);
        }
    }
}