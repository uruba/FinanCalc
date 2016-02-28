<?php

namespace FinanCalc\Interfaces\Calculator {

    use FinanCalc\Utils\Helpers;
    use FinanCalc\Utils\MathFuncs;

    /**
     * Class BondInstanceAbstract
     * @package FinanCalc\Interfaces
     */
    abstract class BondCalculatorAbstract extends CalculatorAbstract
    {
        // face value of the bond = 'F'
        protected $bondFaceValue;
        // coupon rate of the bond per annum = 'c'
        protected $bondAnnualCouponRate;
        // number of years to the maturity of the bond
        protected $bondYearsToMaturity;
        // frequency of bond payments (expressed in a divisor of 12 months ~ 1 year)
        // e.g.: divisor 2 means semi-annual payments
        protected $bondPaymentFrequency;

        /**
         * @param $bondFaceValue
         */
        public function setBondFaceValue($bondFaceValue)
        {
            if (Helpers::checkIfPositiveNumberOrThrowAnException($bondFaceValue)) {
                $this->setProperty("bondFaceValue", $bondFaceValue);
            }
        }

        /**
         * @param $bondAnnualCouponRate
         */
        public function setBondAnnualCouponRate($bondAnnualCouponRate)
        {
            if (Helpers::checkIfPositiveNumberOrThrowAnException($bondAnnualCouponRate)) {
                $this->setProperty("bondAnnualCouponRate", $bondAnnualCouponRate);
            }
        }

        /**
         * @param $bondYearsToMaturity
         */
        public function setBondYearsToMaturity($bondYearsToMaturity)
        {
            if (Helpers::checkIfPositiveNumberOrThrowAnException($bondYearsToMaturity)) {
                $this->setProperty("bondYearsToMaturity", $bondYearsToMaturity);
            }
        }

        /**
         * @param $bondPaymentFrequency
         */
        public function setBondPaymentFrequency($bondPaymentFrequency)
        {
            if (Helpers::checkIfPositiveNumberOrThrowAnException($bondPaymentFrequency)) {
                $this->setProperty("bondPaymentFrequency", $bondPaymentFrequency);
            }
        }

        /**
         * @return mixed
         */
        public function getBondFaceValue()
        {
            return $this->bondFaceValue;
        }

        /**
         * @return mixed
         */
        public function getBondAnnualCouponRate()
        {
            return $this->bondAnnualCouponRate;
        }

        /**
         * @return mixed
         */
        public function getBondYearsToMaturity()
        {
            return $this->bondYearsToMaturity;
        }

        /**
         * @return mixed
         */
        public function getBondPaymentFrequency()
        {
            return $this->bondPaymentFrequency;
        }

        /**
         * @return float
         */
        public function getCouponPayment()
        {
            return ($this->bondAnnualCouponRate / $this->bondPaymentFrequency) * $this->bondFaceValue;
        }

        /**
         * @return int
         */
        public function getBondNoOfPayments()
        {
            // number of payments during the duration of the bond (up to the moment of its maturity)
            // is calculated from the number of years of the duration of the bond
            // multiplied by the number of payments per year (i.e., payment frequency)
            //, floored (to eliminate the last remaining incomplete due period)
            return intval(floor(MathFuncs::mul(
                $this->bondYearsToMaturity,
                $this->bondPaymentFrequency
            )));
        }
    }
}
