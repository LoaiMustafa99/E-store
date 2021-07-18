<?php
namespace PHPMVC\LIB;

class Messenger
{

    const APP_MESSAGE_SUCCESS   = 1;
    const APP_MESSAGE_ERROR     = 2;
    const APP_MESSAGE_WARNING   = 3;
    const APP_MESSAGE_INFO      = 4;

    private static $_instance;
    private $_session;
    private $_messages = [];

    private function __construct($session){
        $this->_session = $session;
    }

    private function __clone(){}

    public static function getInstance(SessionManager $session)
    {
        if(self::$_instance === null) {
            self::$_instance = new self($session);
        }
        return self::$_instance;
    }

    public function add($name, $message, $type = self::APP_MESSAGE_SUCCESS)
    {
        $name = $name . '_message';
        if(!$this->messagesExists($name)) {
            $data = [$message , $type];
            $this->_session->$name = $data;
            unset($data);
        }
    }

    private function messagesExists($name)
    {
        return isset($this->_session->$name);
    }

    public function addMulti(array $mses, $type = self::APP_MESSAGE_SUCCESS)
    {
        foreach ($mses as $key => $value)
        {
            $name = $key . '_message';
            if(!$this->messagesExists($name)) {
                $data = [$value , $type];
                $this->_session->$name = $data;
                unset($data);
            }
        }
    }


    public function getMessages($name)
    {
        $name = $name . '_message';
        if($this->messagesExists($name)) {
            $messages = $this->_session->$name;
            unset($this->_session->$name);
            return $messages;
        }
        return null;
    }

}