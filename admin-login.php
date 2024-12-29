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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données envoyées par le formulaire
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vérification des identifiants
    if ($username == 'admin' && $password == 'admin123') {
        // Connexion réussie
        session_start();
        $_SESSION['admin'] = $username;  // Stocker le nom d'utilisateur de l'administrateur
        header("Location: admin-dashboard.php");  // Rediriger vers le tableau de bord administrateur
    } else {
        // Échec de la connexion
        echo "Nom d'utilisateur ou mot de passe incorrect.";
    }
}

$conn->close();
?>
