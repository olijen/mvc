<?php

$CONFIG = array(

    'SITENAME' => 'http://'.$_SERVER['HTTP_HOST'],
    'ROOTDIR'  => $_SERVER['DOCUMENT_ROOT'],
    'APPDIR'   => $_SERVER['DOCUMENT_ROOT'].'/application',
    'FRONTDIR' => $_SERVER['DOCUMENT_ROOT'].'/front',
    
    'DB_NAME'  => 'mvc',
    'DB_USER'  => 'root',
    'DB_HOST'  => 'localhost',
    'DB_PWD'   =>  '',
    
);

foreach ($CONFIG as $k => $v) {
    defined($k) or define($k, $v);
}

unset($CONFIG);