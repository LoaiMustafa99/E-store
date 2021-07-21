<?php
namespace PHPMVC\CONTROLLERS;
use PHPMVC\LIB\Helper;
use PHPMVC\LIB\InputFilter;
use PHPMVC\LIB\Messenger;
use PHPMVC\MODELS\UserGroupModel;
use PHPMVC\MODELS\UserModel;
use PHPMVC\MODELS\UserProfileModel;

class UsersController extends AbstractController
{
    use InputFilter;
    use Helper;

    public function defaultAction()
    {
        $this->language->load('template.common');
        $this->language->load('users.default');
        $this->_data['users'] = UserModel::getUsers();
        $this->_view();
    }

    public function addAction()
    {
        $this->language->load('validation.errors');
        $this->language->load('template.common');
        $this->language->load('users.add');
        $this->language->load('users.label');
        $this->language->load('users.messages');

        $this->_data['groups'] = UserGroupModel::getAll();

        if(isset($_POST['submit']))
        {
            $_POST['UserExists'] = (UserModel::UserExists($_POST['Username']) !== false);
            $_POST['EmailExists'] = (UserModel::EmailExists($_POST['Email']) !== false);
            if($this->validate->user_Validation($_POST)) {
                $users = new UserModel();
                $users->Username = $this->filterString($_POST['Username']);
                $users->hashPassword($_POST['Password']);
                $users->Email = $this->filterString($_POST['Email']);
                $users->PhoneNumber = $this->filterString($_POST['PhoneNumber']);
                $users->GroupId = $this->filterInt($_POST['GroupId']);
                $users->SubscriptionDate = date('Y-m-d');
                $users->LastLogin = date('Y-m-d H:i:s');
                $users->Status = 1;

                if($users->save()) {
                    $userprofile = new UserProfileModel();
                    $userprofile->UserId = $users->UserId;
                    $userprofile->FirstName = $this->filterString($_POST['FirstName']);
                    $userprofile->LastName  = $this->filterString($_POST['LastName']);
                    $userprofile->save(false);
                    $this->messenger->add('Users', $this->language->get('message_create_success'));
                }else{
                    $this->messenger->add('Users', $this->language->get('message_create_failed'), Messenger::APP_MESSAGE_ERROR);
                }
                $this->redirect('/users');
            }
        }

        $this->_view();
    }

    public function editAction()
    {
        $id = $this->filterInt($this->_params[0]);
        $user = UserModel::getByID($id);

        if($user == false) {
            $this->redirect('/users');
        }

        $this->_data['user'] = $user;

        $this->language->load('validation.errors');
        $this->language->load('template.common');
        $this->language->load('users.edit');
        $this->language->load('users.label');
        $this->language->load('users.messages');

        $this->_data['groups'] = UserGroupModel::getAll();

        if(isset($_POST['submit']))
        {
            if($this->validate->user_Validation($_POST)) {

                $user->PhoneNumber = $this->filterString($_POST['PhoneNumber']);
                $user->GroupId = $this->filterInt($_POST['GroupId']);

                if($user->save()) {
                    $this->messenger->add('Users', $this->language->get('message_create_success'));
                    $this->redirect('/users');
                }else{
                    $this->messenger->add('Users', $this->language->get('message_create_failed') , Messenger::APP_MESSAGE_ERROR);
                    $this->redirect('/users');
                }
            }
        }

        $this->_view();
    }

    public function deleteAction()
    {
        $id = $this->filterInt($this->_params[0]);
        $user = UserModel::getByID($id);
        if($user == false) {
            $this->redirect('/users');
        }

        $this->language->load('users.messages');

        if($user->delete()) {
            $this->messenger->add('Users', $this->language->get('message_delete_success'));
        }else{
            $this->messenger->add('Users', $this->language->get('message_delete_failed'), Messenger::APP_MESSAGE_ERROR);
        }
        $this->redirect('/users');
    }

    public function checkUserExistsAjaxAction()
    {
        if(isset($_POST['Username'])) {
            header('Content-type: text/plain');
            if(UserModel::UserExists($this->filterString($_POST['Username'])) !== false) {
                echo 1;
            } else {
                echo 2;
            }
        }
    }

    public function checkEmailExistsAjaxAction()
    {
        if(isset($_POST['Email'])) {
            header('Content-type: text/plain');
            if(UserModel::EmailExists($this->filterString($_POST['Email'])) !== false) {
                echo 1;
            } else {
                echo 2;
            }
        }
    }
}