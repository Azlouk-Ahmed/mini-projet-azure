<?php

$host = "tcp:some-server-name.database.windows.net,1433";
$db_name = "societe";
$username = "ahmed";
$password = "azerty123@";


try {
    $conn = new PDO(
        "sqlsrv:server=" . $host . ";Database=" . $db_name . ";Encrypt=true;TrustServerCertificate=false",
        $username,
        $password
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    echo "Connection error: " . $exception->getMessage();
    die();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $age = $_POST['age'];
    $ID_region = $_POST['ID_region'];

    
    $query = "INSERT INTO client (nom, prenom, age, ID_region) VALUES (:nom, :prenom, :age, :ID_region)";
    $stmt = $conn->prepare($query);

    try {
        $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':age' => $age,
            ':ID_region' => $ID_region
        ]);
        
        header('Location: list.php');
        exit();
    } catch (PDOException $e) {
        echo "Error adding client: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add_Client</title>
    <link rel="stylesheet" href="../../public/styles/index.css">
</head>
<body>
    <h1>Add Client</h1>
    <form action="add.php" method="POST">
        <div class="df">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" required>
        </div>
        <div class="df">
            <label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenom" required>
        </div>
        <div class="df">
            <label for="age">Âge:</label>
            <input type="number" id="age" name="age" required>
        </div>
        <div class="df">
            <label for="ID_region">Région:</label>
            <select id="ID_region" name="ID_region" required>
                <!-- Fetch regions dynamically -->
                <?php
                $regionsQuery = "SELECT ID_region, libelle FROM region";
                $regionsStmt = $conn->query($regionsQuery);
                while ($region = $regionsStmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value=\"{$region['ID_region']}\">{$region['libelle']}</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit">Ajouter</button>
    </form>
    <br>
    <a href="list.php">Back to List</a>
</body>
</html>