<?php
// Connexion à la base de données
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'gestion_rdv';
$conn = new mysqli($host, $username, $password, $database);
// Vérification
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
} 
/*else {
    echo "Connexion réussie à la base de données.";
}*/


// Récupération des données des médecins
$query = "SELECT * FROM `medecins` ";
$result = $conn->query($query);

// Fermeture de la connexion si aucune donnée trouvée
if ($result->num_rows == 0) {
    echo "Aucun médecin trouvé.";
    exit();
}

// Envoi des données au frontend (JSON si besoin)
$doctors = [];
while ($row = $result->fetch_assoc()) {
    $doctors[] = $row;
}
$conn->close();
// Envoi des données au format JSON
header('Content-Type: application/json');
echo json_encode($doctors);
?>