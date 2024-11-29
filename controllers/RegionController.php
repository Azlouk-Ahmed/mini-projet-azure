<?php
require_once __DIR__ . '/../models/Region.php';
require_once __DIR__ . '/../configs/database.php';

class RegionController {
    private $region;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->region = new Region($db);  
    }

    public function listRegions() {
        return $this->region->getAllRegions();
    }
}

?>
