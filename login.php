<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        include 'db_connection.php';

        $email = $_POST['email'];
        $password = $_POST['password'];

        if (empty($email) || empty($password)) {
            echo "Please fill in both email and password.";
            exit();
        }

        $sql = "SELECT ID_Membru, Parola, is_admin FROM membru WHERE E_Mail = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            echo "Error in preparing statement: " . $conn->error;
            exit();
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id_membru, $hashed_password, $is_admin);
        $stmt->fetch();

        if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
            // Autentificare reușită
            $_SESSION['id_membru'] = $id_membru;

            if ($is_admin) {
                // Setăm o sesiune specifică pentru admin
                $_SESSION['is_admin'] = true;
                header("Location: admin_dashboard.php");
            } else {
                // Redirecționăm utilizatorul normal
                header("Location: welcome.html");
            }
            exit();  // Asigură-te că scriptul se oprește după redirecționare
        } else {
            // Autentificare eșuată
            echo "Invalid email or password";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Please fill in both email and password.";
    }
} else {
    echo "Invalid request method.";
}
?>
