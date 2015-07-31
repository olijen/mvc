<?php
##Описание класса БД - коннект, ввод, апдейт.
class DB {
    //mysqldump –h igrolan.com –u igrolanc_root –p igrolanc_db > dump.sql
    protected $db_name = DB_NAME;
    protected $db_user = DB_USER;
    protected $db_pass = DB_PWD;
    protected $db_host = DB_HOST;
    //------------------------------------------------------ CONNECT
    public function connect()
	{
    	$connection = mysql_pconnect($this->db_host, $this->db_user, $this->db_pass) or die('error1');
    	mysql_select_db($this->db_name) or die('error2');
    	return true;
    }
    //------------------------------------------------------ GET ARRAY
    public function get_array($rowSet, $singleRow = false)
	{
    //Второй аргумент для однострочных массивов
    	$resultArray = array();
    	while ($row = mysql_fetch_assoc($rowSet)) {
    		array_push($resultArray, $row);
    	}
    	if($singleRow === true){
    		return $resultArray[0];
    	}
    	return $resultArray;
    }
    //------------------------------------------------------ SELECT
    public function select($sql)
	{
    	$result = mysql_query($sql);
    	return $this->get_array($result);
    }
    //------------------------------------------------------ SELECT_ROW
    public function select_row($sql)
	{
    	$result = mysql_query($sql);
        return $this->get_array($result, true);
    }
    //------------------------------------------------------ UPDATE
    public function update($data, $table, $where)
	{
    	foreach ($data as $column => $value){
    		$sql = "UPDATE $table SET $column = $value WHERE $where";
    		mysql_query($sql) or die(mysql_error());
    	}
    	return true;
    }
    //------------------------------------------------------ UPDATE ONCE
    public function update_once($table, $column, $value, $where)
	{
        $sql = "UPDATE $table SET $column = $value WHERE $where";
    	mysql_query($sql) or die(mysql_error());
    	return true;
    }
    //------------------------------------------------------ DELETE
    public function delete($table, $where)
	{//DELETE
    	$sql = "DELETE FROM $table WHERE $where";
        mysql_query($sql) or die(mysql_error());
    	return true;
    }
    //------------------------------------------------------ INSERT
    public function insert($data, $table)
	{//Добавление новой строки в БД
    	$columns = "";
    	$values = "";
    	foreach  ($data as $column => $value) {
    		      $columns .= ($columns == "") ? "" : ", ";
    		      $columns .= $column;
    		      $values  .= ($values == "") ? "" : ", ";
    		      $values  .= $value;
    	}
    	$sql = "insert into $table ($columns) values ($values)";
    	mysql_query($sql) or die(mysql_error());
    	//Выводит ID пользователя в БД.
    	return mysql_insert_id();
    }
    //end class
}

?>