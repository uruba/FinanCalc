<?php

namespace FinanCalc\Calculators {

    use DateTime;
    use FinanCalc\Interfaces\Calculator\CalculatorAbstract;
    use FinanCalc\Utils\Lambdas;
    use FinanCalc\Utils\MathFuncs;
    use FinanCalc\Utils\Time\TimeSpan;
    use FinanCalc\Utils\Time\TimeUtils;

    /**
     * Class DebtAmortizator
     * @package FinanCalc\Calculators
     */
    class DebtAmortizator extends CalculatorAbstract
    {
        /** @var  RepaymentInstance[] */
        // list of individual debt's repayments as an array of RepaymentInstance objects
        protected $debtRepayments;

        // principal of the debt = 'PV'
        protected $debtPrincipal;
        // number of periods pertaining to the interest compounding = 'n'
        protected $debtNoOfCompoundingPeriods;
        // length of a single period in days
        /** @var  TimeSpan */
        protected $debtPeriodLength;
        // the interest rate by which the unpaid balance is multiplied (i.e., a decimal number) = 'i'
        protected $debtInterest;

        // props returned by the getResultAsArray method by default
        protected $propResultArray = [
            "debtPrincipal",
            "debtNoOfCompoundingPeriods",
            "debtPeriodLength" =>
                [
                    "years" => "debtPeriodLengthInYears",
                    "months" => "debtPeriodLengthInMonths",
                    "days" => "debtPeriodLengthInDays"
                ],
            "debtInterest",
            "debtDiscountFactor",
            "debtLength" =>
                [
                    "years" => "debtLengthInYears",
                    "months" => "debtLengthInMonths",
                    "days" => "debtLengthInDays"
                ],
            "debtSingleRepayment",
            "debtRepayments" => "debtRepaymentsAsArrays"
        ];

        /**
         * @param $debtPrincipal
         * @param $debtNoOfCompoundingPeriods
         * @param TimeSpan $debtPeriodLength
         * @param $debtInterest
         */
        public function __construct(
            $debtPrincipal,
            $debtNoOfCompoundingPeriods,
            TimeSpan $debtPeriodLength,
            $debtInterest
        ) {
            $this->setDebtPrincipalWithoutRecalculation($debtPrincipal);
            $this->setDebtNoOfCompoundingPeriodsWithoutRecalculation($debtNoOfCompoundingPeriods);
            $this->setDebtPeriodLength($debtPeriodLength);
            $this->setDebtInterestWithoutRecalculation($debtInterest);
            $this->calculateDebtRepayments();
        }

        /**
         * @param $debtPrincipal
         */
        private function setDebtPrincipalWithoutRecalculation($debtPrincipal)
        {
            $this->setProperty("debtPrincipal", $debtPrincipal, Lambdas::checkIfPositive());
        }

        /**
         * @param $debtNoOfCompoundingPeriods
         */
        private function setDebtNoOfCompoundingPeriodsWithoutRecalculation($debtNoOfCompoundingPeriods)
        {
            $this->setProperty("debtNoOfCompoundingPeriods", $debtNoOfCompoundingPeriods, Lambdas::checkIfPositive());
        }

        /**
         * @param $debtInterest
         */
        private function setDebtInterestWithoutRecalculation($debtInterest)
        {
            $this->setProperty("debtInterest", $debtInterest, Lambdas::checkIfPositive());
        }

        /**
         * @param $debtPrincipal
         */
        public function setDebtPrincipal($debtPrincipal)
        {
            $this->setDebtPrincipalWithoutRecalculation($debtPrincipal);
            $this->calculateDebtRepayments();
        }

        /**
         * @param $debtNoOfCompoundingPeriods
         */
        public function setDebtNoOfCompoundingPeriods($debtNoOfCompoundingPeriods)
        {
            $this->setDebtNoOfCompoundingPeriodsWithoutRecalculation($debtNoOfCompoundingPeriods);
            $this->calculateDebtRepayments();
        }

        /**
         * @param $debtPeriodLength
         */
        public function setDebtPeriodLength(TimeSpan $debtPeriodLength)
        {
            $this->setProperty("debtPeriodLength", $debtPeriodLength, Lambdas::checkIfPositive());
        }

        /**
         * @param $debtInterest
         */
        public function setDebtInterest($debtInterest)
        {
            $this->setDebtInterestWithoutRecalculation($debtInterest);
            $this->calculateDebtRepayments();
        }

        /**
         * Private function populating the $debtRepayments array which represents the amortization schedule
         * constructed on basis of the initial parameters passed to the constructor
         */
        private function calculateDebtRepayments()
        {
            $this->debtRepayments = array();
            $unpaidBalance = $this->debtPrincipal;

            // calculate each repayment (more precisely its interest/principal components) and add it to the array
            // storing the debt repayments (i.e., representing the amortization schedule)
            // NOTE: rounding to two decimal places takes place when calculating the interest and principal parts
            // of a single repayment
            for ($i = 1; $i <= $this->debtNoOfCompoundingPeriods; $i++) {
                $interestAmount = MathFuncs::mul($this->debtInterest, $unpaidBalance);
                $principalAmount = MathFuncs::sub($this->getDebtSingleRepayment(), $interestAmount);

                $this->debtRepayments[$i] = new RepaymentInstance($principalAmount, $interestAmount);

                $unpaidBalance = MathFuncs::sub($unpaidBalance, $principalAmount);
            }
        }

