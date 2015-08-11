<?php

namespace FinanCalc\Calculators {

    use FinanCalc\Calculators\BondFairValueCalculator\BondInstance;
    use FinanCalc\Interfaces\CalculatorInterface;

    /**
     * Class BondFairValueCalculator
     * @package FinanCalc\Calculators
     */
    class BondFairValueCalculator implements CalculatorInterface {
        private $bondInstance;

        /**
         * @param $bondFaceValue
         * @param $bondAnnualCouponRate
         * @param $bondVIR
         * @param $bondYearsToMaturity
         * @param int $bondPaymentFrequency
         */
        function __construct($bondFaceValue,
                             $bondAnnualCouponRate,
                             $bondVIR,
                             $bondYearsToMaturity,
                             $bondPaymentFrequency = 1) {
            $this->bondInstance = new BondInstance($bondFaceValue,
                $bondAnnualCouponRate,
                $bondVIR,
                $bondYearsToMaturity,
                $bondPaymentFrequency);
        }

        /**
         * @return BondInstance
         */
        public function getResult() {
            return $this->bondInstance;
        }
    }
}

namespace FinanCalc\Calculators\BondFairValueCalculator {

    use FinanCalc\Calculators\AnnuityCalculator;
    use FinanCalc\Interfaces\BondInstanceAbstract;
    use FinanCalc\Utils\Helpers;
    use FinanCalc\Utils\MathFuncs;

    /**
     * Class BondInstance
     * @package FinanCalc\Calculators\BondFairValueCalculator
     */
    class BondInstance extends BondInstanceAbstract {

        // valuation interest rate of the bond = 'i'
        private $bondVIR;

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
         * @param $bondVIR
         * @param $bondYearsToMaturity
         * @param $bondPaymentFrequency
         */
        function __construct($bondFaceValue,
                             $bondAnnualCouponRate,
                             $bondVIR,
                             $bondYearsToMaturity,
                             $bondPaymentFrequency) {
            $this->setBondFaceValue($bondFaceValue);
            $this->setBondAnnualCouponRate($bondAnnualCouponRate);
            $this->setBondVIR($bondVIR);
            $this->setBondYearsToMaturity($bondYearsToMaturity);
            $this->setBondPaymentFrequency($bondPaymentFrequency);
        }

        /**
         * @param $bondVIR
         */
        public function setBondVIR($bondVIR) {
            if(Helpers::checkIfPositiveNumberOrThrowAnException($bondVIR)) {
                $this->bondVIR = $bondVIR;
            }
        }

        /**
         * @return mixed
         */
        public function getBondVIR() {
            return $this->bondVIR;
        }

        /**
         * @return float
         */
        public function getBondFairValue() {
            // we need to get the coupon rate per payment period = c/payment frequency
            $couponRateForPeriod = MathFuncs::div(
                $this->bondAnnualCouponRate,
                $this->bondPaymentFrequency
            );

            // similarly, we need to calculate the VIR per payment period = i/payment frequency
            $VIRForPeriod = MathFuncs::div(
                $this->bondVIR,
                $this->bondPaymentFrequency
            );

            // we also save the bond's number of payments to an auxillary variable
            $bondNoOfPayments = $this->getBondNoOfPayments();

            // next, we also need the present value of the unit annuity pertaining to the bond, in arrears
            $PVofUnitBondAnnuity =
                MathFuncs::div(
                    MathFuncs::sub(
                        1,
                        Mathfuncs::pow(
                            MathFuncs::div(
                                1,
                                MathFuncs::add(
                                    1,
                                    $VIRForPeriod
                                )
                            ),
                            $bondNoOfPayments
                        )
                    ),
                    $VIRForPeriod
                );

            // now we can use the formula to calculate the real value of the bond (i.e., the present value of its payments)
            // PV = F*[c*PVofUnitBondAnnuity+1/((1+i)^n)]

            $fairValue =
                MathFuncs::mul(
                    $this->bondFaceValue,
                    MathFuncs::add(
                        MathFuncs::mul(
                            $couponRateForPeriod,
                            $PVofUnitBondAnnuity
                        ),
                        MathFuncs::div(
                            1,
                            MathFuncs::pow(
                                MathFuncs::add(
                                    1,
                                    $VIRForPeriod
                                ),
                                $bondNoOfPayments
                            )
                        )
                    )
                );

            return $fairValue;
        }
    }
}