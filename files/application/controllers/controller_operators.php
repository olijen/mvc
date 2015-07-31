<?php
class ControllerOperators extends Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->view->content = array('operators');
    }
    public function actionIndex()
    {
        if ($this->view->data['users'] = $this->model->usersTable()) {
                $this->view->notice['notice'] = 'Таблица извлечена';
        } else {
            $this->view->notice['error'] = $this->model->error;
        }
        $this->view->generate();
    }
    
    public function actionAddMeny()
    {
        for ($i = 0; $i < 200; $i++) {
            $user = rand(100000000, 999999999);
        }
    }
    
    public function actionAdd()
    {
        if (isset($_POST['user'])) {
            if ($this->view->user = $this->model->add($_POST['user'])) {
                $this->view->notice['notice'] = 'Юзер создан';
            } else {
                $this->view->notice['error'] = $this->model->error;
            }
        } else {
            $this->view->notice['error'] = 'Вы не ввели информацию';
        }
        $this->view->jsonResponse();
    }
    
    protected function access()
    {
        return array(
            'index' =>array('A'),
            'add'   =>array('A'),
        );
    }

}