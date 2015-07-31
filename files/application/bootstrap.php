<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
header("Content-Type: text/html; charset=utf-8");

require_once 'core/autoload.php';
require_once 'core/registry.php';
//require_once 'site_config.php';

require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';

require_once 'core/router.php';
//echo '->'.$_SESSION['usr']['id'];
//----------------------------
Tools::getSiteConfig();
//----------------------------
Tools::getSiteData();
//----------------------------
Tools::getUserData();
//----------------------------
Tools::getAccessData();

Router::start();