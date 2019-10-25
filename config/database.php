<?php
class Database
{
    private $hostname = 'localhost';
    private $db_name = 'grocery_store';
    private $username = 'root';
    private $password = '';
    public $conn;

    //
    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->hostname . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->exec("set names utf8");
        } catch (PDOException $e) {
            echo "Database connection failed: " . $e->getMessage();
        }
        return $this->conn;
    }
}
