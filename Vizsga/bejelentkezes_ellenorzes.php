<?php
session_start();

// Kapcsolódás az adatbázishoz
$servername = "localhost";
$username = "root";
$password = "";
$database = "matyas_csarda";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $felhasznalonev = trim($_POST['felhasznalonev']);
    $jelszo = trim($_POST['jelszo']);

    // Adatbázis lekérdezés a felhasználó hitelesítéséhez
    $sql = "SELECT id, teljesnev, jelszo FROM felhasznalok WHERE felhasznalonev = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $felhasznalonev);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // Jelszó ellenőrzése
        if (password_verify($jelszo, $row['jelszo'])) {
            // Munkamenet beállítása
            $_SESSION['felhasznalo_id'] = $row['id'];
            $_SESSION['teljesnev'] = $row['teljesnev']; // Teljes név betöltése

            header("Location: index.php"); // Átirányítás a főoldalra
            exit;
        } else {
            // Hibás jelszó esetén hibaüzenet beállítása
            $_SESSION['hiba'] = "Hibás felhasználónév vagy jelszó!";
        }
    } else {
        // Hibás felhasználónév esetén hibaüzenet beállítása
        $_SESSION['hiba'] = "Hibás felhasználónév vagy jelszó!";
    }

    $stmt->close();
}

$conn->close();
header("Location: bejelentkezes.php"); // Visszatérés a bejelentkezési oldalra
exit;
?>