<?php
require_once __DIR__ . '/../configs/Database.php';

class Region {
    private $conn;
    private $table_name = "region";

    public function __construct($db) {
        $this->conn = $db; 
    }

    public function getAllRegions() {
        $query = "SELECT * FROM  " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}

?>
