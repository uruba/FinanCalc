<?php

spl_autoload_register(function($class) {
    if (!isset($GLOBALS['FINANCALC_ROOT'])) {
        throw new Exception('Global variable containing path to the library root has not been set.');
    }

    $exploded_class = explode("\\", $class);
    if (count($exploded_class) > 1)
        array_shift($exploded_class);

    $le = array_pop($exploded_class);
    foreach ($exploded_class as &$elem) {
        $elem = strtolower($elem);
    }
    array_push($exploded_class, $le);

    $relative_class_path = implode("/", $exploded_class);

    $class_path =
        $GLOBALS['FINANCALC_ROOT'] .
        (empty($GLOBALS['FINANCALC_ROOT'])
            ? '' : '/') .
        $relative_class_path .
        '.php';

    if (file_exists($class_path)) {
        require_once($class_path);
    }

});