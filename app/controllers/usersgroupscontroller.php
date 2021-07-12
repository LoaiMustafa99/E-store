<?php


namespace PHPMVC\CONTROLLERS;

use PHPMVC\MODELS\UserGroupModel;

class UsersGroupsController extends AbstractController
{
    public function defaultAction()
    {
        $this->_language->load('template.common');
        $this->_language->load('usersgroups.default');
        $this->_data['groups'] = UserGroupModel::getAll();
        $this->_view();
    }

}