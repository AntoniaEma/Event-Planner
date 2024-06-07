<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event_planner";

// Creare conexiune
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificare conexiune
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
