<?php

function classLoader($class)
{
    $name = substr(strrchr($class, '\\'), 1);
    $file = dirname(__DIR__) .'/'. $name .'.php';
    if (is_file($file)) {
        require_once $file;
    }
}

spl_autoload_register('classLoader');