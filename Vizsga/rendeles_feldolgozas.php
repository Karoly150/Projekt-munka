<?php
session_start();

// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
if (!isset($_SESSION['felhasznalo_id'])) {
    die("Be kell jelentkeznie a rendeléshez.");
}

// Kapcsolódás az adatbázishoz
$servername = "localhost";
$username = "root";
$password = "";
$database = "matyas_csarda";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

// POST-adatok ellenőrzése és betöltése
$felhasznalo_id = $_POST['felhasznalo_id'] ?? null;
$etel_id = $_POST['etel_id'] ?? null;
$mennyiseg = $_POST['mennyiseg'] ?? null;
$statusz = 'függőben';

// Ellenőrizzük, hogy az adatok nem üresek
if (empty($felhasznalo_id) || empty($etel_id) || empty($mennyiseg)) {
    die("Hiányzó adatok: felhasználói ID, étel ID vagy mennyiség.");
}

// SQL-parancs az adatbázishoz
$sql = "INSERT INTO rendelesek (felhasznalo_id, etel_id, mennyiseg, statusz) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiis", $felhasznalo_id, $etel_id, $mennyiseg, $statusz);

if ($stmt->execute()) {
    echo "Rendelése sikeresen leadva!";
} else {
    echo "Hiba a rendelés feldolgozása során: " . $stmt->error;
}

// Kapcsolat lezárása
$stmt->close();
$conn->close();
?>
