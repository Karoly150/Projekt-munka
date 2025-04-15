<!-- filepath: c:\xampp\htdocs\Vizsga\kosar_modositas.php -->
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
$action = $_POST['action'] ?? null;

if ($kosar_id && $action) {
    if ($action === 'increase') {
        $sql = "UPDATE kosar SET mennyiseg = mennyiseg + 1 WHERE id = ?";
    } elseif ($action === 'decrease') {
        $sql = "UPDATE kosar SET mennyiseg = GREATEST(mennyiseg - 1, 1) WHERE id = ?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $kosar_id);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header("Location: kosar.php");
exit;
?>