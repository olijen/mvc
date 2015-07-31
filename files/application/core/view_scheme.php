<?php
define('S', 'subdirr');
$this->viewScheme = array(
//-------------------------------------
    'head'=>array(),
    'header'=>array(
      'subdirr'=>array(     
      )
    ),
//-------------------------------------    
    'content'=>array(

    )
);
if (LOGGED) {
    $this->viewScheme['header'][S]['authorized'] = array();
} else {
    $this->viewScheme['header'][S]['not_authorized'] = array();
}