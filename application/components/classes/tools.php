<?php
class Tools
{
    public static function getSiteData()
    {
        $DB = DataBase::getDB();
        $query = 
        " SELECT `id` ".
        " FROM `users` ";
        $site['total_users'] = count($DB->select($query));
        
        $query = 
        " SELECT `username` ".
        " FROM `users` ".
        " WHERE (`login_time` + 30*60) > ".time();
        
        $site['online_users'] = $DB->select($query);
        $site['online_count'] = count($site['online_users']);
        
       Registry::set('site', (object)$site);
    }
    
    public static function getUserData()
    {
        $logged = false;
        if (isset($_SESSION['usr']['id'])) {
            if (!empty($_SESSION['usr']['upd'])) {
                $user = Users::getObj($_SESSION['usr']['id']);
                $_SESSION['usr']['obj'] = serialize($user);
                $_SESSION['usr']['upd'] = 0;
            } else {
                $user = unserialize($_SESSION['usr']['obj']);
            }
            Registry::set('user', $user);
            $logged = true;
        }
        define('LOGGED', $logged);
    }
    
    public static function getSiteConfig()
    {
        define("SITENAME", "http://".$_SERVER["HTTP_HOST"]);
        define("ROOTDIR",  $_SERVER['DOCUMENT_ROOT']);
        define("APPDIR",   ROOTDIR.'/application');
        define("FRONTDIR", ROOTDIR.'/front');
        
        define('DB_NAME', 'my_db');
        define('DB_USER', 'root');
        define('DB_HOST', 'localhost');
        define('DB_PWD',  '');
    }
    
    public function getAccessData()//For special status
    {
        $G = true;
        $L = $A = false;

        
        if (LOGGED) {
            $L = true;
            $G = false;
            $user = Registry::get('user');
            if ($user->status == 'admin') {
                $A = true;
            }
        }
        define('G', $G); define('L', $L); define('A', $A);
    }
         
    public static function sendMail($from = false, $for, $topic, $message)
    {
        if (!$from) $from = SITENAME;
            
        $headers      = "Content-type: text/html; charset=utf-8 \r\nFrom: ".$from;;
        $date         = "'".date("Y-m-d H:i:s",time())."'";  
        $fool_message = "Вам написал: <font color=grey>".$from."</font><hr />".
                        "Дата: <font color=grey>".$date."</font><hr />".
                        "Тема обращения: <font color=grey>".$topic."</font><hr />".
                        "<h2><center>Сообщение:</center></h2><hr /> ".$message;
        if (mail($for, $topic, $fool_message, $headers)) {
            return true;
        }
    }
}