<?php
require_once __DIR__ . '/../configs/Database.php';

class Client {
    private $conn;

    public function __construct($db) { 
        $this->conn = $db;
    }

    public function getAllClients() {
        $query = "SELECT client.ID_client, client.nom, client.prenom, client.age,  region.libelle AS region 
                  FROM client, region 
                  WHERE client.ID_region = region.ID_region";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getClientById($ID_client) {
        $query = "SELECT client.ID_client, client.nom,client.ID_region, client.prenom, client.age, region.libelle AS region
                  FROM client, region
                  WHERE client.ID_region = region.ID_region
                  AND client.ID_client = :ID_client";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':ID_client', $ID_client);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    public function addClient($nom, $prenom, $age, $ID_region) {
        $query = "INSERT INTO client (nom, prenom, age, ID_region) VALUES (:nom, :prenom, :age, :ID_region)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':ID_region', $ID_region);
        return $stmt->execute();
    }

    public function deleteClient($ID_client) {
        $query = "DELETE FROM client WHERE ID_client = :ID_client";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':ID_client', $ID_client);
        return $stmt->execute();
    }
    public function searchClientsByName($name) {
        $query = "SELECT client.ID_client, client.nom, client.ID_region, client.prenom, client.age, region.libelle AS region 
                  FROM client, region 
                  WHERE client.ID_region = region.ID_region 
                  AND (client.nom LIKE :name OR client.prenom LIKE :name)";
        $stmt = $this->conn->prepare($query);
        $name = "%$name%";
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    

    public function updateClient($ID_client, $nom, $prenom, $age, $ID_region) {
        $query = "UPDATE client SET nom = :nom, prenom = :prenom, age = :age, ID_region = :ID_region WHERE ID_client = :ID_client";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':ID_client', $ID_client);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':ID_region', $ID_region);
        return $stmt->execute();
    }
}

?>
