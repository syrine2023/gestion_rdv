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

// Récupérer l'ID du patient à partir de la session
$patient_email = $_SESSION['email'];  

// Récupérer l'ID du rendez-vous depuis le formulaire
if (isset($_POST['rdv_id'])) {
    $rdv_id = $_POST['rdv_id'];

    // Requête pour obtenir l'ID du patient pour vérifier que ce patient est bien lié à ce rendez-vous
    $query_patient_id = "SELECT ID FROM patients WHERE email = ?";
    $stmt = $conn->prepare($query_patient_id);
    $stmt->bind_param('s', $patient_email);
    $stmt->execute();
    $result_patient = $stmt->get_result();

    // Vérifier si l'email existe et récupérer l'ID
    if ($result_patient->num_rows > 0) {
        $patient_info = $result_patient->fetch_assoc();
        $patient_id = $patient_info['ID'];

        // Vérification que le rendez-vous appartient bien à ce patient
        $query_check_rdv = "SELECT * FROM rendezvous WHERE ID = ? AND patient_id = ? AND statut != 'annulé'";
        $stmt_check = $conn->prepare($query_check_rdv);
        $stmt_check->bind_param('ii', $rdv_id, $patient_id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            // Requête pour annuler le rendez-vous
            $query_annuler = "UPDATE rendezvous SET statut = 'annulé' WHERE ID = ?";
            $stmt_annuler = $conn->prepare($query_annuler);
            $stmt_annuler->bind_param('i', $rdv_id);
            $stmt_annuler->execute();

            // Vérification de l'annulation
            if ($stmt_annuler->affected_rows > 0) {
                header("Location: voir_rdv.php"); // Rediriger vers la page des rendez-vous
                exit();
            } else {
                echo "Erreur lors de l'annulation du rendez-vous.";
            }
        } else {
            echo "Rendez-vous non trouvé ou déjà annulé.";
        }
    } else {
        echo "Utilisateur non trouvé.";
    }

    // Fermeture des requêtes et de la connexion
    $stmt->close();
    $stmt_check->close();
    $stmt_annuler->close();
} else {
    echo "ID du rendez-vous non fourni.";
}

$conn->close();
?>
