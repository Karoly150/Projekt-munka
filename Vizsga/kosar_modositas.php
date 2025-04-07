<?php
session_start();

if (!isset($_SESSION['felhasznalo_id'])) {
    die("Hozzáférés megtagadva! Jelentkezzen be először.");
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

// POST adatok
$kosar_id = $_POST['kosar_id'] ?? null;
$mennyiseg = $_POST['mennyiseg'] ?? 1;

// Kosár mennyiségének frissítése
$sql = "UPDATE kosar SET mennyiseg = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $mennyiseg, $kosar_id);
$stmt->execute();

$stmt->close();
$conn->close();

// Átirányítás a kosár oldalára
header("Location: kosar.php");
exit;
?>
