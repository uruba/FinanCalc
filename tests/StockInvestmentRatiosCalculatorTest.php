<?php
use FinanCalc\Calculators\StockInvestmentRatiosCalculator;

/**
 * Class StockInvestmentRatiosCalculatorTest
 */
class StockInvestmentRatiosCalculatorTest extends PHPUnit_Framework_TestCase {
    private $stockInvestmentCalculatorDirect,
            $stockInvestmentCalculatorFactory;

    public function testRatiosDirect() {
        $this->assertRatios($this->stockInvestmentCalculatorDirect);
        $this->assertRatiosArray($this->stockInvestmentCalculatorDirect);
    }

    public function testRatiosFactory() {
        $this->assertRatios($this->stockInvestmentCalculatorFactory);
        $this->assertRatiosArray($this->stockInvestmentCalculatorFactory);
    }

    /**
     * @param StockInvestmentRatiosCalculator $stockInvestmentRatiosCalculator
     */
    private function assertRatios(StockInvestmentRatiosCalculator $stockInvestmentRatiosCalculator) {
        $this->assertEquals(   80   , $stockInvestmentRatiosCalculator->getDividendPerStock());
        $this->assertEquals(  100   , $stockInvestmentRatiosCalculator->getEarningsPerStock());
        $this->assertEquals(    0.8 , $stockInvestmentRatiosCalculator->getPayoutRatio());
        $this->assertEquals(    1.25, $stockInvestmentRatiosCalculator->getDividendRatio());
        $this->assertEquals(    0.2 , $stockInvestmentRatiosCalculator->getRetentionRatio());

        // test also also the getters of the initial properties
        $this->assertEquals( 8000   , $stockInvestmentRatiosCalculator->getTotalDividends());
        $this->assertEquals(10000   , $stockInvestmentRatiosCalculator->getEarningsAfterTaxes());
        $this->assertEquals(  100   , $stockInvestmentRatiosCalculator->getNoOfStocks());
    }

    /**
     * @param StockInvestmentRatiosCalculator $stockInvestmentRatiosCalculator
     */
    private function assertRatiosArray(StockInvestmentRatiosCalculator $stockInvestmentRatiosCalculator) {
        $resultArray = $stockInvestmentRatiosCalculator->getResultAsArray();

        $this->assertEquals(   80   , $resultArray["dividendPerStock"]);
        $this->assertEquals(  100   , $resultArray["earningsPerStock"]);
        $this->assertEquals(    0.8 , $resultArray["payoutRatio"]);
        $this->assertEquals(    1.25, $resultArray["dividendRatio"]);
        $this->assertEquals(    0.2 , $resultArray["retentionRatio"]);

        // test also also the getters of the initial properties
        $this->assertEquals( 8000   , $resultArray["totalDividends"]);
        $this->assertEquals(10000   , $resultArray["earningsAfterTaxes"]);
        $this->assertEquals(  100   , $resultArray["noOfStocks"]);
    }

    /**
     * Test presence in the main factories array
     */
    public function testPresenceInMainFactoriesArray() {
        $this->assertTrue(
            isObjectTypeInArray('FinanCalc\\Calculators\\Factories\\StockInvestmentRatiosCalculatorFactory', \FinanCalc\FinanCalc::getInstance()->getFactories())
        );
    }

    /**
     * @return StockInvestmentRatiosCalculator
     */
    private function newStockInvestmentCalculatorDirect() {
        return new StockInvestmentRatiosCalculator(8000, 10000, 100);
    }

    /**
     * @return mixed
     * @throws Exception
     */
    private function newStockInvestmentCalculatorFactory() {
        return \FinanCalc\FinanCalc
            ::getInstance()
            ->getFactory('StockInvestmentRatiosCalculatorFactory')
            ->newCustomStocks(8000, 10000, 100);
    }

    protected function setUp() {
        $this->stockInvestmentCalculatorDirect = $this->newStockInvestmentCalculatorDirect();
        $this->stockInvestmentCalculatorFactory = $this->newStockInvestmentCalculatorFactory();

        parent::setUp();
    }
}
