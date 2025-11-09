<?php
namespace App\Config;

use PDO;
use PDOException;

require_once __DIR__ . '/config.php';

class Database {
    private static $instance = null;
    private $conn;

    private $host = DB_HOST;
    private $db_name = DB_NAME;
    private $username = DB_USERNAME;
    private $password = DB_PASSWORD;

    private function __construct() {
        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            error_log('Connection Error: ' . $e->getMessage());
            // In a real application, you would handle this more gracefully
            // For this API, we will let the request fail.
        }
    }

    public static function getInstance() {
        if(!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }
}
