<?php

class Conexao {

    private static $instance;
    private static $host = "localhost";
    private static $dbname = "cadastrocliente";
    private static $user = "root";
    private static $password = "";

    private function __construct() {
        
    }

    public static function getConnection() {
        if (!isset(self::$instance)) {
            $opcoes = array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8', \PDO::ATTR_PERSISTENT => TRUE, \PDO::MYSQL_ATTR_FOUND_ROWS => true);
            $driver = "mysql:host=" . self::$host . "; dbname=" . self::$dbname . "; charset=utf8;";
            self::$instance = new \PDO($driver, self::$user, self::$password, $opcoes);
        }

        return self::$instance;
    }

}
