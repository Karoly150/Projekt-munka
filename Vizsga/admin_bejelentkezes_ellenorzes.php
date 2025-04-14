<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adminnev = $_POST['felhasznalonev'] ?? null;
    $jelszo = $_POST['jelszo'] ?? null;

    // Adatbázis kapcsolat
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "matyas_csarda";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Kapcsolódási hiba: " . $conn->connect_error);
    }

    // SQL-lekérdezés a bejelentkezéshez
    $sql = "SELECT id, jelszo FROM adminok WHERE adminnev = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $adminnev);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        // Egyszerű jelszó-ellenőrzés
        if ($jelszo === $row['jelszo']) {
            // Sikeres bejelentkezés
            $_SESSION['admin_id'] = $row['id'];
            header("Location: admin_panel.php");
            exit;
        } else {
            echo "Hibás jelszó!";
        }
    } else {
        echo "Nincs ilyen adminisztrátor.";
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: admin_bejelentkezes.html");
    exit;
}
