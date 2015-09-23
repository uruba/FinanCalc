<?php

require_once('autoloader.php');

$GLOBALS["FINANCALC_FUNC_CHECK_IF_NOT_NEGATIVE"] = function($param) {
    \FinanCalc\Utils\Helpers::checkIfNotNegativeNumberOrThrowAnException($param);
};

$GLOBALS["FINANCALC_FUNC_CHECK_IF_POSITIVE"] = function($param) {
    \FinanCalc\Utils\Helpers::checkIfPositiveNumberOrThrowAnException($param);
};

\FinanCalc\Utils\Config::init();