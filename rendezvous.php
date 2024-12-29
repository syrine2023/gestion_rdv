<?php
// Connexion à la base de données
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'gestion_rdv';

$conn = new mysqli($host, $username, $password, $database);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_nom = $_POST['patient_nom'] ?? '';
    $patient_prenom = $_POST['patient_prenom'] ?? '';
    $medecin_id = $_POST['medecin_id'] ?? '';
    $date = $_POST['date'] ?? '';
    $heure = $_POST['heure'] ?? '';
 
    if ($patient_nom && $patient_prenom && $medecin_id && $date && $heure) {
        $stmt = $conn->prepare("INSERT INTO rendezvous (patient_id, medecin_id, date, heure, statut) VALUES (?, ?, ?, ?, 'confirmé')");
        $stmt->bind_param("iiss", $patient_id, $medecin_id, $date, $heure);

        // Requête pour obtenir l'ID du patient
        $stmt_patient = $conn->prepare("SELECT id FROM patients WHERE nom = ? AND prenom = ?");
        $stmt_patient->bind_param("ss", $patient_nom, $patient_prenom);
        $stmt_patient->execute();
        $result = $stmt_patient->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $patient_id = $row['id'];

            // Insertion du rendez-vous
            if ($stmt->execute()) {
                echo "Rendez-vous ajouté avec succès.";
            } else {
                echo "Erreur lors de l'ajout du rendez-vous : " . $conn->error;
            }
        } else {
            echo "Patient introuvable. Veuillez d'abord enregistrer le patient.";
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }
}

// Fermeture de la connexion
$conn->close();
?>
