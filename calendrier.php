<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'gestion_rdv';
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

if (empty($action)) {
    echo json_encode(['success' => false, 'message' => 'Action non définie']);
    exit();
}

// Récupérer les rendez-vous d'une date spécifique
if ($action == 'listByDate') {
    $date = isset($_GET['date']) ? $_GET['date'] : '';
    
    if (empty($date)) {
        echo json_encode(['success' => false, 'message' => 'Date non spécifiée']);
        exit();
    }

    // Récupérer les rendez-vous pour la date spécifiée
    $query = "SELECT * FROM `rendezvous` WHERE DATE(`date`) = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result();
    $appointments = [];

    while ($row = $result->fetch_assoc()) {
        $start = $row['date'] . ' ' . $row['heure'];
        $appointments[] = [
            'id' => $row['ID'],
            'title' => 'Rendez-vous avec le patient ' . $row['patient_id'],
            'start' => $start,
            'end' => $start,
            'description' => 'Rendez-vous avec le médecin ' . $row['medecin_id'],
        ];
    }

    echo json_encode($appointments);  // Retourner les événements pour cette date
    exit();
}

switch ($action) {
    case 'list':
        $query = "SELECT * FROM `rendezvous`";
        $result = $conn->query($query);
        $appointments = [];

        while ($row = $result->fetch_assoc()) {
            // Conversion de la date et de l'heure en format ISO 8601 pour FullCalendar
            $start = $row['date'] . ' ' . $row['heure'];  // Exemple : "2024-12-27 10:00:00"
            $appointments[] = [
                'id' => $row['ID'],
                'title' => 'Rendez-vous avec le patient ' . $row['patient_id'], // Le titre de l'événement
                'start' => $start, // Date et heure de début
                'end' => $start, // Optionnel : vous pouvez définir une durée si nécessaire
                'description' => 'Rendez-vous avec le médecin ' . $row['medecin_id'],
            ];
        }

        echo json_encode($appointments); // Retourne les événements sous forme JSON
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Action non définie']);
        break;
}

$conn->close();
?>
