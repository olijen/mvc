<?php
class ControllerMain extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function actionIndex()
    {
        $this->view->content = array('main');
        $this->view->generate();
    }

    protected function access()
    {
        return array(
            'index'       =>array('*'),
        );
    }
}