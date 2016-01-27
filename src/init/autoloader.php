<?php

spl_autoload_register(function($class) {
    $exploded_class = explode("\\", $class);
    if (count($exploded_class) > 1)
        array_shift($exploded_class);

    $le = array_pop($exploded_class);
    array_push($exploded_class, $le);

    $relative_class_path = implode("/", $exploded_class);

    $class_path =
        dirname(dirname(__FILE__)) .
        '/' .
        $relative_class_path .
        '.php';

    if (file_exists($class_path)) {
        /** @noinspection PhpIncludeInspection */
        require_once($class_path);
    }
});