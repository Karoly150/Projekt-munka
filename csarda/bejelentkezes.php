<?php
// bejelentkezes.php - Bejelentkezési oldal

session_start(); // Munkamenet indítása

// Ha a felhasználó már be van jelentkezve, irányítsuk át az étlapra
if (isset($_SESSION['felhasznalo_id'])) {
    header("Location: etlap.php");
    exit();
}

include 'includes_db.php'; // Adatbázis kapcsolat betöltése

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Felhasználó adatainak lekérése a formból
    $felhasznalonev = $_POST['felhasznalonev'];
    $jelszo = $_POST['jelszo'];

    // Felhasználó keresése az adatbázisban
    $sql = "SELECT id, jelszo, admin FROM felhasznalok WHERE felhasznalonev = '$felhasznalonev'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Jelszó ellenőrzése
        if (password_verify($jelszo, $row['jelszo'])) {
            $_SESSION['felhasznalo_id'] = $row['id'];
            $_SESSION['admin'] = $row['admin']; // Admin jogosultság tárolása
            header("Location: etlap.php"); // Átirányítás az étlapra
            exit();
        } else {
            echo "Hibás jelszó!";
        }
    } else {
        echo "Felhasználó nem található!";
    }
}

// A HTML tartalom betöltése
include 'bejelentkezes.html';
?>