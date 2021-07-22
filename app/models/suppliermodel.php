<?php
namespace PHPMVC\MODELS;

class SupplierModel extends AbstractModel
{
    public $SupplierId;
    public $Name;
    public $PhoneNumber;
    public $Email;
    public $Address;

    protected static $tableName = 'app_suppliers';


    protected static $tableSchema = array(
        'Name'              => self::DATA_TYPE_STR,
        'PhoneNumber'       => self::DATA_TYPE_STR,
        'Email'             => self::DATA_TYPE_STR,
        'Address'           => self::DATA_TYPE_STR
    );

    protected static $primaryKey = 'SupplierId';

    public static function EmailExists ($value) {
        return self::getBy(['Email' => $value]);
    }

}