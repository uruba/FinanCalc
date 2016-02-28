<?php

namespace FinanCalc\Calculators\Factories {


    use FinanCalc\Calculators\BondYTMCalculator;
    use FinanCalc\Interfaces\Calculator\CalculatorFactoryAbstract;

    /**
     * Class BondYTMCalculatorFactory
     * @package FinanCalc\Calculators\Factories
     */
    class BondYTMCalculatorFactory extends CalculatorFactoryAbstract
    {
        const MANUFACTURED_CLASS_NAME = 'FinanCalc\\Calculators\\BondYTMCalculator';

        /**
         * @param $bondFaceValue
         * @param $bondMarketValue
         * @param $bondAnnualCouponRate
         * @param $bondYearsToMaturity
         * @return BondYTMCalculator
         * @internal param $bondVIR
         */
        public function newAnnualCouponsBond(
            $bondFaceValue,
            $bondMarketValue,
            $bondAnnualCouponRate,
            $bondYearsToMaturity
        ) {
            return $this->manufactureInstance(
                [
                    $bondFaceValue,
                    $bondMarketValue,
                    $bondAnnualCouponRate,
                    $bondYearsToMaturity
                ]
            );
        }

        /**
         * @param $bondFaceValue
         * @param $bondMarketValue
         * @param $bondAnnualCouponRate
         * @param $bondYearsToMaturity
         * @return BondYTMCalculator
         * @internal param $bondVIR
         */
        public function newSemiAnnualCouponsBond(
            $bondFaceValue,
            $bondMarketValue,
            $bondAnnualCouponRate,
            $bondYearsToMaturity
        ) {
            return $this->manufactureInstance(
                [
                    $bondFaceValue,
                    $bondMarketValue,
                    $bondAnnualCouponRate,
                    $bondYearsToMaturity,
                    2
                ]
            );
        }

        /**
         * @param $bondFaceValue
         * @param $bondMarketValue
         * @param $bondAnnualCouponRate
         * @param $bondYearsToMaturity
         * @return BondYTMCalculator
         * @internal param $bondVIR
         */
        public function newQuarterlyCouponsBond(
            $bondFaceValue,
            $bondMarketValue,
            $bondAnnualCouponRate,
            $bondYearsToMaturity
        ) {
            return $this->manufactureInstance(
                [
                    $bondFaceValue,
                    $bondMarketValue,
                    $bondAnnualCouponRate,
                    $bondYearsToMaturity,
                    4
                ]
            );
        }

        /**
         * @param $bondFaceValue
         * @param $bondMarketValue
         * @param $bondAnnualCouponRate
         * @param $bondYearsToMaturity
         * @return BondYTMCalculator
         * @internal param $bondVIR
         */
        public function newMonthlyCouponsBond(
            $bondFaceValue,
            $bondMarketValue,
            $bondAnnualCouponRate,
            $bondYearsToMaturity
        ) {
            return $this->manufactureInstance(
                [
                    $bondFaceValue,
                    $bondMarketValue,
                    $bondAnnualCouponRate,
                    $bondYearsToMaturity,
                    12
                ]
            );
        }

        /**
         * @param $bondFaceValue
         * @param $bondMarketValue
         * @param $bondAnnualCouponRate
         * @param $bondYearsToMaturity
         * @param $bondPaymentFrequency
         * @return BondYTMCalculator
         * @internal param $bondVIR
         */
        public function newCustomCouponFrequencyBond(
            $bondFaceValue,
            $bondMarketValue,
            $bondAnnualCouponRate,
            $bondYearsToMaturity,
            $bondPaymentFrequency
        ) {
            return $this->manufactureInstance(
                [
                    $bondFaceValue,
                    $bondMarketValue,
                    $bondAnnualCouponRate,
                    $bondYearsToMaturity,
                    $bondPaymentFrequency
                ]
            );
        }
    }
}
