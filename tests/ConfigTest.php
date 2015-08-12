<?php

use FinanCalc\Utils\Config;

/**
 * Class ConfigTest
 */
class ConfigTest extends PHPUnit_Framework_TestCase {

    public function testSetNewValue() {
        Config::setConfigField('test_field', 'test');

        $this->assertEquals(
            'test',
            Config::getConfigField('test_field'));
    }

    public function testGetOneOfTheDefaultValues() {
        $this->assertEquals(
            '/calculators/factories',
            Config::getConfigField('factories_relative_path'));
    }

}
