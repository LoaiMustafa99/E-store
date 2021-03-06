<?php

namespace PHPMVC\MODELS;

class EmployeeModel extends AbstractModel
{
    public $id;
    public $name;
    public $age;
    public $address;
    public $tax;
    public $salary;
    public $gender;
    public $theType;
    public $os;
    public $notes;


    protected static $tableName = 'app_employees';
    protected static $tableSchema = [
        "name"          => self::DATA_TYPE_STR,
        "age"           => self::DATA_TYPE_INT,
        "address"       => self::DATA_TYPE_STR,
        "tax"           => self::DATA_TYPE_DECIMAL,
        "salary"        => self::DATA_TYPE_DECIMAL,
        "gender"        => self::DATA_TYPE_INT,
        "theType"       => self::DATA_TYPE_INT,
        "os"            => self::DATA_TYPE_STR,
        "notes"         => self::DATA_TYPE_STR
    ];
    protected static $primaryKey = 'id';

    public function getTableName()
    {
        return self::$tableName;
    }
}