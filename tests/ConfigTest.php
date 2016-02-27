<?php

use FinanCalc\Constants\Defaults;
use FinanCalc\Constants\ErrorMessages;
use FinanCalc\Utils\Config;

/**
 * Class ConfigTest
 */
class ConfigTest extends PHPUnit_Framework_TestCase
{

    public function testSetNewValue()
    {
        Config::setConfigField('test_field', 'test');

        $this->assertEquals(
            'test',
            Config::getConfigField('test_field'));
    }

    public function testInitAndGetConfigViaMainObject()
    {
        FinanCalc\FinanCalc::getInstance()->setConfig(['test_field' => 'test from main object']);

        $this->assertEquals(
            'test from main object',
            Config::getConfigField('test_field')
        );
    }

    public function testInitNullConfigViaMainObject()
    {
        FinanCalc\FinanCalc::getInstance()->setConfig();

        $this->assertEquals(
            Defaults::$configDefault,
            Config::getConfigArray()
        );
    }

    public function testGetOneOfTheDefaultValues()
    {
        $this->assertEquals(
            '/Calculators/Factories',
            Config::getConfigField('factories_relative_path'));
    }

    public function testGetNonExistentConfigValue()
    {
        $this->setExpectedException("Exception", ErrorMessages::getConfigFieldNotFoundMessage("NonExistent"));

        Config::setConfigField("NonExistent", null);
        Config::getConfigField("NonExistent");
    }

    public function testConfigArrayEmpty()
    {
        $resetConfig = function () {
            $reflectionClass = new ReflectionClass("FinanCalc\\Utils\\Config");
            $reflectedProperty = $reflectionClass->getProperty('configArray');
            $reflectedProperty->setAccessible(true);
            $reflectedProperty->setValue(array());
        };

        $resetConfig();
        Config::setConfigField("TestField", "TestValue");
        $this->assertEquals(
            "TestValue",
            Config::getConfigField("TestField")
        );

        $resetConfig();
        $this->assertEquals(
            "/Calculators/Factories",
            Config::getConfigField("factories_relative_path")
        );
    }
}
