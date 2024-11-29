<?php

$host = "tcp:some-server-name.database.windows.net,1433";
$db_name = "societe";
$username = "ahmed";
$password = "azerty123@";
$conn = new PDO("sqlsrv:server=$host;Database=$db_name;Encrypt=true;TrustServerCertificate=false", $username, $password);


$clients = [];
$searchQuery = "";


if (isset($_GET['search'])) {
    
    $searchQuery = "%" . $_GET['search'] . "%"; 
    $sql = "SELECT c.ID_client, c.nom, c.prenom, c.age, r.libelle AS region 
            FROM client c 
            LEFT JOIN region r ON c.ID_region = r.ID_region 
            WHERE c.nom LIKE ? OR c.prenom LIKE ?";
    
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([$searchQuery, $searchQuery]); 
    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    
    $sql = "SELECT c.ID_client, c.nom, c.prenom, c.age, r.libelle AS region 
            FROM client c 
            LEFT JOIN region r ON c.ID_region = r.ID_region";
    
    $stmt = $conn->query($sql);
    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des Clients</title>
    <link rel="stylesheet" href="../../public/styles/index.css">
</head>
<body class="df-c">
    <div class="df">
        <h1>Liste des Clients</h1>
        <a href="add.php">Add a client</a>
    </div>
    
    <!-- Search Form -->
    <form method="GET" class="df" action="">
        <input type="text" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" placeholder="Search by name">
        <button type="submit">Search</button>
        <a href="list.php">Clear</a> <!-- Clear search -->
    </form>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Âge</th>
                <th>Région</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($clients)): ?>
                <?php foreach ($clients as $client): ?>
                    <tr>
                        <td><?= $client['ID_client'] ?></td>
                        <td><?= $client['nom'] ?></td>
                        <td><?= $client['prenom'] ?></td>
                        <td><?= $client['age'] ?></td>
                        <td><?= $client['region'] ?></td>
                        <td>
                            <a href="edit.php?action=editClient&id=<?= $client['ID_client'] ?>">Modifier</a>
                            <a href="delete.php?action=deleteClient&id=<?= $client['ID_client'] ?>">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No clients found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>