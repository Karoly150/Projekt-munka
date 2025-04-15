<?php
session_start();

// Admin hitelesítés ellenőrzése
if (!isset($_SESSION['admin_id'])) {
    die("Hozzáférés megtagadva! Jelentkezzen be adminisztrátorként.");
}

// Adatbázis kapcsolat
$servername = "localhost";
$username = "root";
$password = "";
$database = "matyas_csarda";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

// Étel ID ellenőrzése
$etel_id = $_GET['id'] ?? null;
if (!$etel_id) {
    die("Hibás vagy hiányzó ID.");
}

// Étel törlése
$sql = "DELETE FROM etelek WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $etel_id);

if ($stmt->execute()) {
    echo "Az étel sikeresen törlésre került!";
} else {
    echo "Hiba történt: " . $stmt->error;
}

$stmt->close();
$conn->close();

// Átirányítás vissza az admin panelre
header("Location: admin_panel.php");
exit;
