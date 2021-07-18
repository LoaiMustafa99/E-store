<?php
namespace PHPMVC\LIB;


class Validation
{
    use Validate;

    private static $_instance;
    private $_message;

    private function __construct($message){
        $this->_message = $message;
    }
    private function __clone(){}

    public static function getInstance(Messenger $message)
    {
        if(self::$_instance === null)
            self::$_instance = new self($message);
        return self::$_instance;
    }

    public function user_Validation($post)
    {
        $errors = [];
        if(isset($post['Username'])) {
            if (self::EmptyValue($post['Username'])) {
                $errors['field_error_username'] = 'اكتب اسمك داخل الحقل';
            }else if(!self::between($post['Username'], 3, 12)) {
                $errors['field_error_username'] = 'يجب ان يكون الاسم من 3 الى 12 حرف';
            }else if(isset($_POST['UserExists']) && $_POST['UserExists'] !== false) {
                $errors['field_error_username'] = 'هذا الاسم موجود بلفعل';
            }
        }

        if(isset($post['Email'])) {
            if (self::EmptyValue($post['Email'])) {
                $errors['field_error_email'] = 'اكتب ايميلك داخل الحقل';
            }else if(!self::validEmail($post['Email'])) {
                $errors['field_error_email'] = 'اكتب الايميل بشكل صحيح';
            }else if(isset($_POST['EmailExists']) && $_POST['EmailExists'] !== false) {
                $errors['field_error_email'] = 'هذا الايميل موجود بلفعل';
            }
        }

//        if(!isset($_POST['oldPassword'])){
//            if(isset($post['newpassword'])){
//                if(self::Empty_validate($post['newpassword'])){
//                    $errors['form_filed_error_newpassword'] = $this->getError("text_error_form_empty", [$this->getLabelForm("newpassword")]);
//                }else if(!self::Password_validate($post['newpassword'])){
//                    $errors['form_filed_error_newpassword'] = $this->getError("text_error_form_newpassword", [$this->getLabelForm("newpassword")]);
//                }else if(self::Empty_validate($post['c_newpassword'])){
//                    $errors['form_filed_error_confirm_newpassword'] = $this->getError("text_error_form_empty", [$this->getLabelForm("confirm_newpassword")]);;
//                }else if($post['newpassword'] !== $post['c_newpassword']){
//                    $errors['form_filed_error_confirm_newpassword'] = $this->getError("text_error_form_c_newpassword", [$this->getLabelForm("confirm_newpassword"),$this->getLabelForm("newpassword")]);;
//                }
//            }
//        }else{
//            if(!empty($_POST['dbpassword'])){
//                if(self::Empty_validate($_POST['oldpassword'])){
//                    $errors['form_filed_error_oldpassword'] = $this->getError("text_error_form_empty", [$this->getLabelForm("oldpassword")]);
//                } else if(!password_verify($_POST['oldpassword'], $_POST['dbpassword'])){
//                    $errors['form_filed_error_oldpassword'] = $this->getError("text_error_form_oldpassword", [$this->getLabelForm("oldpassword")]);
//                }
//
//                if(self::Empty_validate($post['newpassword'])){
//                    $errors['form_filed_error_newpassword'] = $this->getError("text_error_form_empty", [$this->getLabelForm("newpassword")]);
//                }else if(!self::Password_validate($post['newpassword'])){
//                    $errors['form_filed_error_newpassword'] = $this->getError("text_error_form_newpassword", [$this->getLabelForm("newpassword")]);
//                }else if(self::Empty_validate($post['c_newpassword'])){
//                    $errors['form_filed_error_confirm_newpassword'] = $this->getError("text_error_form_empty", [$this->getLabelForm("confirm_newpassword")]);;
//                }else if($post['newpassword'] !== $post['c_newpassword']){
//                    $errors['form_filed_error_confirm_newpassword'] = $this->getError("text_error_form_c_newpassword", [$this->getLabelForm("confirm_newpassword"),$this->getLabelForm("newpassword")]);;
//                }
//            }
//
//        }

        if(isset($post['PhoneNumber'])){
            if (self::EmptyValue($post['PhoneNumber'])) {
                $errors['field_error_phone_number'] = 'رقم الهاتف لا يجب ان يكون فارغ';
            }elseif(!self::phonenumber($post['PhoneNumber'])){
                $errors['field_error_phone_number'] = 'يجب ان يكون رقم الهاتف هكذا (8 + 078|077|079) ';
            }
        }

        if(isset($post['GroupId'])) {
            if(self::EmptyValue($post['GroupId'])) {
                $errors['field_error_group_id'] = 'يجب ان تختار مجموعة';
            }elseif(!self::IntNumber($post['GroupId'])) {
                $errors['field_error_group_id'] = 'يجب ان يكون رقم';
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