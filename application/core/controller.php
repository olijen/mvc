<?php
class Controller {
    
    protected $model;
    protected $view;
    protected $_params;
    
    function __construct()
    {
        $this->_params = Router::$params;
        $this->view = new View();
        $model = str_replace('_', '', 'Model'.Router::$ctrlName);
        $this->model = new $model;
        $this->accessControl(Router::$actionName);
    }

    protected function accessControl($action)
    {
        if (!method_exists($this, 'access')) return true;
        $access = $this->access();
        $accessError['L'] = 'Вам нужно авторизоваться';
        $accessError['A'] = 'Только для администратора';
        
        if (empty($access[$action])) {
            return true;
        }
        if (A) {
            return true;
        }
        if ($access[Router::$actionName][0] == '*') {
            return true;
        } else {
            foreach ($access[Router::$actionName] as $v) {
                if (!constant($v)) {
                    $this->view->notice['error'] = $accessError[$v];
                    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                        !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
                    {
                        $this->view->jsonResponse();
                    }
                    else
                    { 
                        $this->view->generate();
                    }
                    exit;
                }
            }
            return true;
        }
    }
}