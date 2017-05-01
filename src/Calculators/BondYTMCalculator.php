<?php

namespace FinanCalc\Calculators {

    use FinanCalc\Interfaces\Calculator\BondCalculatorAbstract;
    use FinanCalc\Utils\Lambdas;
    use FinanCalc\Utils\MathFuncs;

    /**
     * Class BondYTMCalculator
     * @package FinanCalc\Calculators
     */
    class BondYTMCalculator extends BondCalculatorAbstract
    {

        // market value of the bond = 'P'
        protected $bondMarketValue;

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

        // props returned by the getResultAsArray method by default
        protected $propResultArray = [
            "bondFaceValue",
            "bondMarketValue",
            "bondAnnualCouponRate",
            "bondYearsToMaturity",
            "bondPaymentFrequency",
            "bondApproxYTM" => "approxBondYTM"
        ];

        /**
         * @param $bondFaceValue
         * @param $bondMarketValue
         * @param $bondAnnualCouponRate
         * @param $bondYearsToMaturity
         * @param $bondPaymentFrequency
         */
        public function __construct(
            $bondFaceValue,
            $bondMarketValue,
            $bondAnnualCouponRate,
            $bondYearsToMaturity,
            $bondPaymentFrequency = 1
        ) {
            $this->setBondFaceValue($bondFaceValue);
            $this->setBondMarketValue($bondMarketValue);
            $this->setBondAnnualCouponRate($bondAnnualCouponRate);
            $this->setBondYearsToMaturity($bondYearsToMaturity);
            $this->setBondPaymentFrequency($bondPaymentFrequency);
        }

        /**
         * @param $bondMarketValue
         */
        public function setBondMarketValue($bondMarketValue)
        {
            $this->setProperty("bondMarketValue", $bondMarketValue, Lambdas::checkIfPositive());
        }

        /**
         * @return mixed
         */
        public function getBondMarketValue()
        {
            return $this->bondMarketValue;
        }

        /**
         * @return string
         */
        public function getApproxBondYTM()
        {
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

        // TODO – add a method for precise bond YTM calculation by means of a polynomial equation
    }
}
