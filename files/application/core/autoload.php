<?php
function autoload($className) {
    $className = strtolower($className);
    $dir  = $_SERVER['DOCUMENT_ROOT'].'/application/components/'.$className.'_class.php';
    if (file_exists($dir)) {
        require_once $dir;
    } else {
        echo '[ Autoloading: '.$dir.'. IS NOT EXSIST! ]';
    }
}
spl_autoload_register('autoload');