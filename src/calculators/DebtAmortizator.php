<?php

namespace FinanCalc\Calculators {
    use FinanCalc\Constants\AnnuityPaymentTypes;
    use FinanCalc\Calculators\DebtAmortizator\DebtInstance;
    use FinanCalc\Interfaces\CalculatorInterface;

    /**
     * Class DebtAmortizator
     * @package FinanCalc\Calculators
     */
    class DebtAmortizator implements CalculatorInterface {
        private $debtInstance;

        /**
         * DebtAmortizator constructor
         *
         * @param string $debtPrincipal                [Value of the debt's principal as a string]
         * @param string $debtNoOfCompoundingPeriods   [Number of the debt's compounding periods as a string]
         * @param string $debtInterest                 [Value of the debt's interest in a decimal number 'multiplier' form as a string]
         * @param string $debtPeriodLength             [Length of each of the debt's compounding periods as a string]
         * @param AnnuityPaymentTypes $debtPaymentType [Payment type of the debt]
         */
        function __construct($debtPrincipal,
                             $debtNoOfCompoundingPeriods,
                             $debtPeriodLength,
                             $debtInterest,
                             AnnuityPaymentTypes $debtPaymentType) {

            // create new DebtInstance object passing on the parameters of this constructor
            $this->debtInstance = new DebtInstance($debtPrincipal,
                                                   $debtNoOfCompoundingPeriods,
                                                   $debtPeriodLength,
                                                   $debtInterest,
                                                   $debtPaymentType);
        }

        /**
         * NOTE: Overridden method from the \FinanCalc\Interfaces\CalculatorInterface
         *
         * @return \FinanCalc\Calculators\DebtAmortizator\DebtInstance
         */
        public function getResult() {
            return $this->debtInstance;
        }
    }
}


namespace FinanCalc\Calculators\DebtAmortizator {
    use FinanCalc\Constants\AnnuityPaymentTypes;
    use FinanCalc\Constants\Defaults;
    use FinanCalc\Utils\Helpers;
    use FinanCalc\Utils\MathFuncs;

    /**
     * Class DebtInstance
     * @package FinanCalc\Calculators\DebtAmortizator
     */
    class DebtInstance {
        private $debtRepayments = Array();

        // principal of the debt = 'PV'
        private $debtPrincipal;
        // number of periods pertaining to the interest compounding = 'n'
        private $debtNoOfCompoundingPeriods;
        // length of a single period in days
        private $debtPeriodLength;
        // the interest rate by which the unpaid balance is multiplied (i.e., a decimal number) = 'i'
        private $debtInterest;
        // payment type of the debt
        private $debtPaymentType;

        /**
         * DebtInstance constructor
         *
         * @param string $debtPrincipal                [Value of the debt's principal as a string]
         * @param string $debtNoOfCompoundingPeriods   [Number of the debt's compounding periods as a string]
         * @param string $debtInterest                 [Value of the debt's interest in a decimal number 'multiplier' form as a string]
         * @param string $debtPeriodLength             [Length of each of the debt's compounding periods in days as a string]
         * @param AnnuityPaymentTypes $debtPaymentType [Payment type of the debt]
         * @throws \InvalidArgumentException
         */
        function __construct($debtPrincipal,
                             $debtNoOfCompoundingPeriods,
                             $debtPeriodLength,
                             $debtInterest,
                             AnnuityPaymentTypes $debtPaymentType) {
            $this->setDebtPrincipalWithoutRecalculation($debtPrincipal);
            $this->setDebtNoOfCompoundingPeriodsWithoutRecalculation($debtNoOfCompoundingPeriods);
            $this->setDebtPeriodLength($debtPeriodLength);
            $this->setDebtInterestWithoutRecalculation($debtInterest);
            $this->setDebtPaymentType($debtPaymentType);
            $this->calculateDebtRepayments();
        }

