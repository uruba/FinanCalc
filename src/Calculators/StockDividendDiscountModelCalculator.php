<?php

namespace FinanCalc\Calculators {

    use Exception;
    use FinanCalc\Constants\StockDDMTypes;
    use FinanCalc\Interfaces\Calculator\CalculatorAbstract;
    use FinanCalc\Utils\Helpers;
    use FinanCalc\Utils\Lambdas;
    use FinanCalc\Utils\MathFuncs;
    use FinanCalc\Utils\Strings;
    use InvalidArgumentException;

    /**
     * Class StockDividendDiscountModelCalculator
     * @package FinanCalc\Calculators
     */
    class StockDividendDiscountModelCalculator extends CalculatorAbstract
    {

        /** @var  StockDDMTypes */
        // the type of the dividend discount model according to which the result will be calculated
        protected $dividendDiscountModelType;
        // stock's valuation interest rate
        protected $stockVIR;
        // absolute value of the stock's annual dividends
        protected $stockAnnualDividendsValue;
        // the rate by which the stock's annual dividends grow annually (i.e., a decimal number between 0 and 1)
        // this value applies only to the multiple growth dividend discount model
        protected $stockAnnualDividendsGrowth;

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
        public function __construct(
            StockDDMTypes $dividendDiscountModelType,
            $stockVIR,
            $stockAnnualDividendValue,
            $stockAnnualDividendsGrowth = null
        ) {
            $this->setDividendDiscountModelType($dividendDiscountModelType);
            $this->setStockVIR($stockVIR);
            $this->setStockAnnualDividendsValue($stockAnnualDividendValue);
            $this->setStockAnnualDividendsGrowth($stockAnnualDividendsGrowth);
        }

        /**
         * @param StockDDMTypes $dividendDiscountModelType
         */
        public function setDividendDiscountModelType(StockDDMTypes $dividendDiscountModelType)
        {
            if (
                $dividendDiscountModelType->getValue() == StockDDMTypes::ZERO_GROWTH
                &&
                $this->stockAnnualDividendsGrowth !== null
            ) {
                $this->stockAnnualDividendsGrowth = null;
            }
            $this->setProperty("dividendDiscountModelType", $dividendDiscountModelType);
        }

        /**
         * @param $stockVIR
         */
        public function setStockVIR($stockVIR)
        {
            $this->setProperty("stockVIR", $stockVIR, Lambdas::checkIfPositive());
        }

        /**
         * @param $stockAnnualDividendsValue
         */
        public function setStockAnnualDividendsValue($stockAnnualDividendsValue)
        {
            $this->setProperty("stockAnnualDividendsValue", $stockAnnualDividendsValue, Lambdas::checkIfPositive());
        }

        /**
         * @param $stockAnnualDividendsGrowth
         */
        public function setStockAnnualDividendsGrowth($stockAnnualDividendsGrowth)
        {
            $dividendDiscountModelType = $this->dividendDiscountModelType->getValue();

            if ($dividendDiscountModelType == StockDDMTypes::ZERO_GROWTH
                &&
                $stockAnnualDividendsGrowth !== null
            ) {
                throw new InvalidArgumentException(Strings::getString('message_cannot_set_growth_value_on_zero_growth_type'));
            }

            if ($dividendDiscountModelType == StockDDMTypes::MULTIPLE_GROWTH) {
                if (Helpers::checkIfPositiveNumberOrThrowAnException($stockAnnualDividendsGrowth)) {
                    Helpers::checkIfLeftOperandGreaterOrThrowAnException(
                        $this->stockVIR,
                        $stockAnnualDividendsGrowth,
                        Strings::getString('message_vir_must_be_higher_than_growth_value')
                    );
                }
            }

            $this->setProperty("stockAnnualDividendsGrowth", $stockAnnualDividendsGrowth);
        }

        /**
         * @return mixed
         */
        public function getDividendDiscountModelType()
        {
            return $this->dividendDiscountModelType;
        }

        /**
         * @return mixed
         */
        public function getStockVIR()
        {
            return $this->stockVIR;
        }

        /**
         * @return mixed
         */
        public function getStockAnnualDividendsValue()
        {
            return $this->stockAnnualDividendsValue;
        }

        /**
         * @return mixed
         */
        public function getStockAnnualDividendsGrowth()
        {
            return $this->stockAnnualDividendsGrowth;
        }

        /**
         * @return string
         * @throws Exception
         */
        public function getStockPresentValue()
        {
            switch ($this->dividendDiscountModelType->getValue()) {
                case StockDDMTypes::ZERO_GROWTH:
                    // PV = D/i
                    return MathFuncs::div(
                        $this->stockAnnualDividendsValue,
                        $this->stockVIR
                    );
                case StockDDMTypes::MULTIPLE_GROWTH:
                    if ($this->stockAnnualDividendsGrowth === null) {
                        throw new Exception(Strings::getString('message_must_set_growth_value'));
                    }
                    // PV = (D*(1+g))/(i-g)
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
            }

            return null;
        }
    }
}
