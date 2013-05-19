<?php
include 'env.php';
if (!defined('ENV')) dir('Error');

define('ROOT_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
define('APP_PATH', ROOT_PATH . 'application' . DIRECTORY_SEPARATOR);
define('SYSTEM_PATH', ROOT_PATH . 'system' . DIRECTORY_SEPARATOR);

include SYSTEM_PATH . 'core/Config.php';
include SYSTEM_PATH . 'db/PDO.php';

// user custom
include APP_PATH . 'func/common.php';
