<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
header("Content-Type: text/html; charset=utf-8");

require_once 'core/autoload.php';
require_once 'core/registry.php';

require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';

require_once 'core/router.php';

//----------------------------
Tools::getSiteConfig();
//----------------------------
Tools::getSiteData();
//----------------------------
Tools::getUserData();
//----------------------------
Tools::getAccessData();

Router::start();