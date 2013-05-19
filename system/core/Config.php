<?php
if (!defined('APP_PATH')) die('APP_PATH');

class E_Config
{
    static private $_instance;
    private $_config;

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
    }

    private function __clone()
    {
    }

    public function get($name)
    {
        if (!isset($this->_config[$name])) {
            if (file_exists(APP_PATH . 'config/' . $name . '.php')) {
                include APP_PATH . 'config/' . $name . '.php';
                $res = $$name;
                $this->_config[$name] = isset($res[ENV]) ? $res[ENV] : (isset($res['default']) ? $res['default'] : NULL);
            }
        }
        return $this->_config[$name];
    }
}