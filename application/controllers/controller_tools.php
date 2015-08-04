<?php
class ControllerTools extends Controller
{
    public function actionIndex()
    {
        if (isset($_POST['user'])) {
            if ($this->view->user = $this->model->login($_POST['user'])) {
                $this->view->notice['notice'] = 'Вы успешно авторизованны!';
            } else {
                $this->view->notice['error'] = $this->model->error;
            }
            $this->view->jsonResponse();
        } else {
            $this->view->viewScheme['content'][S]['login'] = array();
            $this->view->generate();
        }
    }
    
    public function actionRegister()
    {
        if (isset($_POST['user'])) {
            if ($this->view->user = $this->model->register($_POST['user'])) {
                $this->view->notice['notice'] = 'ok';
            } else {
                $this->view->notice['error'] = $this->model->error;
            }
        } else {
            //$this->view->notice['error'] = 'No data!';
        }
        $this->view->content = array('register');
        $this->view->generate();
    }

    public function actionLogin()
    {
        if (isset($_POST['user'])) {
            if ($this->view->user = $this->model->login($_POST['user'])) {
                $this->view->notice['notice'] = 'Вы успешно авторизованны!';
            } else {
                $this->view->notice['error'] = $this->model->error;
            }
            $this->view->jsonResponse();
        } else {
            $this->view->viewScheme['content'][S]['login'] = array();
            $this->view->generate();
        }
    }
    
    public function actionLogout()
    {
        unset($_SESSION['usr']);
    	session_destroy();
        $this->view->notice['notice'] = 'Вы вышли. Данные сессии удалены.';
        $this->view->jsonResponse();
    }
    
    public function actionMigrate()
    {

        if (isset($_GET['up'])) {
            if ($this->model->migrateUp()) {
                $this->view->notice['notice'] = 'ok';
                return;
            }
            $this->view->notice['error'] = $this->model->error;
            return;
        }
        $this->view->data['migration'] = $this->model->migrate();
        $this->view->content = array('migrate');
        $this->view->notice['notice'] = 'ok';
        $this->view->generate();
    }
    
    protected function access()
    {
        return array(
            'index'    =>array('L'),
            'register' =>array('*'),
            'login'    =>array('*'),
            'logout'   =>array('*'),
        );
    }
}