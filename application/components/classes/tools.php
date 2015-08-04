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
    
    public static function checkDatabase()
    {
        $mysqli = @mysqli_connect(DB_HOST, DB_USER, DB_PWD, DB_NAME);
        if (mysqli_connect_errno($mysqli))
            Registry::set('mysql_error', "Не удалось подключиться к MySQL: " . mysqli_connect_error());
        
        Registry::set('mysqli', $mysqli);
    }
    
    public static function getUserData()
    {
        $logged = false;
        if (!empty($_SESSION['usr']['obj']) && is_string($_SESSION['usr']['obj']))
            $bool = unserialize($_SESSION['usr']['obj']);
        if (isset($_SESSION['usr']['id']) && !empty($bool)) {
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
        require $_SERVER['DOCUMENT_ROOT'].'/application/config.php';
    }
    
    public static function getAccessData()//For special status
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