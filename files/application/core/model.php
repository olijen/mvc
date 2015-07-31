<?php
class Model
{
    protected $DB;
    public $error;
    function __construct()
    {
        $this->DB = DataBase::getDB();
    }
}