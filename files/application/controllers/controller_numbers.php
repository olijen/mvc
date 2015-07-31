<?php
class ControllerNumbers extends Controller
{

    public function actionIndex()
    {
        $this->view->content = array('numbers');
        if ($this->view->data['numbers'] = $this->model->numbersTable()) {
                $this->view->notice['notice'] = 'Таблица извлечена';
        } else {
            $this->view->notice['error'] = $this->model->error;
        }
        $this->view->generate();
    }
    
    public function actionAddMeny()
    {
        exit();
        for ($i = 0; $i < 200; $i++) {
            $number = rand(100000000, 999999999);
            $number = new Numbers(array('number'=>$number));
            $number->save(true);
            echo $number->number;
        }
    }
    
    public function actionAdd()
    {
        if (isset($_POST['number'])) {
            if ($this->model->add($_POST['number'])) {
                $this->view->notice['notice'] = 'Номер создан';
            } else {
                $this->view->notice['error'] = $this->model->error;
            }
        } else {
            $this->view->notice['error'] = 'Вы не ввели информацию';
        }
        $this->view->jsonResponse();
    }
    
    public function actionAddFromFile()
    {
        $this->view->content = array('log');
            if ($this->view->data['log'] = $this->model->addFromFile()) {
                $this->view->notice['notice'] = 'Готово!';
            } else {
                $this->view->notice['error'] = $this->model->error;
            }
        $this->view->generate();
    }
    
    protected function access()
    {
        return array(
            'index'    =>array('A'),
            'add'      =>array('A'),
            'addfromfile' => array('A'),
        );
    }

}