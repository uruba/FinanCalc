<?php

use FinanCalc\Calculators\StockDividendDiscountModelCalculator;
use FinanCalc\Constants\StockDDMTypes;

/**
 * Class StockDividendDiscountModelCalculatorTest
 */
class StockDividendDiscountModelCalculatorTest extends PHPUnit_Framework_TestCase {
    private $stockDividendDiscountModelCalculatorDirect,
            $stockDividendDiscountModelCalculatorFactory;

    public function testStockDividendDiscountModelDirect() {
        $this->assertStockDDM(
            $this->stockDividendDiscountModelCalculatorDirect
        );
    }

    public function testExceptionStockPresentValue() {
        $this->setExpectedException("Exception");

        $stockDDMCalculator = $this->stockDividendDiscountModelCalculatorDirect;
        $stockDDMCalculator->setDividendDiscountModelType(new StockDDMTypes(StockDDMTypes::MULTIPLE_GROWTH));
        $stockDDMCalculator->getStockPresentValue();
    }

    public function testExceptionGrowthRateGreaterThanVIR() {
        $this->setExpectedException("InvalidArgumentException");

        $stockDDMCalculator = $this->stockDividendDiscountModelCalculatorDirect;
        $stockDDMCalculator->setDividendDiscountModelType(new StockDDMTypes(StockDDMTypes::MULTIPLE_GROWTH));
        $stockDDMCalculator->setStockAnnualDividendsGrowth(0.1);
    }

    public function testExceptionSetGrowthRateOnZeroGrowth() {
        $this->setExpectedException("InvalidArgumentException");

        $stockDDMCalculator = $this->stockDividendDiscountModelCalculatorDirect;
        $stockDDMCalculator->setStockAnnualDividendsGrowth(0.05);
    }

    /**
     * @param $stockDividendDiscountModelCalculator
     */
    private function assertStockDDM($stockDividendDiscountModelCalculator) {
        $this->assertZeroGrowthStockDDM($stockDividendDiscountModelCalculator);

        $stockDividendDiscountModelCalculator->setDividendDiscountModelType(new StockDDMTypes(StockDDMTypes::MULTIPLE_GROWTH));
        $stockDividendDiscountModelCalculator->setStockAnnualDividendsGrowth(0.05);
        $this->assertMultipleGrowthStockDDM($stockDividendDiscountModelCalculator);

        $stockDividendDiscountModelCalculator->setDividendDiscountModelType(new StockDDMTypes(StockDDMTypes::ZERO_GROWTH));
        $this->assertNull($stockDividendDiscountModelCalculator->getStockAnnualDividendsGrowth());
    }


    /**
     * @param StockDividendDiscountModelCalculator $stockDividendDiscountModelCalculator
     */
    private function assertZeroGrowthStockDDM(StockDividendDiscountModelCalculator $stockDividendDiscountModelCalculator) {
        $this->assertStockDDMsFairValue(750, $stockDividendDiscountModelCalculator);
    }

    /**
     * @param StockDividendDiscountModelCalculator $stockDividendDiscountModelCalculator
     */
    private function assertMultipleGrowthStockDDM(StockDividendDiscountModelCalculator $stockDividendDiscountModelCalculator) {
        $this->assertStockDDMsFairValue(1575, $stockDividendDiscountModelCalculator);
    }

    /**
     * @param $expected
     * @param StockDividendDiscountModelCalculator $stockDividendDiscountModelCalculator
     * @throws Exception
     */
    private function assertStockDDMsFairValue($expected, StockDividendDiscountModelCalculator $stockDividendDiscountModelCalculator) {
        $FV_direct = $stockDividendDiscountModelCalculator->getStockPresentValue();
        $FV_array = $stockDividendDiscountModelCalculator
            ->getResultAsArray()["stockPresentValue"];

        $this->assertEquals($expected, $FV_direct);
        $this->assertEquals($expected, $FV_array);
    }

    /**
     * @return StockDividendDiscountModelCalculator
     */
    private function newStockDividendDiscountModelCalculatorDirect() {
        return new StockDividendDiscountModelCalculator(
            new StockDDMTypes(StockDDMTypes::ZERO_GROWTH),
            0.1,
            75);
    }

    protected function setUp() {
        $this->stockDividendDiscountModelCalculatorDirect = $this->newStockDividendDiscountModelCalculatorDirect();

        parent::setUp();
    }
}
