<?php

date_default_timezone_set("Europe/London");

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

/**
 * @param $object
 * @param $methodName
 * @param array $parameters
 * @return mixed
 */
function invokeMethod(&$object, $methodName, array $parameters = array())
{
    $reflection = new \ReflectionClass(get_class($object));
    $method = $reflection->getMethod($methodName);
    $method->setAccessible(true);

    return $method->invokeArgs($object, $parameters);
}