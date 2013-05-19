<?
define('ENV', 'develop'); // product , develop

if ('product' == ENV) {
    ini_set('display_errors', 'Off');
    error_reporting(E_ERROR);
} else {
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
}