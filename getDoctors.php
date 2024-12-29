<?php
// Connexion à la base de données
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'gestion_rdv';
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die(json_encode(['error' => 'Erreur de connexion à la base de données']));
}

// Requête pour récupérer les médecins avec ID, nom et spécialité
$result = $conn->query("SELECT id, CONCAT(nom, ' (', specialite, ')') AS name FROM medecins");

if (!$result) {
    die(json_encode(['error' => 'Erreur de requête SQL']));
}

// Récupérer tous les résultats
$doctors = $result->fetch_all(MYSQLI_ASSOC);

// Vérifier si des médecins existent
if (empty($doctors)) {
    die(json_encode(['error' => 'Aucun médecin trouvé']));
}

echo json_encode($doctors);

$conn->close();
?>
