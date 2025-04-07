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

// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
if (!isset($_SESSION['felhasznalo_id'])) {
    die('<div class="container mt-5">
            <h2 class="text-center text-danger">Hozzáférés megtagadva!</h2>
            <p>Kérjük, jelentkezzen be!</p>
            <a href="bejelentkezes.html" class="btn btn-primary">Bejelentkezés</a>
         </div>');
}

// Felhasználó azonosítója
$felhasznalo_id = $_SESSION['felhasznalo_id'];

// Kosár törlése az adatbázisból
$sql = "DELETE FROM kosar WHERE felhasznalo_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $felhasznalo_id);

if ($stmt->execute()) {
    // Sikeres törlés után átirányítás
    $stmt->close();
    $conn->close();
    header("Location: index.php");
    exit;
} else {
    // Hibaüzenet
    echo '<div class="container mt-5">
            <h2 class="text-center text-danger">Hiba történt a kosár törlésekor.</h2>
            <p>Próbálja újra később.</p>
            <a href="index.php" class="btn btn-primary">Vissza az oldalra</a>
         </div>';
}
?>
