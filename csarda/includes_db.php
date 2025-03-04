<?php
// includes_db.php - Adatbázis kapcsolat létrehozása

$servername = "localhost";
$username = "root"; // Alapértelmezett felhasználónév XAMPP-ban
$password = "";     // Alapértelmezett jelszó XAMPP-ban
$dbname = "csarda";

// Kapcsolat létrehozása
$conn = new mysqli($servername, $username, $password, $dbname);

// Kapcsolat ellenőrzése
if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}
?>