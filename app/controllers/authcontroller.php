<?php
namespace PHPMVC\CONTROLLERS;

use PHPMVC\LIB\Helper;
use PHPMVC\LIB\InputFilter;
use PHPMVC\LIB\Messenger;
use PHPMVC\MODELS\UserModel;
class AuthController extends AbstractController
{
    use InputFilter;
    use Helper;

    public function loginAction()
    {
        $this->language->load('auth.login');

        $this->_template->swapTemplate(
        [
            ':view' => ':action_view'
        ]);

        if(isset($_POST['login'])) {
            $username = $this->filterString($_POST['ucname']);
            $isAuthorized = UserModel::authenticate($username, $_POST['ucpwd'], $this->session);
            if($isAuthorized == 2) {
                $this->messenger->add('Login', $this->language->get('text_user_disabled'), Messenger::APP_MESSAGE_ERROR);
            }elseif ($isAuthorized == 1) {
                $this->redirect('/');
            }elseif($isAuthorized === false) {
                $this->messenger->add('Login', $this->language->get('text_user_not_found'), Messenger::APP_MESSAGE_ERROR);
            }
        }

        $this->_view();
    }

    public function logoutAction()
    {
        $this->session->kill();
        $this->redirect('/auth/login');
    }
}