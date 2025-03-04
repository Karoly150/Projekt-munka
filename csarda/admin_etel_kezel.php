<?php
// admin_etel_kezel.php - Ételek kezelése

session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: bejelentkezes.php"); // Átirányítás, ha nincs bejelentkezve
    exit();
}

include 'includes_db.php'; // Adatbázis kapcsolat betöltése
include 'includes_header.php'; // Fejléc betöltése

$sql = "SELECT * FROM etelek";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<h3>" . $row['nev'] . "</h3>";
        echo "<p>" . $row['leiras'] . "</p>";
        echo "<p>Ár: " . $row['ar'] . " Ft</p>";
        echo "<a href='admin_etel_szerkeszt.php?id=" . $row['id'] . "'>Szerkesztés</a> | ";
        echo "<a href='admin_etel_torol.php?id=" . $row['id'] . "'>Törlés</a>";
        echo "</div>";
    }
} else {
    echo "Nincsenek ételek az étlapon.";
}

include 'includes_footer.php'; // Lábléc betöltése
?>