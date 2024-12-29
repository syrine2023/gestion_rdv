<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: login.html");
    exit();
}

// Récupérer les informations de l'utilisateur
$email = $_SESSION['email'];
$nom_complet = $_SESSION['nom_complet']; // Nom complet (par exemple, stocké lors de la connexion)
$telephone = $_SESSION['telephone'];    // Téléphone (stocké lors de la connexion)
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil Patient</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <a href="index.html" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
        <h1 class="m-0 text-primary"><i class="far fa-hospital me-3"></i>Polyclinique ESSALEMA</h1>
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="container">
        <h2>Bienvenue, <?php echo htmlspecialchars($nom_complet); ?> !</h2>
        <p>Voici votre espace personnel où vous pouvez consulter et gérer vos rendez-vous.</p>
        
        <!-- Informations sur le Patient -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Informations personnelles</h5>
                <p id="patientName">Nom : <strong><?php echo htmlspecialchars($nom_complet); ?></strong></p>
                <p id="patientEmail">Email : <strong><?php echo htmlspecialchars($email); ?></strong></p>
                <p id="patientPhone">Téléphone : <strong><?php echo htmlspecialchars($telephone); ?></strong></p>
            </div>
        </div>

        <!-- Gestion des Rendez-vous -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Mes Rendez-vous</h5>
                <button class="btn btn-primary" onclick="location.href='voir_rdv.php'">Voir mes rendez-vous</button>
            </div>
        </div>

        <!-- Déconnexion -->
        <div class="mt-3">
            <button class="btn btn-danger" onclick="logout()">Déconnexion</button>
        </div>
    </div>

    <!-- Script JavaScript -->
    <script>
        // Exemple de fonction de déconnexion
        function logout() {
            // Vous pouvez ajouter la logique pour déconnecter l'utilisateur et rediriger vers la page de connexion
            window.location.href = 'login.html';  // Redirection vers la page de connexion
        }
    </script>
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
