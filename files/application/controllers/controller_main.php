<?php
class ControllerMain extends Controller
{
    private $only;
    private $desc;
    public function __construct()
    {
        parent::__construct();
        if (isset($_GET['desc']) && $_GET['desc'] == 0) {
            $this->model->filter['desc'] = 1;
        } else {
            $this->model->filter['desc'] = 0;
        }

        $this->model->filter['orderBy'] = (!empty($_GET['orderBy'])) ? addslashes($_GET['orderBy']) : '';
        $this->model->filter['where'] = (!empty($_GET['filter'])) ?
        array($_GET['filter']['name'] => $_GET['filter']['value']) : array();
        
        $this->view->data['fLinc'] =
        $this->view->path['site'].'/'.Router::$ctrlName.'/'.Router::$actionName.'?desc='.$this->model->filter['desc'].'&orderBy=';
        
        $this->view->data['pageNav'] = ceil(count(Numbers::getAll("*", $this->model->filter['where'], $this->model->filter)) / 100);
        
        $this->view->data['submitTxt'] = 'Просмотр';
        $this->view->data['numStatus']  = Registry::get('num_status');
        
        if (A) $this->view->data['operators'] = Users::getAll('fio', array('status'=>'operator'));
    }

    public function actionIndex()
    {
        $this->model->filter['orderBy'] = 'id';
        $this->model->filter['min'] = 0;
        $this->model->filter['max'] = 150;
        $this->view->data['header'] = 'Главная';
        $this->view->content = array('main');
        $this->view->data['submitTxt'] = 'Взять в работу';
        
        if (!empty($_POST['number'])) {
            if (L) {
                $this->model->work($_POST['num_id']);
                $this->showNumber($_POST['number']);
            } else {
                $this->view->notice['error'] = 'Только для залогиненных';
            }
        }
        $this->numbersTable('operator');
        
        $this->view->generate();
    }
    
    public function actionWaiting()
    {
        $this->view->data['header'] = 'Ожидание';
        $this->view->content = array('main');
        
        if (!empty($_POST['number'])) {
            $this->showNumber($_POST['number']);
        }
        $this->numbersTable('operator', Registry::get('user')->fio);
        
        $this->view->generate();
    }
    
    public function actionRequest()
    {
        $this->view->data['header'] = 'Заявки';
        $this->view->data['kyrjers'] = Users::getAll('fio', array('status'=>'kyrjer'));
        $this->view->data['districts'] = Numbers::getAll('DISTINCT `district`');
        $this->view->content = array('request');
        
        if ($this->view->data['numbers'] = $this->model->requestTable()) {
                $this->view->notice['notice'] .= 'Номера извлечены. ';
        } else {
            $this->view->notice['error'] .= $this->model->error;
        }

        if (!empty($_GET['unload'])) {
            $this->view->htmlResponse('unload', 'main');
        } else {
            $this->view->generate();
        }
    }
    
    public function actionConfirm()
    {
        $this->view->data['header'] = 'Договор';
        $this->view->data['kyrjers'] = Users::getAll('fio', array('status'=>'kyrjer'));
        $this->view->data['districts'] = Numbers::getAll('DISTINCT `district`');
        $this->view->content = array('confirm');

        if ($this->view->data['numbers'] = $this->model->confirmTable()) {
                $this->view->notice['notice'] .= 'Номера извлечены. ';
        } else {
            $this->view->notice['error'] .= $this->model->error;
        }
        if (!empty($_GET['unload'])) {
            $this->view->htmlResponse('unload', 'main');
        } else {
            $this->view->generate();
        }
    }
        
    public function actionDeny()
    {
        $this->view->data['header'] = 'Отказ';
        $this->view->content = array('deny');
        if ($this->view->data['numbers'] = $this->model->denyTable()) {
                $this->view->notice['notice'] .= 'Номера извлечены. ';
        } else {
            $this->view->notice['error'] .= $this->model->error;
        }
        $this->view->generate();
    }
    
    //---Actions
    public function actionChange()
    {
        if (isset($_POST['change'])) {
            if ($this->model->change($_POST['change'])) {
                $this->view->notice['notice'] = 'Изменено. ';
            } else {
                $this->view->notice['error'] = $this->model->error;
            }
        } else {
            $this->view->notice['error'] = 'Вы не ввели информацию';
        }
        $this->view->jsonResponse();
    }
    
    //---SERVICE
    public function numbersTable($kay, $value='')
    {
        if ($this->view->data['numbers'] = $this->model->numbersTable($kay, $value)) {
                $this->view->notice['notice'] .= 'Номера извлечены. ';
        } else {
            $this->view->notice['error'] .= $this->model->error;
        }
    }
    
    public function actionComments()
    {
        $number = $this->model->number($_POST['number']);
        $this->view->data['comments'] = $number->comment;

        $this->view->htmlResponse('comments');
    }
    
    public function showNumber($number)
    {
        if ($this->view->data['number'] = $this->model->number($number)) {
                $this->view->notice['notice'] .= ' Информация извлечена. ';
        } else {
            $this->view->notice['error'] .= $this->model->error;
        }
    }
    
    protected function access()
    {
        return array(
            'index'       =>array('*'),
            'waiting'     =>array('O'),
            'request'     =>array('O'),
            'deny'        =>array('O'),
            'confirm'     =>array('O'),
            'waiting'     =>array('O'),
            'waiting'     =>array('O'),
            'change'      =>array('O'),
        );
    }
    
    
}