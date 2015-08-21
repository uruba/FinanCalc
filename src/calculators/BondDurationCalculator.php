<?php

namespace FinanCalc\Calculators {

    use FinanCalc\Calculators\BondDurationCalculator\BondInstance;
    use FinanCalc\Interfaces\CalculatorAbstract;


    /**
     * Class BondDurationCalculator
     * @package FinanCalc\Calculators
     */
    class BondDurationCalculator extends CalculatorAbstract {
        private $bondInstance;


        /**
         * @param $bondFaceValue
         * @param $bondAnnualCouponRate
         * @param $bondAnnualYield
         * @param $bondYearsToMaturity
         * @param int $bondPaymentFrequency
         */
        function __construct($bondFaceValue,
                             $bondAnnualCouponRate,
                             $bondAnnualYield,
                             $bondYearsToMaturity,
                             $bondPaymentFrequency = 1) {
            $this->bondInstance = new BondInstance($bondFaceValue,
                $bondAnnualCouponRate,
                $bondAnnualYield,
                $bondYearsToMaturity,
                $bondPaymentFrequency
                );
        }

        /**
         * @return BondInstance
         */
        public function getResult() {
            return $this->bondInstance;
        }

        /**
         * @return array
         */
        public function getResultAsArray()
        {
            $bondInstance = $this->getResult();

            return
                [
                    "bondFaceValue" => $bondInstance->getBondFaceValue(),
                    "bondAnnualCouponRate" => $bondInstance->getBondAnnualCouponRate(),
                    "bondAnnualYield" => $bondInstance->getBondAnnualYield(),
                    "bondYearsToMaturity" => $bondInstance->getBondYearsToMaturity(),
                    "bondPaymentFrequency" => $bondInstance->getBondPaymentFrequency(),
                    "bondYieldPerPaymentPeriod" => $bondInstance->getBondYieldPerPaymentPeriod(),
                    "bondNominalCashFlows" => $bondInstance->getBondNominalCashFlows(),
                    "bondDiscountedCashFlows" => $bondInstance->getBondDiscountedCashFlows(),
                    "bondPresentValue" => $bondInstance->getBondPresentValue(),
                    "bondDuration" => $bondInstance->getBondDuration()
                ];
        }
    }
}

namespace FinanCalc\Calculators\BondDurationCalculator {

    use FinanCalc\Interfaces\BondInstanceAbstract;
    use FinanCalc\Utils\Helpers;
    use FinanCalc\Utils\MathFuncs;

    /**
     * Class BondInstance
     * @package FinanCalc\Calculators\BondDurationCalculator
     */
    class BondInstance extends BondInstanceAbstract {

        // annual yield of the bond
        private $bondAnnualYield;

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
         * @param $bondAnnualCouponRate
         * @param $bondAnnualYield
         * @param $bondYearsToMaturity
         * @param $bondPaymentFrequency
         */
        function __construct($bondFaceValue,
                             $bondAnnualCouponRate,
                             $bondAnnualYield,
                             $bondYearsToMaturity,
                             $bondPaymentFrequency) {
            $this->setBondFaceValue($bondFaceValue);
            $this->setBondAnnualCouponRate($bondAnnualCouponRate);
            $this->setBondAnnualYield($bondAnnualYield);
            $this->setBondYearsToMaturity($bondYearsToMaturity);
            $this->setBondPaymentFrequency($bondPaymentFrequency);
        }

        /**
         * @param $bondAnnualYield
         */
        public function setBondAnnualYield($bondAnnualYield) {
            if(Helpers::checkIfPositiveNumberOrThrowAnException($bondAnnualYield)) {
                $this->bondAnnualYield = $bondAnnualYield;
            }
        }

        /**
         * @return mixed
         */
        public function getBondAnnualYield() {
            return $this->bondAnnualYield;
        }

        /**
         * @return string
         */
        public function getBondYieldPerPaymentPeriod() {
            return MathFuncs::div($this->bondAnnualYield, $this->bondPaymentFrequency);
        }

        /**
         * @return array
         */
        public function getBondNominalCashFlows() {
            // nominal cash flows = coupons each period + face value in the last period
            $numberOfPayments = $this->getBondNoOfPayments();
            $couponPayment =  $this->getCouponPayment();

            $nominalCashFlows = array();
            for ($i = 1; $i <= $numberOfPayments; $i++) {
                if ($i == $numberOfPayments) {
                    $nominalCashFlows[$i] = $couponPayment + $this->bondFaceValue;
                } else {
                    $nominalCashFlows[$i] = $couponPayment;
                }
            }

            return $nominalCashFlows;
        }

        /**
         * @return array
         */
        public function getBondDiscountedCashFlows() {
            // discounted cash flows = nominal cash flows discounted by the means of yield
            $discountFactor = MathFuncs::div(1, MathFuncs::add(1, $this->getBondYieldPerPaymentPeriod()));

            $nominalCashFlows = $this->getBondNominalCashFlows();
            $discountedCashFlows = array();
            $i = 1;
            foreach ($nominalCashFlows as $nominalCashFlowEntry) {
                $discountedCashFlows[] = MathFuncs::mul($nominalCashFlowEntry, MathFuncs::pow($discountFactor, $i++));
            }

            return $discountedCashFlows;
        }

        /**
         * @return float
         */
        public function getBondPresentValue() {
            // bond present value = sum of all discounted cash flows during the life of the bond
            $presentValue = 0;
            foreach ($this->getBondDiscountedCashFlows() as $discountedCashFlowEntry) {
                $presentValue += $discountedCashFlowEntry;
            }

            return $presentValue;
        }

        /**
         * @return string
         */
        public function getBondDuration() {
            // duration of the bond = sum of auxiliary values of all periods / bond present value
            // auxiliary value for a period = discounted cash flow in the period * number of the period
            $auxiliaryValue = 0;
            $i = 1;
            foreach ($this->getBondDiscountedCashFlows() as $discountedCashFlowEntry) {
                $auxiliaryValue += $discountedCashFlowEntry * $i++;
            }

            $duration = MathFuncs::div($auxiliaryValue, $this->getBondPresentValue());

            return $duration;
        }
    }

}