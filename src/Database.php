<?php

namespace CoreAuth;

use PDO;

class Database {
    private $host = 'localhost';
    private $dbname = 'auth_db';
    private $username = 'root';
    private $password = '';
    private $connection;

    public function getConnection() {
        if ($this->connection === null) {
            try {
                $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8";
                $this->connection = new PDO($dsn, $this->username, $this->password);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }
        return $this->connection;
    }
}
