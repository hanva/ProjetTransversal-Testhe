<?php

namespace Cool;

use PDO;

class DBManager
{
    private $pdo;

    private function __construct()
    {
        global $params;

        $address = $params['db']['host'];
        if ($params['db']['port']) {
            $address .= ':' . $params['db']['port'];
        }

        $dsn = 'mysql:dbname=' . $params['db']['name'] . ';host=' . $address;
        $user = $params['db']['user'];
        $password = $params['db']['password'];
        $pdo = new PDO($dsn, $user, $password);
        $this->setPdo($pdo);
    }

    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new DBManager();
        }
        return self::$instance;
    }

    public function getPdo()
    {
        return $this->pdo;
    }

    private function setPdo($pdo)
    {
        $this->pdo = $pdo;
    }
}
