<?php

namespace PHPMVC\LIB;

use PHPMVC\LIB\TEMPLATE\Template;

class FrontController
{

    const NOT_FOUND_ACTION = "notFoundAction";
    const NOT_FOUND_CONTROLLER = "PHPMVC\CONTROLLERS\NotFoundController";

    private $_controllers ='index';
    private $_action = "default";
    private $_params = array();

    private $_registry;
    private $_template;

    public function __construct(Template $template, Registry $registry)
    {
        $this->_template = $template;
        $this->_registry = $registry;
        $this->_parseUrl();;
    }

    private function _parseUrl()
    {
        $url = explode('/' ,trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'), 3);
        if(isset($url[0]) && $url[0] != ''){
            $this->_controllers = $url[0];
        }
        if(isset($url[1]) && $url[1] != ''){
            $this->_action = $url[1];
        }
        if(isset($url[2]) && $url[2] != ''){
            $this->_params = explode('/', $url[2]);
        }
    }

    public function dispatch()
    {
        $controllerClassName = 'PHPMVC\CONTROLLERS\\' . ucfirst(trim($this->_controllers , '.php')) . 'Controller';
        $actionName = $this->_action . 'Action';
        if(!class_exists($controllerClassName) || !method_exists($controllerClassName, $actionName)) {
            $controllerClassName = self::NOT_FOUND_CONTROLLER;
            $this->_action = $actionName = self::NOT_FOUND_ACTION;
        }

        $controller = new $controllerClassName();
        $controller->setControler($this->_controllers);
        $controller->setAction($this->_action);
        $controller->setParams($this->_params);
        $controller->setTemplate($this->_template);
        $controller->setRegistry($this->_registry);
        $controller->$actionName();
    }
}