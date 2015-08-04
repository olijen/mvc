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
        $newUser['password'] = md5($newUser['password']);
        
        //add to DB
        $user = new Users($newUser);
        
        if ($id = $user->save(true)) {
            
        } else {
            $this->error = 'Пользователь НЕ зарегистрирован';
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
    
    public function migrate()
    {
        $sql = file_get_contents(ROOTDIR.'/application/migration.sql');
        $sql = str_replace('<<database>>', DB_NAME, $sql);
        return $sql;
    }
    
    public function migrateUp()
    {
        $sql = file_get_contents(ROOTDIR.'/application/migration.sql');
        $sql = str_replace('<<database>>', DB_NAME, $sql);
        
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PWD)
            or die("Нет коннекта к БД: " . mysqli_error($mysqli));
        echo "Драйвер соединился с БД. Создаю базу " . DB_NAME . '<br />';
        
        $mysqli->query('CREATE DATABASE IF NOT EXISTS '.DB_NAME)
            or die("База не создана: " . mysqli_error($mysqli));
        echo "База создана. Подключаюсь...<br />";
        
        $mysqli->select_db(DB_NAME);    
        $mysqli->query($sql)
            or die("Таблица не создана: " . mysqli_error($mysqli));
        echo "Применяю миграцию...<br />";
        echo "Готово! <a href='/'>[Назад]</a><br />";
        echo "Теперь Вы можете <a href='/tools/register/'>зарегистрировать первого пользователя</a>";    
        //$mysqli->query($sql)
            //or die("Таблица 'users' не создана: " . mysqli_error($mysqli));
        
        
        /*if (mysql_create_db(DB_NAME)) {
            print ("Database created successfully\n");
        } else {
            printf ("Error creating database: %s\n", mysql_error());
        }
        */
        //$DB = DataBase::getDB();
        //$DB->query($sql);
    }
}