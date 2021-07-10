<?php

namespace PHPMVC\MODELS;
use PHPMVC\LIB\DATABASE\DatabaseHandler;

class AbstractModel
{
    const DATA_TYPE_BOOL = \PDO::PARAM_BOOL;
    const DATA_TYPE_STR = \PDO::PARAM_STR;
    const DATA_TYPE_INT = \PDO::PARAM_INT;
    const DATA_TYPE_DECIMAL = 4;

    private function prepareValues (\PDOStatement &$stmt)
    {
        foreach (static::$tableSchema as $columnName => $type)
        {
            if ($type == 4) {
                $sanitizedValue = filter_var($this->$columnName , FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $stmt->bindValue(":{$columnName}", $sanitizedValue);
            } else {
                $stmt->bindValue(":{$columnName}", $this->$columnName, $type);
            }
        }
    }

    private static function buildNameParametersSQL()
    {
        $namedParams = '';
        foreach (static::$tableSchema as $columnName => $type) {
           $namedParams .= $columnName . " = :" . $columnName . ", ";
        }
        return trim($namedParams, ", ");
    }

    private function create()
    {
        $sql = "INSERT INTO " . static::$tableName . " SET " . self::buildNameParametersSQL();
        $stmt = DatabaseHandler::factory()->prepare($sql);
        $this->prepareValues($stmt);
        if($stmt->execute() === true) {
            $this->{static::$primaryKey} =  DatabaseHandler::factory()->lastInsertId();
            return true;
        }
        return false;
    }

    private function update()
    {
        $sql = "UPDATE " . static::$tableName . " SET " . self::buildNameParametersSQL() . " WHERE " . static::$primaryKey . " = " . $this->{static::$primaryKey};
        $stmt = DatabaseHandler::factory()->prepare($sql);
        $this->prepareValues($stmt);
        if($stmt->execute() === true) {
            return true;
        }
        return false;
    }

    public function save()
    {
        return $this->{static::$primaryKey} === null ? $this->create() : $this->update();
    }

    public function delete()
    {
        $sql = "DELETE FROM " . static::$tableName . " WHERE " . static::$primaryKey . " = " . $this->{static::$primaryKey};
        $stmt = DatabaseHandler::factory()->prepare($sql);
        if($stmt->execute() === true) {
            return true;
        }
        return false;
    }

    public static function getAll()
    {
        $sql = "SELECT * FROM " . static::$tableName;
        $stmt = DatabaseHandler::factory()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, get_called_class());
        return (is_array($result) && !empty($result)) ? $result : false;
    }

    public static function getByID($id)
    {
        $sql = "SELECT * FROM " . static::$tableName . " WHERE " . static::$primaryKey . " = '" . $id . "'";
        $stmt = DatabaseHandler::factory()->prepare($sql);
        if ($stmt->execute() === true)
        {
            $obj = $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, get_called_class());
            return array_shift($obj);
        }
        return false;
    }

    public static function get($sql, $options = [])
    {
        $stmt = DatabaseHandler::factory()->prepare($sql);
        foreach ($options as $columnName => $type)
        {
            if ($type[0] == 4) {
                $sanitizedValue = filter_var($type[1] , FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $stmt->bindValue(":{$columnName}", $sanitizedValue);
            } else {
                $stmt->bindValue(":{$columnName}", $type[1], $type[0]);
            }
        }
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, get_called_class());
        return (is_array($result) && !empty($result)) ? $result : false;
    }

}
