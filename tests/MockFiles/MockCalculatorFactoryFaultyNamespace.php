<?php

namespace FinanCalc\Calculators\FaultyFactories {

    use FinanCalc\Interfaces\Calculator\CalculatorFactoryAbstract;


    /**
     * Class MockCalculatorFactoryFaultyNamespace
     * @package FinanCalc\Calculators\FaultyFactories
     */
    class MockCalculatorFactoryFaultyNamespace extends CalculatorFactoryAbstract {
        const MANUFACTURED_CLASS_NAME = 'FinanCalc\\Calculators\\FaultyNamespaceCalculator';
    }
}