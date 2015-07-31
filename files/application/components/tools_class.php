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

       Registry::set('site', $site); 
    }
    
    public static function getUserData()
    {
        $logged = false;
        if (isset($_SESSION['usr']['id'])) {
            if (!empty($_SESSION['usr']['upd'])) {
                $user = Users::getUserObj($_SESSION['usr']['id']);
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
        $pathConf = array (
        //----------
            'site' => "http://".$_SERVER["HTTP_HOST"],
            'root' => $_SERVER['DOCUMENT_ROOT'],
            'app'  => $_SERVER['DOCUMENT_ROOT'].'/application',
            'front'=> $_SERVER['DOCUMENT_ROOT'].'/front'
        //----------
        );
        $dbConf = array (
        //----------
            'name' => 'levazzz_scard',//'igrolanc_db',
            'host' => 'localhost',
            'user' => 'levazzz_scard',
            'pwd'  => '123456789'
        //----------
        );
        Registry::set('pathConf', $pathConf);
        Registry::set('dbConf', $dbConf);
        
        $num_status = array('--', 'Недозвон', 'Заявка', 'Отказ', 'Договор', 'Перезвонить');
        Registry::set('num_status', $num_status);
        
        //---OLD
        define("SITENAME", "http://".$_SERVER["HTTP_HOST"]);
        define("ROOTDIR", $_SERVER['DOCUMENT_ROOT']);
        define("APPDIR", ROOTDIR.'/application');
        
        define('DB_NAME', 'levazzz_scard');//'ledstor_igrolan');
        define('DB_USER', 'levazzz_scard');//'ledstor');
        define('DB_HOST', 'localhost');//'localhost');
        define('DB_PWD',  '123456789');
    }
    
    public function getAccessData()
    {
        $G = true;
        $L = $O = $A = false;

        
        if (LOGGED) {
            $L = true;
            $G = false;
            $user = Registry::get('user');
            if ($user->status == 'operator') {
                $O = true;
            }
            if ($user->status == 'admin') {
                $A = true;
            }
        }
        define('G', $G); define('L', $L); define('O', $O); define('A', $A);
    }
         
    public static function send($from, $for, $topic, $message)
    {
        $headers      = "Content-type: text/html; charset=utf-8 \r\n";//кодировка
        $headers     .= "From: ".$from;//от кого

        $date         = "'".date("Y-m-d H:i:s",time())."'";  
        $fool_message = "Вам написал: <font color=grey>".$from."</font><hr />".
                        "Дата: <font color=grey>".$date."</font><hr />".
                        "Тема обращения: <font color=grey>".$topic."</font><hr />".
                        "<h2><center>Сообщение:</center></h2><hr /> ".$message;
                        //"igrolan.info@mail.ru";//от кого
        if (mail($for, $topic, $fool_message, $headers)) {
            return true;
        }
    }
}