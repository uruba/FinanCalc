<?php

namespace FinanCalc\Calculators {

    use FinanCalc\Interfaces\Calculator\CalculatorAbstract;
    use FinanCalc\Utils\MathFuncs;
    use FinanCalc\Utils\Time\TimeSpan;

    /**
     * Class SimpleInterestCalculator
     * @package FinanCalc\Calculators
     */
    class SimpleInterestCalculator extends CalculatorAbstract {
        // amount of principal = 'P'
        protected $principal;
        // annual interest rate = 'i'
        protected $annualInterestRate;
        // the time, which converted to years = 't'
        /** @var  TimeSpan */
        protected $time;

        /**
         * @param $principal
         * @param $annualInterestRate
         * @param TimeSpan $time
         */
        function __construct($principal,
                             $annualInterestRate,
                             TimeSpan $time) {
            $this->setPrincipal($principal);
            $this->setAnnualInterestRate($annualInterestRate);
            $this->setTime($time);
        }

        /**
         * @param $principal
         */
        public function setPrincipal($principal) {
            $this->setProperty("principal", $principal, $GLOBALS["FINANCALC_FUNC_CHECK_IF_POSITIVE"]);
        }

        /**
         * @param $annualInterestRate
         */
        public function setAnnualInterestRate($annualInterestRate) {
            $this->setProperty("annualInterestRate", $annualInterestRate, $GLOBALS["FINANCALC_FUNC_CHECK_IF_POSITIVE"]);
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
        public function getPrincipal() {
            return $this->principal;
        }

        /**
         * @return string
         */
        public function getAnnualInterestRate() {
            return $this->annualInterestRate;
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
        public function getInterestAmount() {
            // n = P*i*t
            return MathFuncs::mul(
                $this->principal,
                MathFuncs::mul(
                    $this->annualInterestRate,
                    $this->getTimeInYears()
                )
            );
        }
    }
}