<?php

use FinanCalc\Utils\Helpers;

$GLOBALS["FINANCALC_FUNC_CHECK_IF_NOT_NEGATIVE"] = function($param) {
    Helpers::checkIfNotNegativeNumberOrThrowAnException($param);
};

$GLOBALS["FINANCALC_FUNC_CHECK_IF_POSITIVE"] = function($param) {
    Helpers::checkIfPositiveNumberOrThrowAnException($param);
};