<?php

require_once dirname(__FILE__) . '/../src/FinanCalc.php';

/**
 * @param $objectType
 * @param $array
 * @return bool
 */
function isObjectTypeInArray($objectType, $array) {
    foreach ($array as $arrayEntry) {
        if ($arrayEntry instanceof $objectType) {
            return true;
        }
    }

    return false;
}