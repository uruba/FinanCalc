<?php

namespace FinanCalc\Calculators {

    use FinanCalc\Interfaces\Calculator\CalculatorAbstract;
    use FinanCalc\Utils\Helpers;
    use FinanCalc\Utils\MathFuncs;

    /**
     * Class StockInvestmentRatiosCalculator
     * @package FinanCalc\Calculators
     */
    class StockInvestmentRatiosCalculator extends CalculatorAbstract {

        // sum of dividends per a period
        private $totalDividends;
        // amount earned after taxes
        private $earningsAfterTaxes;
        // number of stocks (total if constant, average if fluctuating)
        private $noOfStocks;

        // props returned by the getResultAsArray method by default
        protected $propResultArray = [
                "totalDividends",
                "earningsAfterTaxes",
                "noOfStocks",
                "dividendPerStock",
                "earningsPerStock",
                "payoutRatio",
                "dividendRatio",
                "retentionRatio"
        ];

        /**
         * @param $totalDividends
         * @param $earningsAfterTaxes
         * @param $noOfStocks
         */
        function __construct($totalDividends,
                             $earningsAfterTaxes,
                             $noOfStocks) {
            $this->setTotalDividends($totalDividends);
            $this->setEarningsAfterTaxes($earningsAfterTaxes);
            $this->setNoOfStocks($noOfStocks);
        }

        /**
         * @param $totalDividends
         */
        public function setTotalDividends($totalDividends) {
            if (Helpers::checkIfPositiveNumberOrThrowAnException($totalDividends)) {
                $this->totalDividends = (string)$totalDividends;
            }
        }

        /**
         * @param $earningsAfterTaxes
         */
        public function setEarningsAfterTaxes($earningsAfterTaxes) {
            if (Helpers::checkIfPositiveNumberOrThrowAnException($earningsAfterTaxes)) {
                $this->earningsAfterTaxes = (string)$earningsAfterTaxes;
            }
        }

        /**
         * @param $noOfStocks
         */
        public function setNoOfStocks($noOfStocks) {
            if (Helpers::checkIfPositiveNumberOrThrowAnException($noOfStocks)) {
                $this->noOfStocks = (string)$noOfStocks;
            }
        }

        /**
         * @return mixed
         */
        public function getTotalDividends() {
            return $this->totalDividends;
        }

        /**
         * @return mixed
         */
        public function getEarningsAfterTaxes() {
            return $this->earningsAfterTaxes;
        }

        /**
         * @return mixed
         */
        public function getNoOfStocks() {
            return $this->noOfStocks;
        }

        /**
         * @return string
         */
        public function getDividendPerStock() {
            return MathFuncs::div(
                $this->totalDividends,
                $this->noOfStocks
            );
        }

        /**
         * @return string
         */
        public function getEarningsPerStock() {
            return MathFuncs::div(
                $this->earningsAfterTaxes,
                $this->noOfStocks
            );
        }

        /**
         * @return string
         */
        public function getPayoutRatio() {
            return MathFuncs::div(
                $this->getDividendPerStock(),
                $this->getEarningsPerStock()
            );
        }

        /**
         * @return string
         */
        public function getDividendRatio() {
            return MathFuncs::div(
                $this->getEarningsPerStock(),
                $this->getDividendPerStock()
            );
        }

        /**
         * @return string
         */
        public function getRetentionRatio() {
            return MathFuncs::sub(
                1,
                $this->getPayoutRatio()
            );
        }

    }
}