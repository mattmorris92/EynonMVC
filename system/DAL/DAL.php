<?php
namespace DAL;

/**
 * Manages the PDO Database connection.
 *
 * @author Thomas Eynon
 */
class DAL {
    public static $IsInitialized = false;
    public static $db;
    
    const NotConnectedError = "Not connected to database.";
    
    public function __construct($server, $database, $username, $password, $charset = "utf8") {
        self::Init($server, $database, $username, $password, $charset);
    }
    
    public static function Init($server, $database, $username, $password, $charset = "utf8") {
        self::$db = new \PDO("mysql:host={$server};dbname={$database};", $username, $password);
        self::$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        self::$db->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        self::$IsInitialized = true;
    }
    
    public static function Prepared($sql, $values, &$insertID = null) {
        if (self::$IsInitialized) {
            $statement = self::$db->prepare($sql);
            $statement->execute($values);
            $insertID = self::$db->lastInsertId();
            return $statement;
        }
        else {
            throw new Exception(self::NotConnectedError);
        }
    }
    
    public static function Query($sql, &$insertID = null) {
        if (self::$IsInitialized) {
            $result = self::$db->query($sql);
            $insertID = self::$db->lastInsertId();
            return $result;
        }
        else {
            throw new Exception(self::NotConnectedError);
        }
    }
    
    public static function MapToObject($resultSet, &$object) {
        $properties = get_object_vars($object);
        
        if (!empty($resultSet)) {
            foreach ($resultSet as $key => $value) {
                if (array_key_exists($key, $properties)) {
                    $object->$key = $value;
                }
            }
        }
    }
}
