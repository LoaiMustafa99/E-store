<?php
namespace PHPMVC\LIB;


class Authentication
{
    private static $_instance;
    private $_session;
    private $_execludedRoutes =
    [
        '/index/default',
        '/auth/login',
        '/auth/logout',
        '/users/profile',
        'users/changepassword',
        '/accessdenied/default',
        '/notfound/notfound',
        '/language/default'

    ];

    private function __construct($session)
    {
        $this->_session = $session;
    }
    private function __clone()
    {
    }

    public static function getInstance(SessionManager $session)
    {
        if(self::$_instance === null) {
            self::$_instance = new self($session);
        }
        return self::$_instance;
    }


    public function isAuthorized()
    {
        return isset($this->_session->u);
    }

    public function hasAccess($controller, $action)
    {
        $url = '/' . $controller . '/' . $action;
        if (in_array($url, $this->_execludedRoutes) || in_array($url, $this->_session->u->privileges)) {
            return true;
        }
    }

}