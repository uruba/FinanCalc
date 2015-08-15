<?php

namespace FinanCalc\Calculators {

    use FinanCalc\Calculators\BondYTMCalculator\BondInstance;
    use FinanCalc\Interfaces\CalculatorInterface;

    /**
     * Class BondYTMCalculator
     * @package FinanCalc\Calculators
     */
    class BondYTMCalculator implements CalculatorInterface {
        private $bondInstance;

        /**
         * @param $bondFaceValue
         * @param $bondMarketValue
         * @param $bondAnnualCouponRate
         * @param $bondYearsToMaturity
         * @param int $bondPaymentFrequency
         */
        function __construct($bondFaceValue,
                             $bondMarketValue,
                             $bondAnnualCouponRate,
                             $bondYearsToMaturity,
                             $bondPaymentFrequency = 1) {
            $this->bondInstance = new BondInstance($bondFaceValue,
                $bondMarketValue,
                $bondAnnualCouponRate,
                $bondYearsToMaturity,
                $bondPaymentFrequency);
        }

        /**
         * @return BondInstance
         */
        function getResult() {
            return $this->bondInstance;
        }
    }
}

namespace FinanCalc\Calculators\BondYTMCalculator {

    use FinanCalc\Interfaces\BondInstanceAbstract;
    use FinanCalc\Utils\Helpers;
    use FinanCalc\Utils\MathFuncs;

    /**
     * Class BondInstance
     * @package FinanCalc\Calculators\BondYTMCalculator
     */
    class BondInstance extends BondInstanceAbstract {

        // market value of the bond = 'P'
        private $bondMarketValue;

        // INHERITED MEMBERS
        // face value of the bond = 'F'
        // $bondFaceValue;

        // coupon rate of the bond per annum = 'c'
        // $bondAnnualCouponRate;

        // number of years to the maturity of the bond
        // $bondYearsToMaturity;

        // frequency of bond payments (expressed in a divisor of 12 months ~ 1 year)
        // e.g.: divisor 2 means semi-annual payments
        // $bondPaymentFrequency;

        /**
         * @param $bondFaceValue
         * @param $bondMarketValue
         * @param $bondAnnualCouponRate
         * @param $bondYearsToMaturity
         * @param $bondPaymentFrequency
         */
        function __construct($bondFaceValue,
                             $bondMarketValue,
                             $bondAnnualCouponRate,
                             $bondYearsToMaturity,
                             $bondPaymentFrequency) {
            $this->setBondFaceValue($bondFaceValue);
            $this->setBondMarketValue($bondMarketValue);
            $this->setBondAnnualCouponRate($bondAnnualCouponRate);
            $this->setBondYearsToMaturity($bondYearsToMaturity);
            $this->setBondPaymentFrequency($bondPaymentFrequency);
        }

        /**
         * @param $bondMarketValue
         */
        public function setBondMarketValue($bondMarketValue) {
            if(Helpers::checkIfPositiveNumberOrThrowAnException($bondMarketValue)) {
                $this->bondMarketValue = $bondMarketValue;
            }
        }

        /**
         * @return mixed
         */
        public function getBondMarketValue() {
            return $this->bondMarketValue;
        }

        /**
         * @return string
         */
        public function getApproxBondYTM() {
            // we need to calculate the coupon payment C = F*(c/payment frequency)
            $couponPayment =
                MathFuncs::mul(
                    $this->bondFaceValue,
                    MathFuncs::div(
                        $this->bondAnnualCouponRate,
                        $this->bondPaymentFrequency
                    )
                );

            // we use a formula to approximate the YTM = (C+(F-P)/n)/((F+P)/2)
            $approxYTM =
                MathFuncs::div(
                    MathFuncs::add(
                        $couponPayment,
                        MathFuncs::div(
                            MathFuncs::sub(
                                $this->bondFaceValue,
                                $this->bondMarketValue),
                            $this->getBondNoOfPayments()
                        )
                    ),
                    MathFuncs::div(
                        MathFuncs::add(
                            $this->bondFaceValue,
                            $this->bondMarketValue
                        ),
                        2));

            return $approxYTM;
        }

        // TODO – add a method for precise bond YTM calculation by means of a polynominal equation
    }
}