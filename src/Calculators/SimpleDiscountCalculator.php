<?php

namespace FinanCalc\Calculators {

    use FinanCalc\Interfaces\Calculator\CalculatorAbstract;
    use FinanCalc\Utils\MathFuncs;
    use FinanCalc\Utils\Time\TimeSpan;

    /**
     * Class SimpleDiscountCalculator
     * @package FinanCalc\Calculators
     */
    class SimpleDiscountCalculator extends CalculatorAbstract {
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
        function __construct($amountDue,
                             $annualDiscountRate,
                             TimeSpan $time) {

        }

        /**
         * @param $amountDue
         */
        public function setAmountDue($amountDue) {
            $this->setProperty("amountDue", $amountDue, $GLOBALS["FINANCALC_FUNC_CHECK_IF_POSITIVE"]);
        }

        /**
         * @param $annualDiscountRate
         */
        public function setAnnualDiscountRate($annualDiscountRate) {
            $this->setProperty("annualDiscountRate", $annualDiscountRate, $GLOBALS["FINANCALC_FUNC_CHECK_IF_POSITIVE"]);
        }

        /**
         * @param TimeSpan $time
         */
        public function setTime(TimeSpan $time) {
            $this->setProperty("time", $time, $GLOBALS["FINANCALC_FUNC_CHECK_IF_POSITIVE"]);
        }

        /**
         * @return string
         */
        public function getAmountDue() {
            return $this->amountDue;
        }

        /**
         * @return string
         */
        public function getAnnualDiscountRate() {
            return $this->annualDiscountRate;
        }

        /**
         * @return TimeSpan
         */
        public function getTime() {
            return $this->time;
        }

        /**
         * @return string
         */
        public function getTimeInYears() {
            return $this->time->toYears();
        }

        /**
         * @return string
         */
        public function getTimeInMonths() {
            return $this->time->toMonths();
        }

        /**
         * @return string
         */
        public function getTimeInDays() {
            return $this->time->toDays();
        }

        /**
         * @return string
         */
        public function getDiscountAmount() {
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