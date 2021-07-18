<?php
namespace PHPMVC;
use PHPMVC\LIB\FrontController;
use PHPMVC\LIB\Language;
use PHPMVC\LIB\Messenger;
use PHPMVC\LIB\Registry;
use PHPMVC\LIB\SessionManager;
use PHPMVC\LIB\TEMPLATE\Template;
use PHPMVC\LIB\Validation;


if(!defined('DS')){
    define('DS', DIRECTORY_SEPARATOR);
}
require_once '..' . DS . 'app' . DS . 'config' . DS . 'config.php';
require_once APP_PATH . DS . 'lib' . DS . 'autoload.php';

$session = new SessionManager();
$session->start();

if(!isset($session->lang)) {
    $session->lang = APP_DEFAULT_LANGUAGE;
}

$template_parts = require_once '..' . DS . 'app' . DS . 'config' . DS . 'templateconfig.php';

$template = new Template($template_parts);

$language = new Language();

$messenger = Messenger::getInstance($session);

$validation = Validation::getInstance($messenger);

$registry = Registry::getInstance();
$registry->session = $session;
$registry->language = $language;
$registry->messenger = $messenger;
$registry->validate = $validation;

$frontcontroller = new FrontController($template, $registry);
$frontcontroller->dispatch();