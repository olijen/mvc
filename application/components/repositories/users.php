<?php

class Users extends AbstractTable
{
	public $id          = NULL;
	public $username    = NULL;
    public $fio         = NULL;
	public $password    = NULL;
	public $status      = NULL;


    public function save($new = false)
    {
        if (parent::save($new)) {
            $_SESSION['usr']['upd'] = 1;
            return true;
        } else return false;
    }
    
	public static function getUserObj($value, $what = '*', $column = '`id`')
	{
	    $DB = DataBase::getDB();
        $query = 
        " SELECT ".$what.
        " FROM `users` ".
        " WHERE ".$column." = {?}";
        
        $params = array($value);
        
		$userData = $DB->selectRow($query, $params);
        
		if (!empty($userData)) {
			return new Users($userData);
		} else {
			return false;
		}
	}
 }