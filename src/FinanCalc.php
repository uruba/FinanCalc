<?php
/**
 * FinanCalc
 *
 * A lightweight, simple and easy PHP library for calculating annuities (e.g., mortgages) according to various input data
 *
 *
 * DISCLAIMER
 * You are free to use/modify/extend the library as you please - for it to serve your purpose.
 * As per the (un)license, the software is provided as is and the original author cannot be held liable
 * for any losses/damages directly or indirectly resulting from using thereof.
 * Attribution is welcome, but certainly not required.
 *
 * NOTE
 * The library is currently work-in-progress and it is certain that new features will be added in the process.
 * Consider this, therefore, as a preview product prone to abrupt and extensive changes that may affect functionality
 * of an external code adapted to a prior version(s) of the library.
 * Always explore the provisional compatibility of the library with your project in case you upgrade to a new version
 * of the library (by means of an extensive testing of the code in which you are exerting the library's features).
 *
 * PREREQUISITES
 * PHP 5.5+
 * Module php-bcmath
 *
 * @author Václav Uruba
 * @version 0.1
 * @license http://unlicense.org The Unlicense
 */
namespace FinanCalc {
    use FinanCalc\Utils\Config;
    use FinanCalc\Calculators\Factories;

    $GLOBALS['FINANCALC_ROOT'] = dirname(__FILE__);
    require_once($GLOBALS['FINANCALC_ROOT'] . '/init/bootstrap.php');

    /**
     * Class FinanCalc
     * @package FinanCalc
     */
    class FinanCalc {
        private $factoryClasses = array();

        /**
         *
         * Serve the class as a singleton
         *
         */

        private function __construct() {
            $this->populateFactoryClassesArray();
        }

        public static function getInstance() {
            static $instance = null;
            if ($instance === null) {
                $instance = new FinanCalc();
            }
            return $instance;
        }

        /**
         *
         * Business logic IMPLEMENTATION
         *
         */


        public function getFactories() {
            return $this->factoryClasses;
        }

        public function getFactory($factoryClassName) {
            if (array_key_exists($factoryClassName, $this->factoryClasses))
                return $this->factoryClasses[$factoryClassName];
            else
                throw new Exception("Factory class " . $factoryClassName . " is not initialized!");
        }

        public function setConfig($configArray) {
            Config::init($configArray);
        }

        /**
         *
         * PRIVATE functions
         *
         */

        private function populateFactoryClassesArray() {
            $factoryFiles = glob($GLOBALS['FINANCALC_ROOT'] . Config::getConfigField('factories_relative_path') . '/*.php');
            $factoriesNamespace = Config::getConfigField('factories_namespace');

            foreach ($factoryFiles as $factoryFile) {
                if (file_exists($factoryFile)) {
                    $factoryFileContents = file_get_contents($factoryFile);
                } else {
                    continue;
                }
                $fileTokens = token_get_all($factoryFileContents);
                for ($i = 2; $i < count($fileTokens); $i++) {
                    if ($fileTokens[$i-2][0] == T_CLASS) {
                        $factoryClassName = $fileTokens[$i][1];
                        try {
                            require_once($factoryFile);
                            $factoryClassReflector = new \ReflectionClass($factoriesNamespace . '\\' . $factoryClassName);
                        } catch (\ReflectionException $e) {
                            error_log("Factory class "
                                . $factoryClassName
                                . " must be in the "
                                . $factoriesNamespace
                                . " namespace.");
                            continue;
                        }

                        if ($factoryClassReflector->isSubclassOf('FinanCalc\\Interfaces\\CalculatorFactoryAbstract')) {
                            $this->factoryClasses[$factoryClassName] = $factoryClassReflector->newInstance();
                            break;
                        } else {
                            error_log("Factory class has to extend the abstract class FinanCalc\\Interfaces\\CalculatorFactoryAbstract!");
                        }
                    }
                }
            }
        }
    }


}