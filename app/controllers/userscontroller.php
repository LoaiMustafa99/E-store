<?php


namespace PHPMVC\CONTROLLERS;
use PHPMVC\MODELS\UserModel;

class UsersController extends AbstractController
{
    public function defaultAction()
    {
        $this->_language->load('template.common');
        $this->_language->load('users.default');
        $this->_data['users'] = UserModel::getAll();
        $this->_view();
    }

}