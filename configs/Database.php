<?php
class Database {
    private $host = "localhost"; 
    private $db_name = "societe1"; 
    private $username = "root"; 
    private $password = ""; 
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            
            $this->conn = new PDO(
                "sqlsrv:server=" . $this->host . ";Database=" . $this->db_name . ";Encrypt=true;TrustServerCertificate=false",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connection successful!";
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
            die();
        }
        return $this->conn;
    }
}
?>
