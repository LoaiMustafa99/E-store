<?php
namespace PHPMVC\CONTROLLERS;
use PHPMVC\LIB\Helper;
use PHPMVC\LIB\InputFilter;
use PHPMVC\LIB\Messenger;
use PHPMVC\MODELS\UserGroupModel;
use PHPMVC\MODELS\UserModel;

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

        $this->_data['groups'] = UserGroupModel::getAll();

        if(isset($_POST['submit']))
        {
            $_POST['UserExists'] = (UserModel::UserExists($_POST['Username']) !== false);
            $_POST['EmailExists'] = (UserModel::EmailExists($_POST['Email']) !== false);
            if($this->validate->user_Validation($_POST)) {
                $users = new UserModel();
                $users->Username = $this->filterString($_POST['Username']);
                $users->Password = password_hash($_POST['Password'], PASSWORD_DEFAULT);
                $users->Email = $this->filterString($_POST['Email']);
                $users->PhoneNumber = $this->filterString($_POST['PhoneNumber']);
                $users->GroupId = $this->filterInt($_POST['GroupId']);
                $users->SubscriptionDate = date('Y-m-d');
                $users->LastLogin = date('Y-m-d H:i:s');
                $users->Status = 1;

                if($users->save()) {
                    $this->messenger->add('Users', 'تم الحفظ بنجاح');
                    $this->redirect('/users');
                }else{
                    $this->messenger->add('Users', 'حدث خطاء في حفظ المستخدم', Messenger::APP_MESSAGE_ERROR);
                    $this->redirect('/users');
                }
            }
        }

        $this->_view();
    }
}