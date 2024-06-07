<?php
// Activează afișarea erorilor pentru depanare
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Include fișierul de conexiune
    include 'db_connection.php';

    // Obține datele din formular
    $nume = $_POST['nume'];
    $prenume = $_POST['prenume'];
    $echipa = $_POST['echipa'];
    $departament = $_POST['departament'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Verifică dacă toate câmpurile sunt completate
    if (empty($nume) || empty($prenume) || empty($echipa) || empty($departament) || empty($email) || empty($password)) {
        echo "Please fill in all fields.";
        exit();
    }

    // Obține ID_Echipa din baza de date pe baza numelui echipei
    $sql = "SELECT ID_Echipa FROM ECHIPA WHERE Nume_Echipa = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo "Error preparing statement: " . $conn->error;
        exit();
    }
    $stmt->bind_param("s", $echipa);
    $stmt->execute();
    $stmt->bind_result($id_echipa);
    $stmt->fetch();
    $stmt->close();

    if ($id_echipa) {
        // Inserare în baza de date
        $sql = "INSERT INTO MEMBRU (Nume, Prenume, ID_Echipa, Departament, E_Mail, Parola) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            echo "Error preparing statement: " . $conn->error;
            exit();
        }
        $stmt->bind_param("ssisss", $nume, $prenume, $id_echipa, $departament, $email, $password);

        if ($stmt->execute()) {
            // Înregistrare reușită
            header("Location: welcome.html");
            exit();  // Asigură-te că scriptul se oprește după redirecționare
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Team not found.";
    }

    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
