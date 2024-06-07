<?php
session_start(); // Porniți sesiunea pentru a prelua ID-ul utilizatorului logat

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event_planner";

// Crearea conexiunii
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificarea conexiunii
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verificarea autentificării utilizatorului
if (!isset($_SESSION['id_membru'])) {
    die("Utilizatorul nu este autentificat.");
}

$id_membru = $_SESSION['id_membru'];
$id_eveniment = $_POST['event'];
$tip_eveniment = $_POST['tip_eveniment'];
$participa = $_POST['participation'];

// Determinarea ID-ului activității bazat pe tipul de eveniment
$id_activitate = 0;
if ($tip_eveniment == 'Teambuilding') {
    $id_activitate = 1;
} elseif ($tip_eveniment == 'Workshop') {
    $id_activitate = 2;
} elseif ($tip_eveniment == 'Team Gathering') {
    $id_activitate = 3;
}

// Inserarea participării în baza de date
$sql = "INSERT INTO participanti (ID_Membru, ID_Activitate, ID_Eveniment, Tip_Eveniment, Participa) VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiiss", $id_membru, $id_activitate, $id_eveniment, $tip_eveniment, $participa);

if ($stmt->execute()) {
    echo "Participation recorded successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

// Redirecționare la welcome.html după trimitere
header("Location: welcome.html");
exit();
?>
