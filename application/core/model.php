<?php
class Model
{
    protected $DB;
    public $error;
    
    function __construct()
    {
        if (!Registry::get('mysql_error'))
            $this->DB = DataBase::getDB();
    }
}