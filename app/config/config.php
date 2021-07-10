<?php
if(!defined('DS')){
    define('DS', DIRECTORY_SEPARATOR);
}

defined('APP_PATH') ? null : define('APP_PATH', realpath(dirname(__FILE__)) . DS . "..");

defined('VIEWS_PATH') ? null : define('VIEWS_PATH', APP_PATH . DS . 'views' . DS);
defined('TEMPLATE_PATH') ? null : define('TEMPLATE_PATH', APP_PATH . DS . 'template' . DS);
defined('CSS') ? null : define('CSS' , '/css/');
defined('JS') ? null : define('JS' , '/js/');
defined('LANGUAGES_PATH') ? null : define('LANGUAGES_PATH' , APP_PATH . DS . 'languages' . DS);

defined('DATABASE_HOST_NAME') ? null : define('DATABASE_HOST_NAME', 'localhost');
defined('DATABASE_USER_NAME') ? null : define('DATABASE_USER_NAME', 'root');
defined('DATABASE_PASSWORD') ? null : define('DATABASE_PASSWORD', '');
defined('DATABASE_DB_NAME') ? null : define('DATABASE_DB_NAME', 'php_pdo');
defined('DATABASE_PORT_NUMBER') ? null : define('DATABASE_PORT_NUMBER', 3306);
defined('DATABASE_CONN_DRIVER') ? null : define('DATABASE_CONN_DRIVER', 1);


defined('APP_DEFAULT_LANGUAGE') ? null : define('APP_DEFAULT_LANGUAGE', 'ar');