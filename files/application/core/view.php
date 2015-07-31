<?php
class View
{
    public $test;
    
    public $blocks  = array();
    public $content = array();

    public $path   = array();
    public $user   = array();
    public $site   = array();
    public $data   = array();
    public $notice = array('error'=>'','notice'=>'');
    
    public function __construct()
    {
        $this->site = Registry::get('site');
        $this->path = Registry::get('pathConf');
        $this->user = Registry::get('user');
        
        $this->blocks = array(
            'head' => array('head'),
            'header' => array('header'),
            'footer' => array('footer'),
            'modal'  => array('modal'),
        );
    }
    
    public function content() {
        foreach ($this->content as $k => $name) {
            $dirr = (defined('MODDIR')) ? MODDIR : APPDIR;            
            $this->inclPath($dirr.'/views/'.Router::$ctrlName.'/view_'.$name.'.php', true);
        }
    }
    
    public function block($tpl)
    {
        //if (empty($tpl)) return;
        if (is_array($tpl)) {
            foreach ($tpl as $k => $name) {
                $this->inclPath(APPDIR.'/views/blocks/view_'.$name.'.php');
            }
        } else {
            $this->inclPath(APPDIR.'/views/blocks/view_'.$tpl.'.php');
        }
    }
    
    private function inclPath($path, $extract = false) {
        if (file_exists($path)) {
            if ($extract) {
                extract($this->data);
            }
            require_once $path;
        } else {
            echo '<br>[ FILE < '.$path.' > IS NOT EXISTS ]';
        }
    }
    
    function generate()
    {
        require_once APPDIR.'/views/layout.php';
    }
    
    public function htmlResponse($name, $block = 'modal')
    {
        $dirr = (defined('MODDIR')) ? MODDIR : APPDIR;            
        $this->inclPath($dirr.'/views/'.$block.'/view_'.$name.'.php', true);
    }
    
    public function jsonResponse()
    {
        $response = array(
            'data'=>$this->data,
            'notice'=>$this->notice['notice'],
            'error'=>$this->notice['error'],
            
        );
        echo json_encode($response, JSON_FORCE_OBJECT);
    }   
}