<?php

namespace Core\Database;

use PDO;
use PDOException;
use Src\Helpers\Helper;

trait Connection
{
    protected PDO $conn;

    final public function connect()
    {
        try {
            $username = Helper::env("DB_USERNAME");
            $password = Helper::env("DB_PASSWORD");
            $connection = Helper::env("DB_CONNECTION");
            $host = Helper::env("DB_HOST");
            $port = Helper::env("DB_PORT");
            $name = Helper::env("DB_NAME");
            $conf = "$connection:host=$host;port=$port;dbname=$name";
            $this->conn = new PDO($conf, $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    final public function execute(string $sql, array $binding = [])
    {
        $stmt = $this->conn->prepare($sql);
        $stmt = $stmt->execute($binding);

        return $stmt;
    }
}
