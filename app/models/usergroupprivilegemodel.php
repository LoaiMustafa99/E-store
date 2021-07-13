<?php

namespace PHPMVC\MODELS;

class UserGroupPrivilegeModel extends AbstractModel
{
    public $Id;
    public $GroupId;
    public $privilegeId;

    protected static $tableName = 'app_users_groups_privileges';

    protected static $tableSchema = array(
        'GroupId'            => self::DATA_TYPE_INT,
        'privilegeId'          => self::DATA_TYPE_INT
    );

    protected static $primaryKey = 'Id';

    public static function getGroupPrivileges(UserGroupModel $group) {
        $groupPrivileges = self::getBy(['GroupId' => $group->GroupId]);
        $extractedPrivilegesIds = [];
        if(false !== $groupPrivileges) {
            foreach ($groupPrivileges as $privilege) {
                $extractedPrivilegesIds[] = $privilege->privilegeId;
            }
        }
        return $extractedPrivilegesIds;
    }

}