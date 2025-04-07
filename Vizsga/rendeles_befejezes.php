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

// Kosár ellenőrzése és inicializálása, ha nincs $_SESSION['kosar']
if (!isset($_SESSION['kosar']) || empty($_SESSION['kosar'])) {
    $_SESSION['kosar'] = [];
    $felhasznalo_id = $_SESSION['felhasznalo_id'];

    $sql = "SELECT k.etel_id, e.nev, e.ar, k.mennyiseg
            FROM kosar k
            JOIN etelek e ON k.etel_id = e.id
            WHERE k.felhasznalo_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $felhasznalo_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $_SESSION['kosar'][] = $row;
    }
    $stmt->close();
}

// Ellenőrizd, hogy van-e tartalom a kosárban
if (empty($_SESSION['kosar'])) {
    die('<div class="container mt-5">
            <h2 class="text-center text-danger">Üres kosár</h2>
            <p>A rendeléshez először adjon hozzá ételeket a kosárhoz!</p>
            <a href="rendeles.php" class="btn btn-primary">Vissza a rendeléshez</a>
         </div>');
}

// Kosár tartalmának és végösszeg kiszámítása
$vegosszeg = 0;
foreach ($_SESSION['kosar'] as $item) {
    $vegosszeg += $item['ar'] * $item['mennyiseg'];
}

// Továbbirányítás az összegző oldalra
header("Location: osszegzes.php");
exit;
?>
