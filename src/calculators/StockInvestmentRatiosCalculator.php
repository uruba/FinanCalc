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

        /**
         * @param $totalDividends
         * @param $earningAfterTaxes
         * @param $noOfStocks
         */
        function __construct($totalDividends,
                             $earningAfterTaxes,
                             $noOfStocks) {
            $this->setTotalDividends($totalDividends);
            $this->setEarningsAfterTaxes($earningAfterTaxes);
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
            return $this->totalDividends;
        }

        /**
         * @return mixed
         */
        public function getNoOfStocks() {
            return $this->totalDividends;
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

        /**
         * @return array
         */
        public function getResultAsArray()
        {
            return
                [
                    "totalDividends" => $this->getTotalDividends(),
                    "earningsAfterTaxes" => $this->getEarningsAfterTaxes(),
                    "noOfStocks" => $this->getNoOfStocks(),
                    "dividendPerStock" => $this->getDividendPerStock(),
                    "earningsPerStock" => $this->getEarningsPerStock(),
                    "payoutRatio" => $this->getPayoutRatio(),
                    "dividendRatio" => $this->getDividendRatio(),
                    "retentionRatio" => $this->getRetentionRatio()
            ];
        }
    }
}