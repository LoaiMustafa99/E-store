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
            }else if(!self::IntNumber($post['GroupId'])) {
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

    public function supplier_and_client_Validation($post)
    {
        $errors = [];

        if(isset($post['Name'])) {
            if (self::EmptyValue($post['Name'])) {
                $errors['field_error_name'] = $this->getError('text_error_form_empty', [$this->getLabelForm('Name')]);
            }else if(!self::between($post['Name'], 3, 40)) {
                $errors['field_error_name'] = $this->getError('text_error_form_between', [$this->getLabelForm('Name'), 3, 40]);
            }else if(!self::alpha($post['Name'])) {
                $errors['field_error_name'] = $this->getError('text_error_form_alpha', [$this->getLabelForm('Name')]);
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

        if(isset($post['PhoneNumber'])){
            if (self::EmptyValue($post['PhoneNumber'])) {
                $errors['field_error_phone_number'] = $this->getError('text_error_form_empty', [$this->getLabelForm('PhoneNumber')]);
            }else if(!self::phonenumber($post['PhoneNumber'])){
                $errors['field_error_phone_number'] = $this->getError('text_error_form_phonenumber', [$this->getLabelForm('PhoneNumber')]);
            }
        }

        if(isset($post['Address'])){
            if (self::EmptyValue($post['Address'])) {
                $errors['field_error_address'] = $this->getError('text_error_form_empty', [$this->getLabelForm('Address')]);
            }else if(!self::between($post['Address'], 5, 50)) {
                $errors['field_error_address'] = $this->getError('text_error_form_between', [$this->getLabelForm('Address'), 5, 50]);
            }
        }


        if(empty($errors)) {
            return true;
        } else {
            $this->_message->addMulti($errors);
            return false;
        }
    }

    public function product_category_Validation($post) {
        $errors = [];

        if(isset($post['Name'])) {
            if (self::EmptyValue($post['Name'])) {
                $errors['field_error_name'] = $this->getError('text_error_form_empty', [$this->getLabelForm('Name')]);
            } else if (!self::between($post['Name'], 3, 40)) {
                $errors['field_error_name'] = $this->getError('text_error_form_between', [$this->getLabelForm('Name'), 3, 40]);
            } else if (!self::alpha($post['Name'])) {
                $errors['field_error_name'] = $this->getError('text_error_form_alpha', [$this->getLabelForm('Name')]);
            }
        }

        if(empty($errors)) {
            return true;
        } else {
            $this->_message->addMulti($errors);
            return false;
        }

    }

    public function product_Validation($post) {
        $errors = [];

        if(isset($post['Name'])) {
            if (self::EmptyValue($post['Name'])) {
                $errors['field_error_name'] = $this->getError('text_error_form_empty', [$this->getLabelForm('Name')]);
            } else if (!self::between($post['Name'], 3, 50)) {
                $errors['field_error_name'] = $this->getError('text_error_form_between', [$this->getLabelForm('Name'), 3, 50]);
            } else if (!self::alpha($post['Name'])) {
                $errors['field_error_name'] = $this->getError('text_error_form_alpha', [$this->getLabelForm('Name')]);
            }
        }

        if(isset($post['CategoryId'])) {
            if (self::EmptyValue($post['CategoryId'])) {
                $errors['field_error_category_id'] = $this->getError('text_error_form_empty', [$this->getLabelForm('CategoryId')]);
            }else if(!self::IntNumber($post['CategoryId'])) {
                $errors['field_error_category_id'] = $this->getError('text_error_form_number', [$this->getLabelForm('CategoryId')]);
            }
        }

        if(isset($post['BuyPrice'])) {
            if (self::EmptyValue($post['BuyPrice'])) {
                $errors['field_error_buy_price'] = $this->getError('text_error_form_empty', [$this->getLabelForm('BuyPrice')]);
            }else if(!self::IntNumber($post['BuyPrice'])) {
                $errors['field_error_buy_price'] = $this->getError('text_error_form_number', [$this->getLabelForm('BuyPrice')]);
            }
        }

        if(isset($post['Quantity'])) {
            if (self::EmptyValue($post['Quantity'])) {
                $errors['field_error_quantity'] = $this->getError('text_error_form_empty', [$this->getLabelForm('Quantity')]);
            }else if(!self::IntNumber($post['Quantity'])) {
                $errors['field_error_quantity'] = $this->getError('text_error_form_number', [$this->getLabelForm('Quantity')]);
            }
        }

        if(isset($post['SellPrice'])) {
            if (self::EmptyValue($post['SellPrice'])) {
                $errors['field_error_sell_price'] = $this->getError('text_error_form_empty', [$this->getLabelForm('SellPrice')]);
            }else if(!self::IntNumber($post['SellPrice'])) {
                $errors['field_error_sell_price'] = $this->getError('text_error_form_number', [$this->getLabelForm('SellPrice')]);
            }
        }

        if(isset($post['Unit'])) {
            if (self::EmptyValue($post['Unit'])) {
                $errors['field_error_unit'] = $this->getError('text_error_form_empty', [$this->getLabelForm('Unit')]);
            }else if(!self::IntNumber($post['Unit'])) {
                $errors['field_error_unit'] = $this->getError('text_error_form_number', [$this->getLabelForm('Unit')]);
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