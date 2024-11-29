<?php
require_once __DIR__ . '/../models/Client.php';
require_once __DIR__ . '/../models/Region.php';
require_once __DIR__ . '/../configs/Database.php';  

class ClientController {
    private $clientModel;
    private $regionModel;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();  

        
        $this->clientModel = new Client($db); 
        $this->regionModel = new Region($db);  
    }

    public function listClients() {
        return $this->clientModel->getAllClients();
    }
    public function searchClientsByName($name) {
        return $this->clientModel->searchClientsByName($name);
    }
    

    public function addClient($data) {
        
        $nom = $data['nom'];
        $prenom = $data['prenom'];
        $age = $data['age'];
        $ID_region = $data['ID_region'];
        
        
        return $this->clientModel->addClient($nom, $prenom, $age, $ID_region);
    }

    public function deleteClient($ID_client) {
        $this->clientModel->deleteClient($ID_client);
        header("Location: list.php?action=listClients");
    }

    public function updateClient($ID_client, $nom, $prenom, $age, $ID_region) {
        
        return $this->clientModel->updateClient($ID_client, $nom, $prenom, $age, $ID_region);
    }
    
    public function getClient($ID_client) {
        
        return $this->clientModel->getClientById($ID_client);
    }
}

?>
