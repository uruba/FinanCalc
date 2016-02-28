<?php

namespace FinanCalc\Calculators {

    use Exception;
    use FinanCalc\Interfaces\Calculator\CalculatorAbstract;
    use FinanCalc\Utils\Lambdas;
    use FinanCalc\Utils\MathFuncs;
    use FinanCalc\Utils\Time\TimeSpan;
    use FinanCalc\Utils\Time\TimeUtils;

    /**
     * Class SimpleInterestCalculator
     * @package FinanCalc\Calculators
     */
    class SimpleInterestCalculator extends CalculatorAbstract
    {
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
        public function __construct(
            $principal,
            $annualInterestRate,
            TimeSpan $time
        ) {
            $this->setPrincipal($principal);
            $this->setAnnualInterestRate($annualInterestRate);
            $this->setTime($time);
        }

        /**
         * @param $principal
         */
        public function setPrincipal($principal)
        {
            $this->setProperty("principal", $principal, Lambdas::checkIfPositive());
        }

        /**
         * @param $annualInterestRate
         */
        public function setAnnualInterestRate($annualInterestRate)
        {
            $this->setProperty("annualInterestRate", $annualInterestRate, Lambdas::checkIfPositive());
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
        public function getPrincipal()
        {
            return $this->principal;
        }

        /**
         * @return string
         */
        public function getAnnualInterestRate()
        {
            return $this->annualInterestRate;
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
        public function getInterestNumber()
        {
            return MathFuncs::div(
                MathFuncs::mul(
                    $this->principal,
                    $this->getTimeInDays()
                ),
                100
            );
        }

        /**
         * @return string
         * @throws Exception
         */
        public function getInterestDivisor()
        {
            return MathFuncs::div(
                TimeUtils::getCurrentDayCountConvention()['days_in_a_year'],
                MathFuncs::mul(
                    $this->annualInterestRate,
                    100
                )
            );
        }

        /**
         * @return string
         */
        public function getInterestAmount()
        {
            // n = P*i*t = IN/ID
            return MathFuncs::div(
                $this->getInterestNumber(),
                $this->getInterestDivisor()
            );
        }
    }
}
