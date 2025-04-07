<?php
// Kapcsolódás az adatbázishoz
$servername = "localhost";
$username = "root";
$password = "";
$database = "matyas_csarda";

$conn = new mysqli($servername, $username, $password, $database);

// Kapcsolat ellenőrzése
if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

// Étel azonosító és új státusz lekérése az URL-ből
if (isset($_GET['id']) && isset($_GET['status'])) {
    $etel_id = $_GET['id'];
    $uj_statusz = $_GET['status'];

    // Étel elérhetőségének frissítése
    $sql = "UPDATE etelek SET elkeszitheto = $uj_statusz WHERE id = $etel_id";

    if ($conn->query($sql) === TRUE) {
        echo "Az étel státusza sikeresen frissítve!";
    } else {
        echo "Hiba az étel státuszának frissítése során: " . $conn->error;
    }
} else {
    echo "Érvénytelen kérés!";
}

// Kapcsolat lezárása
$conn->close();
?>
