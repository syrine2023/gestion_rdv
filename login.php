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
    // Récupération des données du formulaire
    $email = trim($_POST['username']); // Le champ "username" correspond à l'email
    $telephone = trim($_POST['password']); // Le mot de passe correspond au numéro de téléphone

    // Validation des champs
    if (empty($email) || empty($telephone)) {
        echo "<script>alert('Veuillez remplir tous les champs.'); window.location.href = 'login.html';</script>";
        exit();
    }

    // Requête pour vérifier les informations de connexion
    $query = $conn->prepare("SELECT nom, prenom, telephone FROM patients WHERE email = ? AND telephone = ?");
    $query->bind_param('ss', $email, $telephone);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        // Connexion réussie
        session_start();
        $user = $result->fetch_assoc();
        $_SESSION['email'] = $email;
        $_SESSION['nom_complet'] = $user['nom'] . ' ' . $user['prenom']; // Nom complet
        $_SESSION['telephone'] = $user['telephone']; // Téléphone

        // Redirection vers acceuilpatient.php
        header("Location: acceuilpatient.php");
        exit();
    } else {
        // Échec de la connexion
        echo "<script>alert('Email ou mot de passe incorrect.'); window.location.href = 'login.html';</script>";
    }

    // Fermeture des connexions
    $query->close();
    $conn->close();
} else {
    echo "<script>alert('Méthode de requête invalide.'); window.location.href = 'login.html';</script>";
}
?>
