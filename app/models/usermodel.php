<?php

namespace PHPMVC\MODELS;

class UserModel extends AbstractModel
{
    public $UserId;
    public $Username;
    public $Password;
    public $Email;
    public $PhoneNumber;
    public $SubscriptionDate;
    public $LastLogin;
    public $GroupId;
    public $Status;

    protected static $tableName = 'app_users';
    public $profile;
    public $privileges;

    protected static $tableSchema = array(
        'UserId'            => self::DATA_TYPE_INT,
        'Username'          => self::DATA_TYPE_STR,
        'Password'          => self::DATA_TYPE_STR,
        'Email'             => self::DATA_TYPE_STR,
        'PhoneNumber'       => self::DATA_TYPE_STR,
        'SubscriptionDate'  => self::DATA_TYPE_STR,
        'LastLogin'         => self::DATA_TYPE_STR,
        'GroupId'           => self::DATA_TYPE_INT,
        'Status'            => self::DATA_TYPE_INT,
    );

    protected static $primaryKey = 'UserId';

    public function hashPassword($password)
    {
        $this->Password = password_hash($password, PASSWORD_DEFAULT);
    }

    public static function UserExists($user)
    {
        return self::getBy(['UserName' => $user]);
    }

    public static function EmailExists($Email)
    {
        return self::getBy(['Email' => $Email]);
    }

    public static function getUsers(UserModel $userLogin)
    {
        return self::get(
            'SELECT au.*, aug.GroupName GroupName FROM ' . self::$tableName . ' au INNER JOIN app_users_groups aug ON aug.GroupId = au.GroupId WHERE au.UserID != ' . $userLogin->UserId
        );
    }

    public static function authenticate ($username, $password, $session) {
        $sql = "SELECT *, (SELECT GroupName FROM app_users_groups WHERE app_users_groups.GroupId = " . self::$tableName . ".GroupId) GroupName FROM " . self::$tableName . " WHERE Username = '" . $username . "'";
        $foundUser = self::getOne($sql);
        if($foundUser !== false) {
            if($foundUser->Status == 0) {
                return 2;
            }
            $passwordGood = password_verify($password, $foundUser->Password);
            if ($passwordGood === true) {
                $foundUser->LastLogin = date('Y-m-d H:i:s');
                $foundUser->save();
                $foundUser->profile = UserProfileModel::getByID($foundUser->UserId);
                $foundUser->privileges = UserGroupPrivilegeModel::getPrivilegesForGroup($foundUser->GroupId);
                $session->u = $foundUser;
                return 1;
            }
        }
        return false;
    }
}