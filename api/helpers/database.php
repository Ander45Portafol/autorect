<?php
header('Access-Control-Allow-Origin: *');
//This Url is to used datas of the config.php files to make the connection with the database
require_once('config.php');

class Database
{
    private static $connection = null;
    private static $statement = null;
    private static $error = null;

    public static function executeRow($query, $values)
    {
        try {
            self::$connection = new PDO('pgsql:host=' . SERVER . ';dbname=' . DATABASE . ';port=5432', USERNAME, PASSWORD);
            self::$statement = self::$connection->prepare($query);
            return self::$statement->execute($values);
        } catch (PDOException $error) {
            self::setException($error->getCode(), $error->getMessage());
            return false;
        }
    }
    //Function to get the las row of the query
    public static function getLastRow($query, $values)
    {
        if (self::executeRow($query, $values)) {
            $id = self::$connection->lastInsertId();
        } else {
            $id = 0;
        }
        return $id;
    }
    //Function to get only one row thought of the parameter
    public static function getRow($query, $values = null)
    {
        if (self::executeRow($query, $values)) {
            return self::$statement->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }
    //Function to get all rows of the table
    public static function getRows($query,$values=null){
        if (self::executeRow($query,$values)) {
            return self::$statement->FetchAll(PDO::FETCH_BOTH);
        }else {
            return false;
        }
    }
    //Function to show some posibles errors with the database
    public static function setException($code, $message)
    {
        self::$error = $message . PHP_EOL;
        switch ($code) {
            case '7':
                self::$error = 'Existe un problema al conectar con el servidor';
                break;
            case '42703':
                self::$error = 'Nombre de campo desconocido';
                break;
            case '23505':
                self::$error = 'Violacion de unicidad';
                break;
            case '42P01':
                self::$error = 'Nombre de tabla desconocido';
                break;
            case '23503':
                self::$error = 'Violacion de llave foránea';
                break;
            default:
                //self::$error = 'Ocurrio un problema en la base de datos';
        }
    }
    //Function to show exceptions
    public static function getException()
    {
        return self::$error;
    }
}
