<?php
namespace PHPMVC\CONTROLLERS;
use PHPMVC\LIB\Helper;
use PHPMVC\LIB\InputFilter;
use PHPMVC\MODELS\UserGroupModel;
use PHPMVC\MODELS\UserModel;

class UsersController extends AbstractController
{
    use InputFilter;
    use Helper;

    private $_createActionRoles =
    [
        'Username'      => 'EmptyValue|alphanum|min(3)|max(12)',
        'Password'      => 'EmptyValue|min(6)',
        'CPassword'     => 'EmptyValue|min(6)',
        'Email'         => 'EmptyValue|email',
        'PhoneNumber'   => 'Number|max(10)',
        'GroupId'       => 'req|IntNumber'
    ];

    public function defaultAction()
    {
        $this->language->load('template.common');
        $this->language->load('users.default');
        $this->_data['users'] = UserModel::getAll();
        $this->_view();
    }

    public function addAction()
    {
        $this->language->load('template.common');
        $this->language->load('users.add');
        $this->language->load('users.label');

        $this->_data['groups'] = UserGroupModel::getAll();

        if(isset($_POST['submit']))
        {
            $_POST['UserExists'] = (UserModel::UserExists($_POST['Username']) !== false);
            $_POST['EmailExists'] = (UserModel::EmailExists($_POST['Email']) !== false);
            if($this->validate->user_Validation($_POST)) {
                $users = new UserModel();
                $users->Username = $this->filterString($_POST['Username']);
                $users->Password = $users->cryptPassword($_POST['Password']);
                $users->Email = $this->filterString($_POST['Email']);
                $users->PhoneNumber = $this->filterString($_POST['PhoneNumber']);
                $users->GroupId = $this->filterInt($_POST['GroupId']);
                $users->SubscriptionDate = date('Y-m-d');
                $users->LastLogin = date('Y-m-d H:i:s');
                $users->Status = 1;
            }else {

            }
        }

        $this->_view();
    }
}