<?php

namespace FinanCalc\Calculators {

    use FinanCalc\Interfaces\Calculator\BondCalculatorAbstract;
    use FinanCalc\Utils\Lambdas;
    use FinanCalc\Utils\MathFuncs;


    /**
     * Class BondDurationCalculator
     * @package FinanCalc\Calculators
     */
    class BondDurationCalculator extends BondCalculatorAbstract
    {

        // annual yield of the bond
        protected $bondAnnualYield;

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
            "bondAnnualCouponRate",
            "bondAnnualYield",
            "bondYearsToMaturity",
            "bondPaymentFrequency",
            "bondYieldPerPaymentPeriod",
            "bondNominalCashFlows",
            "bondDiscountedCashFlows",
            "bondPresentValue",
            "bondDuration"
        ];

        /**
         * @param $bondFaceValue
         * @param $bondAnnualCouponRate
         * @param $bondAnnualYield
         * @param $bondYearsToMaturity
         * @param $bondPaymentFrequency
         */
        public function __construct(
            $bondFaceValue,
            $bondAnnualCouponRate,
            $bondAnnualYield,
            $bondYearsToMaturity,
            $bondPaymentFrequency = 1
        ) {
            $this->setBondFaceValue($bondFaceValue);
            $this->setBondAnnualCouponRate($bondAnnualCouponRate);
            $this->setBondAnnualYield($bondAnnualYield);
            $this->setBondYearsToMaturity($bondYearsToMaturity);
            $this->setBondPaymentFrequency($bondPaymentFrequency);
        }

        /**
         * @param $bondAnnualYield
         */
        public function setBondAnnualYield($bondAnnualYield)
        {
            $this->setProperty("bondAnnualYield", $bondAnnualYield, Lambdas::checkIfPositive());
        }

        /**
         * @return mixed
         */
        public function getBondAnnualYield()
        {
            return $this->bondAnnualYield;
        }

        /**
         * @return string
         */
        public function getBondYieldPerPaymentPeriod()
        {
            return MathFuncs::div($this->bondAnnualYield, $this->bondPaymentFrequency);
        }

        /**
         * @return array
         */
        public function getBondNominalCashFlows()
        {
            // nominal cash flows = coupons each period + face value in the last period
            $numberOfPayments = $this->getBondNoOfPayments();
            $couponPayment = $this->getCouponPayment();

            $nominalCashFlows = array();
            for ($i = 1; $i <= $numberOfPayments; $i++) {
                if ($i == $numberOfPayments) {
                    $nominalCashFlows[$i] = MathFuncs::add($couponPayment, $this->bondFaceValue);
                } else {
                    $nominalCashFlows[$i] = $couponPayment;
                }
            }

            return $nominalCashFlows;
        }

        /**
         * @return array
         */
        public function getBondDiscountedCashFlows()
        {
            // discounted cash flows = nominal cash flows discounted by the means of yield
            $discountFactor = MathFuncs::div(1, MathFuncs::add(1, $this->getBondYieldPerPaymentPeriod()));

            $nominalCashFlows = $this->getBondNominalCashFlows();
            $discountedCashFlows = array();
            $i = 1;
            foreach ($nominalCashFlows as $nominalCashFlowEntry) {
                $discountedCashFlows[] = MathFuncs::mul(
                    $nominalCashFlowEntry,
                    MathFuncs::pow(
                        $discountFactor,
                        $i++)
                );
            }

            return $discountedCashFlows;
        }

        /**
         * @return float
         */
        public function getBondPresentValue()
        {
            // bond present value = sum of all discounted cash flows during the life of the bond
            $presentValue = 0;
            foreach ($this->getBondDiscountedCashFlows() as $discountedCashFlowEntry) {
                $presentValue = MathFuncs::add($presentValue, $discountedCashFlowEntry);
            }

            return $presentValue;
        }

        /**
         * @return string
         */
        public function getBondDuration()
        {
            // duration of the bond = sum of auxiliary values of all periods / bond present value
            // auxiliary value for a period = discounted cash flow in the period * number of the period
            $auxiliaryValue = 0;
            $i = 1;
            foreach ($this->getBondDiscountedCashFlows() as $discountedCashFlowEntry) {
                $auxiliaryValue = MathFuncs::add(
                    $auxiliaryValue,
                    MathFuncs::mul(
                        $discountedCashFlowEntry,
                        $i++)
                );
            }

            $duration = MathFuncs::div($auxiliaryValue, $this->getBondPresentValue());

            return $duration;
        }
    }
}
