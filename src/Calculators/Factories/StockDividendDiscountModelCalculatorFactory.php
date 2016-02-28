<?php

namespace FinanCalc\Calculators\Factories {

    use FinanCalc\Calculators\StockDividendDiscountModelCalculator;
    use FinanCalc\Constants\StockDDMTypes;
    use FinanCalc\Interfaces\Calculator\CalculatorFactoryAbstract;

    /**
     * Class StockDividendDiscountModelFactory
     * @package FinanCalc\Calculators\Factories
     */
    class StockDividendDiscountModelCalculatorFactory extends CalculatorFactoryAbstract
    {
        const MANUFACTURED_CLASS_NAME = 'FinanCalc\\Calculators\\StockDividendDiscountModelCalculator';

        /**
         * @param $stockVIR
         * @param $stockAnnualDividendValue
         * @return StockDividendDiscountModelCalculator
         */
        public function newZeroGrowthDividendDiscountModel($stockVIR, $stockAnnualDividendValue)
        {
            return $this->manufactureInstance(
                [
                    new StockDDMTypes(StockDDMTypes::ZERO_GROWTH),
                    $stockVIR,
                    $stockAnnualDividendValue
                ]
            );
        }

        /**
         * @param $stockVIR
         * @param $stockAnnualDividendValue
         * @param $stockAnnualDividendsGrowth
         * @return StockDividendDiscountModelCalculator
         */
        public function newMultipleGrowthDividendDiscountModel(
            $stockVIR,
            $stockAnnualDividendValue,
            $stockAnnualDividendsGrowth
        ) {
            return $this->manufactureInstance(
                [
                    new StockDDMTypes(StockDDMTypes::MULTIPLE_GROWTH),
                    $stockVIR,
                    $stockAnnualDividendValue,
                    $stockAnnualDividendsGrowth
                ]
            );
        }
    }
}
