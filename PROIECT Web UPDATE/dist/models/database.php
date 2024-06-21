<?php
class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $host = "localhost";
        $db_name = "travel_souvenirs";
        $username = "root";
        $password = "";

        try {
            $this->connection = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8mb4", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}
?>
