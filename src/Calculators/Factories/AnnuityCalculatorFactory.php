<?php

namespace FinanCalc\Calculators\Factories {

    use FinanCalc\Calculators\AnnuityCalculator;
    use FinanCalc\Interfaces\Calculator\CalculatorFactoryAbstract;
    use FinanCalc\Utils\Time\TimeSpan;

    /**
     * Class AnnuityCalculatorFactory
     * @package FinanCalc\Calculators\Factories
     */
    class AnnuityCalculatorFactory extends CalculatorFactoryAbstract
    {
        const MANUFACTURED_CLASS_NAME = 'FinanCalc\\Calculators\\AnnuityCalculator';

        /**
         * @param $annuitySinglePaymentAmount
         * @param $annuityNoOfCompoundingPeriods
         * @param $annuityInterest
         * @return AnnuityCalculator
         */
        public function newYearlyAnnuity($annuitySinglePaymentAmount, $annuityNoOfCompoundingPeriods, $annuityInterest)
        {
            return $this->manufactureInstance(
                [
                    $annuitySinglePaymentAmount,
                    $annuityNoOfCompoundingPeriods,
                    TimeSpan::asDuration(1),
                    $annuityInterest
                ]
            );
        }

        /**
         * @param $annuitySinglePaymentAmount
         * @param $annuityNoOfCompoundingPeriods
         * @param $annuityInterest
         * @return AnnuityCalculator
         */
        public function newMonthlyAnnuity($annuitySinglePaymentAmount, $annuityNoOfCompoundingPeriods, $annuityInterest)
        {
            return $this->manufactureInstance(
                [
                    $annuitySinglePaymentAmount,
                    $annuityNoOfCompoundingPeriods,
                    TimeSpan::asDuration(0, 1),
                    $annuityInterest
                ]
            );
        }

        /**
         * @param $annuitySinglePaymentAmount
         * @param $annuityNoOfCompoundingPeriods
         * @param $annuityInterest
         * @return AnnuityCalculator
         */
        public function newDailyAnnuity($annuitySinglePaymentAmount, $annuityNoOfCompoundingPeriods, $annuityInterest)
        {
            return $this->manufactureInstance(
                [
                    $annuitySinglePaymentAmount,
                    $annuityNoOfCompoundingPeriods,
                    TimeSpan::asDuration(0, 0, 1),
                    $annuityInterest
                ]
            );
        }

        /**
         * @param $annuitySinglePaymentAmount
         * @param $annuityInterest
         * @return AnnuityCalculator
         */
        public function newPerpetuity($annuitySinglePaymentAmount, $annuityInterest)
        {
            return $this->manufactureInstance(
                [
                    $annuitySinglePaymentAmount,
                    0,
                    TimeSpan::asDuration(0),
                    $annuityInterest
                ]
            );
        }
    }
}
