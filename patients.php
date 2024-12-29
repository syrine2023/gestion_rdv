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

$action = isset($_POST['action']) ? $_POST['action'] : '';

switch ($action) {
    case 'list':
        // Récupérer la liste des patients
        $query = "SELECT * FROM `patients`";
        $result = $conn->query($query);
        $patients = [];

        while ($row = $result->fetch_assoc()) {
            $patients[] = [
                'id' => $row['ID'],         // Utiliser 'ID' en majuscule
                'nom' => $row['nom'],
                'prenom' => $row['prenom'],
                'email' => $row['email'],
                'telephone' => $row['telephone']
            ];
        }

        echo json_encode($patients);  // Retourner les patients en JSON
        break;
    case 'get':
        // Récupérer un patient par ID
        $id = $_POST['id'];
        $query = "SELECT * FROM `patients` WHERE ID = $id";
        $result = $conn->query($query);
        
        if ($result->num_rows > 0) {
            $patient = $result->fetch_assoc();
            echo json_encode($patient);  // Retourner les données du patient en JSON
        } else {
            echo json_encode(null);  // Aucun patient trouvé
        }
        break;
    case 'add':
        // Ajouter un patient
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $telephone = $_POST['telephone'];

        // Préparation de la requête pour insérer le patient
        $query = "INSERT INTO `patients` (nom, prenom, email, telephone) 
                  VALUES ('$nom', '$prenom', '$email', '$telephone')";
        
        if ($conn->query($query) === TRUE) {
            echo json_encode(['success' => true]);  // Succès de l'ajout
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'ajout']);
        }
        break;

    case 'delete':
        // Supprimer un patient
        $id = $_POST['id'];
        $query = "DELETE FROM `patients` WHERE ID = $id";  // Utiliser 'ID' en majuscule

        if ($conn->query($query) === TRUE) {
            echo json_encode(['success' => true]);  // Succès de la suppression
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression']);
        }
        break;

    case 'update':
        // Modifier un patient
        $id = $_POST['id'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $telephone = $_POST['telephone'];

        // Préparation de la requête pour mettre à jour le patient
        $query = "UPDATE `patients` SET nom = '$nom', prenom = '$prenom', email = '$email', telephone = '$telephone' WHERE ID = $id";
        
        if ($conn->query($query) === TRUE) {
            echo json_encode(['success' => true]);  // Succès de la mise à jour
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour']);
        }
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Action non définie']);
        break;
}

$conn->close();
?>
