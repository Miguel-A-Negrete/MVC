<?php
require_once ('Conexion.php');
class DB
{
    protected static $con;

    public static function getInstance()
    {
        if (!self::$con) {
            try {
                $dsn = "mysql:host=" . Config::DBHOST . ";dbname=" . Config::DBNAME;
                self::$con = new PDO($dsn, Config::DBUSER, Config::DBPASS);
            } catch (PDOException $error) {
                echo $error->getMessage();
            }
        }
        return self::$con;
    }
}

?>