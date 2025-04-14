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
$etel_id = $_POST['etel_id'] ?? null;
$felhasznalo_id = $_SESSION['felhasznalo_id'];
$mennyiseg = $_POST['mennyiseg'] ?? 1;

// Ellenőrizzük, hogy az étel már szerepel-e a felhasználó kosarában
$sql = "SELECT mennyiseg FROM kosar WHERE felhasznalo_id = ? AND etel_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $felhasznalo_id, $etel_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Ha már benne van, növeljük a mennyiséget
    $row = $result->fetch_assoc();
    $uj_mennyiseg = $row['mennyiseg'] + $mennyiseg;
    $update_sql = "UPDATE kosar SET mennyiseg = ? WHERE felhasznalo_id = ? AND etel_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("iii", $uj_mennyiseg, $felhasznalo_id, $etel_id);
    $update_stmt->execute();
    $update_stmt->close();
} else {
    // Ha nincs benne, adjuk hozzá új tételként
    $insert_sql = "INSERT INTO kosar (felhasznalo_id, etel_id, mennyiseg) VALUES (?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("iii", $felhasznalo_id, $etel_id, $mennyiseg);
    $insert_stmt->execute();
    $insert_stmt->close();
}

$stmt->close();
$conn->close();

// Átirányítás vissza a rendelési oldalra
header("Location: rendeles.php");
exit;
?>