        /**
         * @return string [Value of the debt principal as a string]
         */
        public function getDebtPrincipal()
        {
            return $this->debtPrincipal;
        }

        /**
         * @return string [Number of the debt's compounding periods as a string]
         */
        public function getDebtNoOfCompoundingPeriods()
        {
            return $this->debtNoOfCompoundingPeriods;
        }

        /**
         * @return TimeSpan
         */
        public function getDebtPeriodLength()
        {
            return $this->debtPeriodLength;
        }

        /**
         * @return string [Length of each of the debt's compounding periods in years as a string]
         */
        public function getDebtPeriodLengthInYears()
        {
            return $this->debtPeriodLength->toYears();
        }

        /**
         * @return string [Length of each of the debt's compounding periods in months as a string]
         */
        public function getDebtPeriodLengthInMonths()
        {
            return $this->debtPeriodLength->toMonths();
        }

        /**
         * @return string [Length of each of the debt's compounding periods in days as a string]
         */
        public function getDebtPeriodLengthInDays()
        {
            return $this->debtPeriodLength->toDays();
        }

        /**
         * @return string [Value of the debt's interest in a decimal number 'multiplier' form as a string]
         */
        public function getDebtInterest()
        {
            return $this->debtInterest;
        }

        /**
         * @return string [Value of the debt's discount factor as a string]
         */
        public function getDebtDiscountFactor()
        {
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
         * @return string [Length of the debt in years as a string]
         */
        public function getDebtLengthInYears()
        {
            return MathFuncs::div(
                $this->getDebtLengthInDays(),
                TimeUtils::getCurrentDayCountConvention()['days_in_a_year']
            );
        }

        /**
         * @return string [Length of the debt in months as a string]
         */
        public function getDebtLengthInMonths()
        {
            return MathFuncs::div(
                $this->getDebtLengthInDays(),
                TimeUtils::getCurrentDayCountConvention()['days_in_a_month']
            );
        }

        /**
         * @return string [Length of the debt in years as a string]
         */
        public function getDebtLengthInDays()
        {
            return MathFuncs::mul(
                $this->debtNoOfCompoundingPeriods,
                $this->debtPeriodLength->toDays()
            );
        }

        /**
         * @param DateTime $startDate [The start date of the debt]
         * @return DateTime [The end date of the debt]
         */
        public function getDebtEndDate(DateTime $startDate)
        {
            return TimeSpan
                ::asDurationWithStartDate($startDate, 0, 0, (int)$this->getDebtLengthInDays())
                ->getEndDate();
        }

        /**
         * @return string [Value of a single debt repayment instance as a string]
         */
        public function getDebtSingleRepayment()
        {
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
         * @return RepaymentInstance[] [Array of individual debt repayments (RepaymentInstances)]
         */
        public function getDebtRepayments()
        {
            return $this->debtRepayments;
        }

        /**
         * @return array
         */
        public function getDebtRepaymentsAsArrays()
        {
            $repayments = array();
            $i = 1;
            foreach ($this->debtRepayments as $repayment) {
                $repayments[$i++] = [
                    "principalAmount" => $repayment->getPrincipalAmount(),
                    "interestAmount" => $repayment->getInterestAmount(),
                    "totalAmount" => $repayment->getTotalAmount()
                ];
            }

            return $repayments;
        }

    }

    /**
     * Class RepaymentInstance
     * @package FinanCalc\Calculators\DebtAmortizator
     */
    class RepaymentInstance
    {
        // the "principal" part of the individual repayment instance
        private $principalAmount;
        // the "interest" part of the individual repayment instance
        private $interestAmount;

        /**
         * @param string $principalAmount [Value of the amount of the payment's 'principal part' as a string]
         * @param string $interestAmount [Value of the amount of the payment's 'interest part' as a string]
         */
        public function __construct($principalAmount, $interestAmount)
        {
            $this->principalAmount = $principalAmount;
            $this->interestAmount = $interestAmount;
        }

        /**
         * @return string [Value of the amount of the payment's 'principal part' as a string]
         */
        public function getPrincipalAmount()
        {
            return $this->principalAmount;
        }

        /**
         * @return string [Value of the amount of the payment's 'interest part' as a string]
         */
        public function getInterestAmount()
        {
            return $this->interestAmount;
        }

        /**
         * @return string [Value of the total amount that the payment represents as a string]
         */
        public function getTotalAmount()
        {
            return MathFuncs::add($this->principalAmount, $this->interestAmount);
        }
    }
}
