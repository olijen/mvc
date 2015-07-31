<?php
class Router
{
    static $routes = array();
    static $ctrlName = 'main';
    static $actionName = 'index';
    
    public static function start()
    {
        if (!empty($_GET['routes'])) {
         $r =$_GET['routes'];
         unset($_GET['routes']);
         } else {
            $r = '';
         }

        self::$routes = explode('/', $r);
        if (count(self::$routes) <= 2) {
            self::getCtrlNames();
            self::model();
            self::controller();
        } else {
            self::module();
        }   
    }
    
    protected static function getCtrlNames($mod = 0)
    {
        $_ctrl = 0 + $mod;
        $_act  = 1 + $mod;
        // получаем имя контроллера
        if (!empty(self::$routes[$_ctrl])) {
            self::$ctrlName = str_replace("-","_",self::$routes[$_ctrl]);
        }
        // получаем имя экшена
        if (!empty(self::$routes[$_act])) {
            self::$actionName = str_replace("-","_",self::$routes[$_act]);
        }
        // добавляем префиксы
        
    }
    
    protected static function controller()
    {   
        $ctrlFName = 'controller_'.self::$ctrlName;
        if (defined('MODDIR')) {
            $ctrlPath = MODDIR.'/controllers/'.$ctrlFName.'.php';
        } else {
            $ctrlPath = APPDIR.'/controllers/'.$ctrlFName.'.php';
        }
        if(file_exists($ctrlPath)) {
            require_once strtolower($ctrlPath);
        } else {
            self::ErrorPage404();
        }
        // создаем контроллер
        $ctrlFName = str_replace('_', '', $ctrlFName);
        $ctrl = new $ctrlFName();
        $action = 'action'.self::$actionName;
        
        if(method_exists($ctrl, $action)) {
            // вызываем действие контроллера (actionIndex)
            // Arguments
            if ( !empty(self::$routes[3])) {
                $ctrl->$action(self::$routes[3]);
            } else {
                $ctrl->$action();
            }
        } else {
            self::ErrorPage404();
        }
    }
    
    protected static function model()
    {
        $modelName = 'model_'.self::$ctrlName;
        $modelFile = $modelName.'.php';
        if (defined('MODDIR')) {
            $modelPath = MODDIR.'/models/'.$modelFile;
        } else {
            $modelPath = APPDIR.'/models/'.$modelFile;
        }
        if(file_exists($modelPath)) {
            require_once strtolower($modelPath);
            return true;
        } else return false;
    }
    
    protected static function module()
    {
        if (!empty(self::$routes[0])) {
            $module = self::$routes[0];
            $moduleClass = 'router_'.$module;
            define('MODDIR', APPDIR.'/modules/'.$module);
            $path = MODDIR.'/'.$moduleClass.'.php';
        }
        if(file_exists($path)) {
            require_once strtolower($path);
            $moduleClass = str_replace('_', '', $moduleClass);
            $moduleClass::start(self::$routes);
        } else {
            self::ErrorPage404();
        }
    }
    
    function ErrorPage404()
    {
        //$host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        //header('HTTP/1.1 404 Not Found');
        //header("Status: 404 Not Found");
        echo '<br>404<br>';
        //header('Location:'.$host.'404');
    }
}