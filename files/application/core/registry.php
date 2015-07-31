<?php
/**
 * ����������� ����� registry
 */
class Registry 
{
    /**
     * ����������� ��������� ��� ������
     */
    protected static $store = array();
 
    /**
     * ������ �� �������� ����������� ������������ ������
     */
    protected function __construct() {}
    protected function __clone() {}
 
    /**
     * ��������� ���������� �� ������ �� �����
     *
     * @param string $name
     * @return bool
     */
    public static function exists($name) 
    {
    	return isset(self::$store[$name]);
    }
 
    /**
     * ���������� ������ �� ����� ��� null, ���� �� ������ ���
     *
     * @param string $name
     * @return unknown
     */
    public static function get($name) 
    {
        return (isset(self::$store[$name])) ? self::$store[$name] : null;
    }
 
    /**
     * ��������� ������ �� ����� � ����������� ���������
     *
     * @param string $name
     * @param unknown $obj
     * @return unknown
     */
    public static function set($name, $obj) 
    {
        return self::$store[$name] = $obj;
    }
}
?>