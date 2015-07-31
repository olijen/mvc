<?php
class ModelTools extends Model
{

    function __construct() {
        parent::__construct();
    }
    public function get_data()
    {
    }
    
    public function register($newUser)
    {
        //valid
        
        //add to DB
        $user = new Users($newUser);
        if ($id = $user->save(true)) {
            
        } else {
            $this->error = 'Object is not created';
            return false;
        }
        //add to session
        $_SESSION['usr']['obj'] = $user;
        $_SESSION['usr']['id']  = $id;
        //return somesin
        return $user;
    }

    public function login($userData)
    {   

        $query = 
        "SELECT * 
         FROM `users` 
         WHERE `username`={?} 
         AND `password`={?}";

        $params = array($userData['username'], md5($userData['password']));
        $user = $this->DB->selectRow($query, $params);

        if ($user) {
            //add to session
            $user = Users::getUserObj($user['id']);
            $_SESSION['usr']['obj'] = serialize($user);
            $_SESSION['usr']['id']  = $user->id;
            return $user;
        } else {
            $this->error = 'Данные не верны!';
            return false;
        }
    }
    
}