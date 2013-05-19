<?php
if (!defined('APP_PATH')) die('ERROR');

class E_PDO
{
    static private $_instance;
    private $_db_link;

    static public function singleton()
    {
        if (!isset(self::$_instance)) {
            $c = __CLASS__;
            self::$_instance = new $c;
        }
        return self::$_instance;
    }

    private function __construct()
    {
        $conf = E_Config::singleton()->get('db');
        $this->_db_link = new PDO('mysql:host=' . $conf['host'] . ';port=' . $conf['port'] . ';dbname=' . $conf['database'],
            $conf['username'],
            $conf['password'],
            array(PDO::ATTR_PERSISTENT => $conf['persistent']));
    }

    private function __clone()
    {

    }

    public function db()
    {
        return $this->_db_link;
    }
}