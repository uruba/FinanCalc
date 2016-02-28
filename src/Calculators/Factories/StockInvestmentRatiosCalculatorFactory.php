<?php

namespace FinanCalc\Calculators\Factories {

    use FinanCalc\Calculators\StockInvestmentRatiosCalculator;
    use FinanCalc\Interfaces\Calculator\CalculatorFactoryAbstract;

    /**
     * Class StockInvestmentRatiosCalculatorFactory
     * @package FinanCalc\Calculators\Factories
     */
    class StockInvestmentRatiosCalculatorFactory extends CalculatorFactoryAbstract
    {
        const MANUFACTURED_CLASS_NAME = 'FinanCalc\\Calculators\\StockInvestmentRatiosCalculator';

        /**
         * @param $totalDividends
         * @param $earningAfterTaxes
         * @param $noOfStocks
         * @return StockInvestmentRatiosCalculator
         */
        public function newCustomStocks($totalDividends, $earningAfterTaxes, $noOfStocks)
        {
            return $this->manufactureInstance(
                [
                    $totalDividends,
                    $earningAfterTaxes,
                    $noOfStocks
                ]
            );
        }
    }
}
