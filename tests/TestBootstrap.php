<?php

require_once dirname(__FILE__) . '/../vendor/autoload.php';

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