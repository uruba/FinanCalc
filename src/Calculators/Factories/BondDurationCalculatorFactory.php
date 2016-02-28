<?php

namespace FinanCalc\Calculators\Factories {

    use FinanCalc\Calculators\BondDurationCalculator;
    use FinanCalc\Interfaces\Calculator\CalculatorFactoryAbstract;


    /**
     * Class BondDurationCalculatorFactory
     * @package FinanCalc\Calculators\Factories
     */
    class BondDurationCalculatorFactory extends CalculatorFactoryAbstract
    {
        const MANUFACTURED_CLASS_NAME = 'FinanCalc\\Calculators\\BondDurationCalculator';


        /**
         * @param $bondFaceValue
         * @param $bondAnnualCouponRate
         * @param $bondAnnualYield
         * @param $bondYearsToMaturity
         * @return BondDurationCalculator
         */
        public function newAnnualCouponsBond(
            $bondFaceValue,
            $bondAnnualCouponRate,
            $bondAnnualYield,
            $bondYearsToMaturity
        ) {
            return $this->manufactureInstance(
                [
                    $bondFaceValue,
                    $bondAnnualCouponRate,
                    $bondAnnualYield,
                    $bondYearsToMaturity
                ]
            );
        }

        /**
         * @param $bondFaceValue
         * @param $bondAnnualCouponRate
         * @param $bondAnnualYield
         * @param $bondYearsToMaturity
         * @return BondDurationCalculator
         */
        public function newSemiAnnualCouponsBond(
            $bondFaceValue,
            $bondAnnualCouponRate,
            $bondAnnualYield,
            $bondYearsToMaturity
        ) {
            return $this->manufactureInstance(
                [
                    $bondFaceValue,
                    $bondAnnualCouponRate,
                    $bondAnnualYield,
                    $bondYearsToMaturity,
                    2
                ]
            );
        }


        /**
         * @param $bondFaceValue
         * @param $bondAnnualCouponRate
         * @param $bondAnnualYield
         * @param $bondYearsToMaturity
         * @return BondDurationCalculator
         */
        public function newQuarterlyCouponsBond(
            $bondFaceValue,
            $bondAnnualCouponRate,
            $bondAnnualYield,
            $bondYearsToMaturity
        ) {
            return $this->manufactureInstance(
                [
                    $bondFaceValue,
                    $bondAnnualCouponRate,
                    $bondAnnualYield,
                    $bondYearsToMaturity,
                    4
                ]
            );
        }


        /**
         * @param $bondFaceValue
         * @param $bondAnnualCouponRate
         * @param $bondAnnualYield
         * @param $bondYearsToMaturity
         * @return BondDurationCalculator
         */
        public function newMonthlyCouponsBond(
            $bondFaceValue,
            $bondAnnualCouponRate,
            $bondAnnualYield,
            $bondYearsToMaturity
        ) {
            return $this->manufactureInstance(
                [
                    $bondFaceValue,
                    $bondAnnualCouponRate,
                    $bondAnnualYield,
                    $bondYearsToMaturity,
                    12
                ]
            );
        }


        /**
         * @param $bondFaceValue
         * @param $bondAnnualCouponRate
         * @param $bondAnnualYield
         * @param $bondYearsToMaturity
         * @param $bondPaymentFrequency
         * @return BondDurationCalculator
         */
        public function newCustomCouponFrequencyBond(
            $bondFaceValue,
            $bondAnnualCouponRate,
            $bondAnnualYield,
            $bondYearsToMaturity,
            $bondPaymentFrequency
        ) {
            return $this->manufactureInstance(
                [
                    $bondFaceValue,
                    $bondAnnualCouponRate,
                    $bondAnnualYield,
                    $bondYearsToMaturity,
                    $bondPaymentFrequency
                ]
            );
        }

    }
}
