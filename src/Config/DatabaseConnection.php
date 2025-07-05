<?php

namespace App\Config;

use App\Interfaces\DatabaseConnectionInterface;
use PDO;
use PDOException;

class DatabaseConnection implements DatabaseConnectionInterface
{
  private static $connection = null;
  private $host;
  private $port;
  private $database;
  private $username;
  private $password;

  public function __construct()
  {
    $this->host = $_ENV['DB_HOST'] ?? 'localhost';
    $this->port = $_ENV['DB_PORT'] ?? '5432';
    $this->database = $_ENV['DB_NAME'] ?? 'persona_db';
    $this->username = $_ENV['DB_USER'] ?? 'postgres';
    $this->password = $_ENV['DB_PASS'] ?? 'password';
  }

  public function getConnection()
  {
    if (self::$connection === null) {
      try {
        $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->database}";

        self::$connection = new PDO(
          $dsn,
          $this->username,
          $this->password,
          [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
          ]
        );
      } catch (PDOException $e) {
        throw new PDOException("Error de conexión a la base de datos: " . $e->getMessage());
      }
    }

    return self::$connection;
  }
}
