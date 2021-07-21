<?php
namespace PHPMVC\LIB;


class Validation
{
    use Validate;

    private static $_instance;
    private $_message;
    private $_language;

    private function __construct($message, $language){
        $this->_message = $message;
        $this->_language = $language;
    }
    private function __clone(){}

    public static function getInstance(Messenger $message, Language $language)
    {
        if(self::$_instance === null)
            self::$_instance = new self($message, $language);
        return self::$_instance;
    }

    private function getError($key, $data){
        return $this->_language->feedKey($key, $data);
    }

    public function getLabelForm($label){
        return $this->_language->get("text_label_" . $label);
    }

    public function user_Validation($post)
    {
        $errors = [];
        if(isset($post['Username'])) {
            if (self::EmptyValue($post['Username'])) {
                $errors['field_error_username'] = $this->getError('text_error_form_empty', [$this->getLabelForm('Username')]);
            }else if(!self::between($post['Username'], 3, 12)) {
                $errors['field_error_username'] = $this->getError('text_error_form_between', [$this->getLabelForm('Username'), 3, 12]);
            }else if(isset($_POST['UserExists']) && $_POST['UserExists'] !== false) {
                $errors['field_error_username'] = $this->getError('text_error_form_alraedy_exsits', [$this->getLabelForm('Username')]);
            }
        }

        if(isset($post['FirstName'])) {
            if (self::EmptyValue($post['FirstName'])) {
                $errors['field_error_first_name'] = $this->getError('text_error_form_empty', [$this->getLabelForm('FirstName')]);
            }else if(!self::alpha($post['FirstName'])) {
                $errors['field_error_first_name'] = $this->getError('text_error_form_alpha', [$this->getLabelForm('FirstName')]);
            }else if(!self::between($post['FirstName'], 3, 10)) {
                $errors['field_error_first_name'] = $this->getError('text_error_form_between', [$this->getLabelForm('FirstName'), 5, 10]);
            }
        }

        if(isset($post['LastName'])) {
            if (self::EmptyValue($post['LastName'])) {
                $errors['field_error_last_name'] = $this->getError('text_error_form_empty', [$this->getLabelForm('LastName')]);
            }else if(!self::alpha($post['LastName'])) {
                $errors['field_error_last_name'] = $this->getError('text_error_form_alpha', [$this->getLabelForm('LastName')]);
            }else if(!self::between($post['LastName'], 3, 10)) {
                $errors['field_error_last_name'] = $this->getError('text_error_form_between', [$this->getLabelForm('LastName'), 5, 10]);
            }
        }


        if(isset($post['Email'])) {
            if (self::EmptyValue($post['Email'])) {
                $errors['field_error_email'] = $this->getError('text_error_form_empty', [$this->getLabelForm('Email')]);
            }else if(!self::validEmail($post['Email'])) {
                $errors['field_error_email'] = $this->getError('text_error_form_email', [$this->getLabelForm('Email')]);
            }else if(isset($_POST['EmailExists']) && $_POST['EmailExists'] !== false) {
                $errors['field_error_email'] = $this->getError('text_error_form_alraedy_exsits', [$this->getLabelForm('Email')]);
            }
        }

        if(!isset($_POST['oldPassword'])){
            if(isset($post['Password'])){
                if(self::EmptyValue($post['Password'])){
                    $errors['filed_error_password'] = $this->getError('text_error_form_empty', [$this->getLabelForm('Password')]);
                }else if(!self::Passwordvalidate($post['Password'])){
                    $errors['filed_error_password'] = $this->getError('text_error_form_password', [$this->getLabelForm('Password')]);
                }else if(self::EmptyValue($post['CPassword'])){
                    $errors['filed_error_confirm_password'] = $this->getError('text_error_form_empty', [$this->getLabelForm('CPassword')]);
                }else if($post['Password'] !== $post['CPassword']){
                    $errors['filed_error_confirm_password'] = $this->getError('text_error_form_c_password', [$this->getLabelForm('CPassword'), $this->getLabelForm('Password')]);
                }
            }
        }else{
//            if(!empty($_POST['dbpassword'])){
//                if(self::EmptyValue($_POST['oldpassword'])){
//                    $errors['filed_error_oldpassword'] = $this->getError('text_error_form_empty', [$this->getLabelForm('oldpassword')]);
//                } else if(!password_verify($_POST['oldpassword'], $_POST['dbpassword'])){
//                    $errors['filed_error_oldpassword'] = '';
//                }
//
//                if(self::EmptyValue($post['Password'])){
//                    $errors['filed_error_password'] = $this->getError('text_error_form_empty', [$this->getLabelForm('Password')]);
//                }else if(!self::Passwordvalidate($post['Password'])){
//                    $errors['filed_error_password'] = $this->getError('text_error_form_password', [$this->getLabelForm('Password')]);
//                }else if(self::EmptyValue($post['CPassword'])){
//                    $errors['filed_error_confirm_password'] = $this->getError('text_error_form_empty', [$this->getLabelForm('CPassword')]);
//                }else if($post['Password'] !== $post['CPassword']){
//                    $errors['filed_error_confirm_password'] = $this->getError('text_error_form_c_password', [$this->getLabelForm('CPassword'), $this->getLabelForm('Password')]);
//                }
//            }

        }

        if(isset($post['PhoneNumber']) && $post['PhoneNumber'] != null){
            if(!self::phonenumber($post['PhoneNumber'])){
                $errors['field_error_phone_number'] = $this->getError('text_error_form_phonenumber', [$this->getLabelForm('PhoneNumber')]);
            }
        }

        if(isset($post['GroupId'])) {
            if(self::EmptyValue($post['GroupId'])) {
                $errors['field_error_group_id'] = $this->getError('text_error_form_empty', [$this->getLabelForm('GroupId')]);
            }elseif(!self::IntNumber($post['GroupId'])) {
                $errors['field_error_group_id'] = $this->getError('text_error_form_number', [$this->getLabelForm('GroupId')]);
            }
        }

        if(empty($errors)) {
            return true;
        } else {
            $this->_message->addMulti($errors);
            return false;
        }
    }

}