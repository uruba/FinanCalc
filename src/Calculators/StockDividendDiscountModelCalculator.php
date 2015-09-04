<?php

namespace FinanCalc\Calculators {

    use Exception;
    use FinanCalc\Constants\StockDDMTypes;
    use FinanCalc\Interfaces\Calculator\CalculatorAbstract;
    use FinanCalc\Utils\Helpers;
    use FinanCalc\Utils\MathFuncs;
    use InvalidArgumentException;

    /**
     * Class StockDividendDiscountModelCalculator
     * @package FinanCalc\Calculators
     */
    class StockDividendDiscountModelCalculator extends CalculatorAbstract {

        // the type of the dividend discount model according to which the result will be calculated
        private $dividendDiscountModelType;
        // stock's valuation interest rate
        private $stockVIR;
        // absolute value of the stock's annual dividends
        private $stockAnnualDividendsValue;
        // the rate by which the stock's annual dividends are annually multiplied (i.e., a decimal number between 0 and 1)
        // this value applies only to the multiple growth dividend discount model
        private $stockAnnualDividendsGrowth;

        // props returned by the getResultAsArray method by default
        protected $propResultArray = [
            "dividendDiscountModelType",
            "stockVIR",
            "stockAnnualDividendsValue",
            "stockAnnualDividendsGrowth",
            "stockPresentValue"
        ];

        /**
         * @param StockDDMTypes $dividendDiscountModelType
         * @param $stockVIR
         * @param $stockAnnualDividendValue
         * @param null $stockAnnualDividendsGrowth
         */
        function __construct(StockDDMTypes $dividendDiscountModelType,
                             $stockVIR,
                             $stockAnnualDividendValue,
                             $stockAnnualDividendsGrowth = null) {
            $this->setDividendDiscountModelType($dividendDiscountModelType);
            $this->setStockVIR($stockVIR);
            $this->setStockAnnualDividendsValue($stockAnnualDividendValue);
            $this->setStockAnnualDividendsGrowth($stockAnnualDividendsGrowth);
        }

        /**
         * @param $stockVIR
         */
        public function setStockVIR($stockVIR){
            if (Helpers::checkIfPositiveNumberOrThrowAnException($stockVIR)) {
                $this->stockVIR = $stockVIR;
            }
        }

        /**
         * @param $stockAnnualDividendsValue
         */
        public function setStockAnnualDividendsValue($stockAnnualDividendsValue) {
            if (Helpers::checkIfPositiveNumberOrThrowAnException($stockAnnualDividendsValue)) {
                $this->stockAnnualDividendsValue = $stockAnnualDividendsValue;
            }
        }

        /**
         * @param $stockAnnualDividendsGrowth
         */
        public function setStockAnnualDividendsGrowth($stockAnnualDividendsGrowth) {
            $dividendDiscountModelType = $this->dividendDiscountModelType->getValue();

            if ($dividendDiscountModelType == StockDDMTypes::ZERO_GROWTH
                &&
                $stockAnnualDividendsGrowth !== null
            ) {
                throw new InvalidArgumentException('You cannot set the $stockAnnualDividendsGrowth on the zero-growth type discount dividend model calculator!');
            }

            if ($dividendDiscountModelType == StockDDMTypes::MULTIPLE_GROWTH) {
                if (Helpers::checkIfPositiveNumberOrThrowAnException($stockAnnualDividendsGrowth)) {
                    Helpers::checkIfLeftOperandGreaterOrThrowAnEception(
                        $this->stockVIR,
                        $stockAnnualDividendsGrowth,
                        "The stock's valuation interest rate has to be higher than the stock's annual dividend growth"
                    );
                }
            }

            $this->stockAnnualDividendsGrowth = $stockAnnualDividendsGrowth;
        }

        /**
         * @param StockDDMTypes $dividendDiscountModelType
         */
        public function setDividendDiscountModelType(StockDDMTypes $dividendDiscountModelType) {
            if (
                $dividendDiscountModelType->getValue() == StockDDMTypes::ZERO_GROWTH
                &&
                $this->stockAnnualDividendsGrowth !== null
            ) {
                $this->stockAnnualDividendsGrowth = null;
            }
            $this->dividendDiscountModelType = $dividendDiscountModelType;
        }

        /**
         * @return mixed
         */
        public function getStockVIR() {
            return $this->stockVIR;
        }

        /**
         * @return mixed
         */
        public function getStockAnnualDividendsValue() {
            return $this->stockAnnualDividendsValue;
        }

        /**
         * @return mixed
         */
        public function getStockAnnualDividendsGrowth() {
            return $this->stockAnnualDividendsGrowth;
        }

        /**
         * @return mixed
         */
        public function getDividendDiscountModelType() {
            return $this->dividendDiscountModelType;
        }


        /**
         * @return null|string
         * @throws Exception
         */
        public function getStockPresentValue() {
            switch ($this->dividendDiscountModelType->getValue()) {
                case StockDDMTypes::ZERO_GROWTH:
                    return MathFuncs::div(
                        $this->stockAnnualDividendsValue,
                        $this->stockVIR
                    );
                case StockDDMTypes::MULTIPLE_GROWTH:
                    if ($this->stockAnnualDividendsGrowth === null) {
                        throw new Exception("You have to set the stockAnnualDividendsGrowth for the multiple growth model!");
                    }
                    return MathFuncs::mul(
                        $this->stockAnnualDividendsValue,
                        MathFuncs::div(
                            MathFuncs::add(
                                1,
                                $this->stockAnnualDividendsGrowth
                            ),
                            MathFuncs::sub(
                                $this->stockVIR,
                                $this->stockAnnualDividendsGrowth
                            )
                        )
                    );
                default:
                    return null;
            }
        }
    }
}