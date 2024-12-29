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

// Vérification que l'utilisateur est connecté
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}

// Récupérer l'ID du patient à partir de l'email
$patient_email = $_SESSION['email'];  

// Requête pour obtenir l'ID du patient à partir de l'email
$query_patient_id = "SELECT ID FROM patients WHERE email = ?";
$stmt = $conn->prepare($query_patient_id);
$stmt->bind_param('s', $patient_email);
$stmt->execute();
$result_patient = $stmt->get_result();

// Vérifier si l'email existe et récupérer l'ID
if ($result_patient->num_rows > 0) {
    $patient_info = $result_patient->fetch_assoc();
    $patient_id = $patient_info['ID'];
} else {
    $patient_id = null;
    // Rediriger si pas trouvé
    header("Location: login.html");
    exit();
}

// Requête pour obtenir les informations du rendez-vous
$query_rdv = "SELECT rdv.ID, rdv.date, rdv.heure, rdv.statut, m.nom AS docteur_nom
              FROM rendezvous rdv
              JOIN medecins m ON rdv.medecin_id = m.ID
              WHERE rdv.patient_id = ? AND rdv.statut != 'annulé' LIMIT 1";

$stmt = $conn->prepare($query_rdv);
$stmt->bind_param('i', $patient_id);  // Utilisation de 'i' pour l'ID du patient (entier)
$stmt->execute();
$result = $stmt->get_result();

// Vérifier si un rendez-vous existe
if ($result->num_rows > 0) {
    $rendezvous_info = $result->fetch_assoc();
} else {
    $rendezvous_info = null;
}

// Fermeture de la requête et de la connexion
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Rendez-vous</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .rendezvous-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 30px;
        }

        .button-container {
            text-align: center;
        }

        .btn {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Mon Rendez-vous</h1>
        
        <?php if ($rendezvous_info): ?>
            <div class="rendezvous-details">
                <p><strong>Date :</strong> <?php echo date('d/m/Y', strtotime($rendezvous_info['date'])); ?></p>
                <p><strong>Heure :</strong> <?php echo date('H:i', strtotime($rendezvous_info['heure'])); ?></p>
                <p><strong>Docteur :</strong> <?php echo $rendezvous_info['docteur_nom']; ?></p>
            </div>

            <div class="button-container">
                <form action="annuler_rdv.php" method="POST">
                    <input type="hidden" name="rdv_id" value="<?php echo $rendezvous_info['ID']; ?>">
                    <button type="submit" class="btn btn-danger">Annuler le Rendez-vous</button>
                </form>
            </div>
        <?php else: ?>
            <p>Vous n'avez aucun rendez-vous.</p>
        <?php endif; ?>

        <div class="button-container">
            <a href="acceuilpatient.php" class="btn btn-secondary">Retour à l'accueil</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
