<?php

spl_autoload_register(function($class) {
    $exploded_class = explode("\\", $class);

    if (count($exploded_class) > 1) {
        array_shift($exploded_class);
    }

    array_push($exploded_class, array_pop($exploded_class));

    $relative_class_path = implode("/", $exploded_class);

    $absolute_class_path =
        dirname(dirname(__FILE__)) .
        '/' .
        $relative_class_path .
        '.php';

    if (file_exists($absolute_class_path)) {
        /** @noinspection PhpIncludeInspection */
        require_once($absolute_class_path);
    }
});