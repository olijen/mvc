<?php
function autoloadClass($className) {
    
    $className  = strtolower($className);
    $class      = $_SERVER['DOCUMENT_ROOT'].'/application/components/classes/'.$className.'.php';
    $repository = $_SERVER['DOCUMENT_ROOT'].'/application/components/repositories/'.$className.'.php';
    
    if (file_exists($class)) {
        require_once $class;
    } elseif (file_exists($repository)) {
        require_once $repository;
    } else {
        throw new Exception('[ERROR! Autoloading: Class '.$className.'. IS NOT EXSIST! ]<hr/>');
    }
}

spl_autoload_register('autoloadClass');