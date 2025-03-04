<?php
// regisztracio.php - Regisztrációs oldal

session_start(); // Munkamenet indítása
include 'includes_db.php'; // Adatbázis kapcsolat betöltése

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Felhasználó adatainak lekérése a formból
    $felhasznalonev = $_POST['felhasznalonev'];
    $jelszo = password_hash($_POST['jelszo'], PASSWORD_DEFAULT); // Jelszó titkosítása
    $email = $_POST['email'];

    // Felhasználó ellenőrzése, hogy már létezik-e
    $sql = "SELECT id FROM felhasznalok WHERE felhasznalonev = '$felhasznalonev' OR email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "A felhasználónév vagy email cím már foglalt!";
    } else {
        // Új felhasználó beszúrása az adatbázisba
        $sql = "INSERT INTO felhasznalok (felhasznalonev, jelszo, email, admin) VALUES ('$felhasznalonev', '$jelszo', '$email', 0)";
        if ($conn->query($sql) === TRUE) {
            echo "Sikeres regisztráció! Most már bejelentkezhet.";
            header("Refresh: 3; url=bejelentkezes.php"); // Átirányítás 3 másodperc után
        } else {
            echo "Hiba: " . $sql . "<br>" . $conn->error;
        }
    }
}

// A HTML tartalom betöltése
include 'regisztracio.html';
?>