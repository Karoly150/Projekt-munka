<?php
session_start();

// Ellenőrizzük, hogy az admin be van-e jelentkezve
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

// Ellenőrizzük az URL-ből érkező azonosítót
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $rendeles_id = intval($_GET['id']);

    // Rendelés státuszának frissítése
    $sql = "UPDATE rendelesek SET statusz = 'Elfogadva' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $rendeles_id);

    if ($stmt->execute()) {
        header("Location: admin_panel.php?msg=elfogadva");
        exit;
    } else {
        echo "Hiba történt: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Érvénytelen rendelés azonosító.";
}

$conn->close();
?>