        /**
         * @param $debtPrincipal
         */
        private function setDebtPrincipalWithoutRecalculation($debtPrincipal) {
            if(Helpers::checkIfPositiveNumberOrThrowAnException($debtPrincipal)) {
                $this->debtPrincipal = $debtPrincipal;
            }
        }

        /**
         * @param $debtNoOfCompoundingPeriods
         */
        private function setDebtNoOfCompoundingPeriodsWithoutRecalculation($debtNoOfCompoundingPeriods) {
            if(Helpers::checkIfPositiveNumberOrThrowAnException($debtNoOfCompoundingPeriods)) {
                $this->debtNoOfCompoundingPeriods = $debtNoOfCompoundingPeriods;
            }
        }

        /**
         * @param $debtInterest
         */
        private function setDebtInterestWithoutRecalculation($debtInterest) {
            if(Helpers::checkIfPositiveNumberOrThrowAnException($debtInterest)) {
                $this->debtInterest = $debtInterest;
            }
        }

        /**
         * @param $debtPrincipal
         */
        public function setDebtPrincipal($debtPrincipal) {
            $this->setDebtPrincipalWithoutRecalculation($debtPrincipal);
            $this->calculateDebtRepayments();
        }

        /**
         * @param $debtNoOfCompoundingPeriods
         */
        public function setDebtNoOfCompoundingPeriods($debtNoOfCompoundingPeriods) {
            $this->setDebtNoOfCompoundingPeriodsWithoutRecalculation($debtNoOfCompoundingPeriods);
            $this->calculateDebtRepayments();
        }

        /**
         * @param $debtPeriodLength
         */
        public function setDebtPeriodLength($debtPeriodLength) {
            if(Helpers::checkIfPositiveNumberOrThrowAnException($debtPeriodLength)) {
                $this->debtPeriodLength = $debtPeriodLength;
            }
        }

        /**
         * @param $debtInterest
         */
        public function setDebtInterest($debtInterest) {
            $this->setDebtInterestWithoutRecalculation($debtInterest);
            $this->calculateDebtRepayments();
        }

        /**
         * @param AnnuityPaymentTypes $debtPaymentType
         */
        public function setDebtPaymentType(AnnuityPaymentTypes $debtPaymentType) {
            if(Helpers::checkIfInstanceOfAClassOrThrowAnException($debtPaymentType, AnnuityPaymentTypes::class)) {
                $this->debtPaymentType = $debtPaymentType;
            }
        }

        /**
         * Private function populating the $debtRepayments array which represents the amortization schedule
         * constructed on basis of the initial parameters passed to the constructor
         */
        private function calculateDebtRepayments() {
            $this->debtRepayments = Array();
            $unpaidBalance = $this->debtPrincipal;

            // calculate each repayment (more precisely its interest/principal components) and add it to the array
            // storing the debt repayments (i.e., representing the amortization schedule)
            // NOTE: rounding to two decimal places takes place when calculating the interest and principal parts
            // of a single repayment
            for($i = 1; $i <= $this->debtNoOfCompoundingPeriods; $i++) {
                $interestAmount = Helpers::roundMoneyForDisplay(MathFuncs::mul($this->debtInterest, $unpaidBalance));
                $principalAmount = Helpers::roundMoneyForDisplay(MathFuncs::sub($this->getDebtSingleRepayment(), $interestAmount));

                array_push($this->debtRepayments, new RepaymentInstance($principalAmount, $interestAmount));

                $unpaidBalance = MathFuncs::sub($unpaidBalance, $principalAmount);
            }
        }

        /**
         * @return string [Value of the debt's discount factor as a string]
         */
        public function getDebtDiscountFactor() {
            // discount factor 'v = 1/(1+i)'
            return MathFuncs::div(
                1,
                MathFuncs::add(
                    1,
                    $this->debtInterest
                )
            );

        }

