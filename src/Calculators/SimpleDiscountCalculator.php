<?php

namespace FinanCalc\Calculators {

    use FinanCalc\Interfaces\Calculator\CalculatorAbstract;
    use FinanCalc\Utils\Lambdas;
    use FinanCalc\Utils\MathFuncs;
    use FinanCalc\Utils\Time\TimeSpan;

    /**
     * Class SimpleDiscountCalculator
     * @package FinanCalc\Calculators
     */
    class SimpleDiscountCalculator extends CalculatorAbstract
    {
        // amount due = 'S'
        protected $amountDue;
        // annual discount rate = 'd'
        protected $annualDiscountRate;
        // the time, which converted to years = 't'
        /** @var  TimeSpan */
        protected $time;

        /**
         * @param $amountDue
         * @param $annualDiscountRate
         * @param TimeSpan $time
         */
        public function __construct(
            $amountDue,
            $annualDiscountRate,
            TimeSpan $time
        ) {
            $this->setAmountDue($amountDue);
            $this->setAnnualDiscountRate($annualDiscountRate);
            $this->setTime($time);
        }

        /**
         * @param $amountDue
         */
        public function setAmountDue($amountDue)
        {
            $this->setProperty("amountDue", $amountDue, Lambdas::checkIfPositive());
        }

        /**
         * @param $annualDiscountRate
         */
        public function setAnnualDiscountRate($annualDiscountRate)
        {
            $this->setProperty("annualDiscountRate", $annualDiscountRate, Lambdas::checkIfPositive());
        }

        /**
         * @param TimeSpan $time
         */
        public function setTime(TimeSpan $time)
        {
            $this->setProperty("time", $time, Lambdas::checkIfPositive());
        }

        /**
         * @return string
         */
        public function getAmountDue()
        {
            return $this->amountDue;
        }

        /**
         * @return string
         */
        public function getAnnualDiscountRate()
        {
            return $this->annualDiscountRate;
        }

        /**
         * @return TimeSpan
         */
        public function getTime()
        {
            return $this->time;
        }

        /**
         * @return string
         */
        public function getTimeInYears()
        {
            return $this->time->toYears();
        }

        /**
         * @return string
         */
        public function getTimeInMonths()
        {
            return $this->time->toMonths();
        }

        /**
         * @return string
         */
        public function getTimeInDays()
        {
            return $this->time->toDays();
        }

        /**
         * @return string
         */
        public function getDiscountAmount()
        {
            // D = S*d*t
            return MathFuncs::mul(
                $this->amountDue,
                MathFuncs::mul(
                    $this->annualDiscountRate,
                    $this->getTimeInYears()
                )
            );
        }
    }
}
