<?php

class Database
{
    private static $instance;
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "online_foto_album";
    private $conn;

    private function __construct()
    {
        $this->initializeDatabase();
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function prepare($query)
    {
        $stmt = $this->getConnection()->prepare($query);

        if (!$stmt) {
            die("Error preparing query: " . $this->getConnection()->error);
        }

        return $stmt;
    }

    private function initializeDatabase()
    {
        $this->conn = new mysqli($this->host, $this->username, $this->password);

        if ($this->conn->connect_error) {
            die("Failed to connect to database: " . $this->conn->connect_error);
        }

        $sql = "CREATE DATABASE IF NOT EXISTS $this->database";

        if ($this->conn->query($sql) === false) {
            die("Error creating database ($this->database): " . $this->conn->error);
        }

        $this->conn->select_db($this->database);
    }

    public function getConnection()
    {
        if (!$this->conn) {
            $this->initializeDatabase();
        }
        return $this->conn;
    }
}
