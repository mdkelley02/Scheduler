<?php
declare (strict_types = 1);
namespace App;

use PDO;

class Database
{
    private static $instance;
    private $conn;
    private $host;
    private $dbname;
    private $port;
    private $username;
    private $password;
    private $dsn;

    private function __construct()
    {
        $host = getenv('DB_HOST');
        $dbname = getenv('DB_NAME');
        $port = getenv('DB_PORT');
        $username = getenv('DB_USERNAME');
        $password = getenv('DB_PASSWORD');
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
        $this->conn = new PDO($dsn, $username, $password);
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function connect()
    {
        return $this->conn;
    }
}
