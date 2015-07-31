<?php
class ControllerDynamic extends Controller
{
    public function __construct()
    {
        parent::__construct();
        ini_set('max_execution_time', 0);
        session_write_close();
        ignore_user_abort();
    }

    public function actionIndex()
    {
        if (!isset($_POST['max_id'])) {
            echo 'max_id is empty';
        } elseif (!isset($_POST['last_id'])) {
            echo 'last_id is empty';
        } else {
            if ($response = $this->model->main($_POST['max_id'], $_POST['last_id'])) {
                echo json_encode($response, JSON_FORCE_OBJECT);
            } else {
                echo 'some error';
            }
        }
    }

    protected function access()
    {
        return array(
            'index' => array('*'),
        );
    }
}