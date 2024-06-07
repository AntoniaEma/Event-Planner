<?php
session_start();

// Verificăm dacă utilizatorul este autentificat și este admin
if (!isset($_SESSION['id_membru']) || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: login.php");
    exit();
}

include 'db_connection.php';

// Interogarea pentru a obține datele necesare
$sql = "SELECT m.Nume, m.Prenume, ta.Nume_Activitate, p.Tip_Eveniment, e.Nume_Echipa, e.Departament_Echipa
        FROM participanti p
        JOIN membru m ON p.ID_Membru = m.ID_Membru
        JOIN tip_de_activitate ta ON p.ID_Activitate = ta.ID_Activitate
        JOIN echipa e ON m.ID_Echipa = e.ID_Echipa";
$result = $conn->query($sql);

$participanti = [
    'Teambuilding' => [],
    'Workshop' => [],
    'Team Gathering' => []
];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $participanti[$row['Tip_Eveniment']][] = $row;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f2e6ff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .buttons {
            margin-bottom: 1rem;
        }

        button {
            background-color: #6a0dad;
            color: white;
            border: none;
            padding: 0.8rem 1.2rem;
            margin: 0 0.5rem;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #4b0082;
        }

        .logout-button {
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            margin: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .logout-button:hover {
            background-color: #d32f2f;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th, td {
            padding: 0.8rem;
            border: 1px solid #ccc;
        }

        th {
            background-color: #6a0dad;
            color: white;
        }

        td {
            color: #4b0082;
        }

        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Dashboard</h2>
        <div class="buttons">
            <button onclick="filterTable('Teambuilding')">Teambuilding</button>
            <button onclick="filterTable('Workshop')">Workshop</button>
            <button onclick="filterTable('Team Gathering')">Team Gathering</button>
        </div>
        <div id="tables-container">
            <table id="table-Teambuilding" class="hidden">
                <thead>
                    <tr>
                        <th>Nume</th>
                        <th>Prenume</th>
                        <th>Tip Activitate</th>
                        <th>Nume Activitate</th>
                        <th>Echipa</th>
                        <th>Departament</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($participanti['Teambuilding'] as $row) {
                        echo "<tr><td>" . $row["Nume"]. "</td><td>" . $row["Prenume"]. "</td><td>" . $row["Tip_Eveniment"]. "</td><td>" . $row["Nume_Activitate"]. "</td><td>" . $row["Nume_Echipa"]. "</td><td>" . $row["Departament_Echipa"]. "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <table id="table-Workshop" class="hidden">
                <thead>
                    <tr>
                        <th>Nume</th>
                        <th>Prenume</th>
                        <th>Tip Activitate</th>
                        <th>Nume Activitate</th>
                        <th>Echipa</th>
                        <th>Departament</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($participanti['Workshop'] as $row) {
                        echo "<tr><td>" . $row["Nume"]. "</td><td>" . $row["Prenume"]. "</td><td>" . $row["Tip_Eveniment"]. "</td><td>" . $row["Nume_Activitate"]. "</td><td>" . $row["Nume_Echipa"]. "</td><td>" . $row["Departament_Echipa"]. "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <table id="table-Team Gathering" class="hidden">
                <thead>
                    <tr>
                        <th>Nume</th>
                        <th>Prenume</th>
                        <th>Tip Activitate</th>
                        <th>Nume Activitate</th>
                        <th>Echipa</th>
                        <th>Departament</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($participanti['Team Gathering'] as $row) {
                        echo "<tr><td>" . $row["Nume"]. "</td><td>" . $row["Prenume"]. "</td><td>" . $row["Tip_Eveniment"]. "</td><td>" . $row["Nume_Activitate"]. "</td><td>" . $row["Nume_Echipa"]. "</td><td>" . $row["Departament_Echipa"]. "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="buttons">
            <button class="logout-button" onclick="window.location.href='index.html'">Logout</button>
        </div>
    </div>
    <script>
        function filterTable(type) {
            var tables = document.querySelectorAll("#tables-container table");
            tables.forEach(table => {
                if (table.id === 'table-' + type) {
                    table.classList.remove('hidden');
                } else {
                    table.classList.add('hidden');
                }
            });
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
