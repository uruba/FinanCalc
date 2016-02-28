<?php

namespace FinanCalc\Calculators\Factories {

    use FinanCalc\Calculators\BondFairValueCalculator;
    use FinanCalc\Interfaces\Calculator\CalculatorFactoryAbstract;


    /**
     * Class BondFairValueCalculatorFactory
     * @package FinanCalc\Calculators\Factories
     */
    class BondFairValueCalculatorFactory extends CalculatorFactoryAbstract
    {
        const MANUFACTURED_CLASS_NAME = 'FinanCalc\\Calculators\\BondFairValueCalculator';

        /**
         * @param $bondFaceValue
         * @param $bondAnnualCouponRate
         * @param $bondVIR
         * @param $bondYearsToMaturity
         * @return BondFairValueCalculator
         */
        public function newAnnualCouponsBond($bondFaceValue, $bondAnnualCouponRate, $bondVIR, $bondYearsToMaturity)
        {
            return $this->manufactureInstance(
                [
                    $bondFaceValue,
                    $bondAnnualCouponRate,
                    $bondVIR,
                    $bondYearsToMaturity
                ]
            );
        }

        /**
         * @param $bondFaceValue
         * @param $bondAnnualCouponRate
         * @param $bondVIR
         * @param $bondYearsToMaturity
         * @return BondFairValueCalculator
         */
        public function newSemiAnnualCouponsBond($bondFaceValue, $bondAnnualCouponRate, $bondVIR, $bondYearsToMaturity)
        {
            return $this->manufactureInstance(
                [
                    $bondFaceValue,
                    $bondAnnualCouponRate,
                    $bondVIR,
                    $bondYearsToMaturity,
                    2
                ]
            );
        }

        /**
         * @param $bondFaceValue
         * @param $bondAnnualCouponRate
         * @param $bondVIR
         * @param $bondYearsToMaturity
         * @return BondFairValueCalculator
         */
        public function newQuarterlyCouponsBond($bondFaceValue, $bondAnnualCouponRate, $bondVIR, $bondYearsToMaturity)
        {
            return $this->manufactureInstance(
                [
                    $bondFaceValue,
                    $bondAnnualCouponRate,
                    $bondVIR,
                    $bondYearsToMaturity,
                    4
                ]
            );
        }

        /**
         * @param $bondFaceValue
         * @param $bondAnnualCouponRate
         * @param $bondVIR
         * @param $bondYearsToMaturity
         * @return BondFairValueCalculator
         */
        public function newMonthlyCouponsBond($bondFaceValue, $bondAnnualCouponRate, $bondVIR, $bondYearsToMaturity)
        {
            return $this->manufactureInstance(
                [
                    $bondFaceValue,
                    $bondAnnualCouponRate,
                    $bondVIR,
                    $bondYearsToMaturity,
                    12
                ]
            );
        }

        /**
         * @param $bondFaceValue
         * @param $bondAnnualCouponRate
         * @param $bondVIR
         * @param $bondYearsToMaturity
         * @param $bondPaymentFrequency
         * @return BondFairValueCalculator
         */
        public function newCustomCouponFrequencyBond(
            $bondFaceValue,
            $bondAnnualCouponRate,
            $bondVIR,
            $bondYearsToMaturity,
            $bondPaymentFrequency
        ) {
            return $this->manufactureInstance(
                [
                    $bondFaceValue,
                    $bondAnnualCouponRate,
                    $bondVIR,
                    $bondYearsToMaturity,
                    $bondPaymentFrequency
                ]
            );
        }
    }
}
