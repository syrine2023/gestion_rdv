<?php
// Connexion à la base de données
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'gestion_rdv';
$conn = new mysqli($host, $username, $password, $database);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Vérification que la méthode de la requête est POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Récupération des données envoyées par le formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];

    // Validation des données
    if (empty($nom) || empty($prenom) || empty($email) || empty($telephone)) {
        $response = ['success' => false, 'message' => 'Tous les champs doivent être remplis.'];
        echo json_encode($response);
        exit();
    }

    // Préparation de la requête pour insérer un nouveau patient (requête préparée pour éviter les injections SQL)
    $query = $conn->prepare("INSERT INTO `patients` (nom, prenom, email, telephone) VALUES (?, ?, ?, ?)");
    $query->bind_param('ssss', $nom, $prenom, $email, $telephone);

    // Exécution de la requête
    if ($query->execute()) {
        // Inscription réussie, rediriger vers index.html
        header("Location: index.html");
        exit();
    } else {
        // Erreur lors de l'insertion, renvoyer une réponse JSON d'erreur
        $response = ['success' => false, 'message' => 'Une erreur est survenue lors de l\'inscription du patient.'];
        echo json_encode($response);
    }

    // Fermeture de la connexion
    $query->close();
    $conn->close();

} else {
    // Si la méthode n'est pas POST, renvoyer une erreur
    $response = ['success' => false, 'message' => 'Méthode de requête invalide.'];
    echo json_encode($response);
}
?>