        /**
         * @return string [Value of a single debt repayment instance as a string]
         */
        public function getDebtSingleRepayment() {
            // single repayment 'K = PV/((1-v^n)/i)'
            return MathFuncs::div(
                $this->debtPrincipal,
                MathFuncs::div(
                    MathFuncs::sub(
                        1,
                        MathFuncs::pow(
                            $this->getDebtDiscountFactor(),
                            $this->debtNoOfCompoundingPeriods
                        )
                    ),
                    $this->debtInterest
                )
            );
        }

        /**
         * @return string [Value of the debt principal as a string]
         */
        public function getDebtPrincipal() {
            return $this->debtPrincipal;
        }

        /**
         * @return string [Number of the debt's compounding periods as a string]
         */
        public function getDebtNoOfCompoundingPeriods() {
            return $this->debtNoOfCompoundingPeriods;
        }

        /**
         * @return string [Length of each of the debt's compounding periods in years as a string]
         */
        public function getDebtPeriodLengthInYears() {
            return MathFuncs::div(
                $this->debtPeriodLength,
                Defaults::LENGTH_YEAR_360_30);
        }

        /**
         * @return string [Length of each of the debt's compounding periods in months as a string]
         */
        public function getDebtPeriodLengthInMonths() {
            return MathFuncs::div(
                $this->debtPeriodLength,
                Defaults::LENGTH_MONTH_360_30);
        }

        /**
         * @return string [Length of each of the debt's compounding periods in days as a string]
         */
        public function getDebtPeriodLengthInDays() {
            return $this->debtPeriodLength;
        }

        /**
         * @return string [Duration of the debt in years as a string]
         */
        public function getDebtDurationInYears() {
            return MathFuncs::div(
                MathFuncs::mul(
                    $this->debtNoOfCompoundingPeriods,
                    $this->debtPeriodLength),
                Defaults::LENGTH_YEAR_360_30);
        }

        /**
         * @return string [Duration of the debt in months as a string]
         */
        public function getDebtDurationInMonths() {
            return MathFuncs::div(
                MathFuncs::mul(
                    $this->debtNoOfCompoundingPeriods,
                    $this->debtPeriodLength),
                Defaults::LENGTH_MONTH_360_30);
        }

        /**
         * @return string [Duration of the debt in years as a string]
         */
        public function getDebtDurationInDays() {
            return MathFuncs::div(
                MathFuncs::mul(
                    $this->debtNoOfCompoundingPeriods,
                    $this->debtPeriodLength),
                Defaults::LENGTH_DAY_360_30);
        }

        /**
         * @return string [Value of the debt's interest in a decimal number 'multiplier' form as a string]
         */
        public function getDebtInterest() {
            return $this->debtInterest;
        }

        /**
         * @return Array [Array of individual debt repayments (RepaymentInstances)]
         */
        public function getDebtRepayments() {
            return $this->debtRepayments;
        }

        /**
         * @return AnnuityPaymentTypes [Gets the payment type of the debt]
         */
        public function getDebtPaymentType() {
            return $this->debtPaymentType;
        }
    }

    /**
     * Class RepaymentInstance
     * @package FinanCalc\Calculators\DebtAmortizator
     */
    class RepaymentInstance {
        private $principalAmount, $interestAmount;

        /**
         * @param string $principalAmount [Value of the amount of the payment's 'principal part' as a string]
         * @param string $interestAmount  [Value of the amount of the payment's 'interest part' as a string]
         */
        function __construct($principalAmount, $interestAmount) {
            $this->principalAmount = $principalAmount;
            $this->interestAmount = $interestAmount;
        }

        /**
         * @return string [Value of the amount of the payment's 'principal part' as a string]
         */
        public function getPrincipalAmount() {
            return $this->principalAmount;
        }

        /**
         * @return string [Value of the amount of the payment's 'interest part' as a string]
         */
        public function getInterestAmount() {
            return $this->interestAmount;
        }

        /**
         * @return string [Value of the total amount that the payment represents as a string]
         */
        public function getTotalAmount() {
            return MathFuncs::add($this->principalAmount, $this->interestAmount);
        }
    }


}