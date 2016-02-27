<?php

namespace FinanCalc\Calculators\Factories {

    /**
     * Class MockCalculatorFactoryBadAncestor
     * @package FinanCalc\Calculators\FaultyFactories
     */
    class MockCalculatorFactoryBadAncestor extends BadAncestor
    {
        const MANUFACTURED_CLASS_NAME = 'FinanCalc\\Calculators\\FaultyNamespaceCalculator';
    }

    /**
     * Class BadAncestor
     * @package FinanCalc\Calculators\FaultyFactories
     */
    abstract class BadAncestor
    {

    }
}