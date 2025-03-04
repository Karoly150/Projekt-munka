<?php
// rendeles.php - Rendelési oldal

session_start();
if (!isset($_SESSION['felhasznalo_id'])) {
    header("Location: bejelentkezes.php"); // Átirányítás, ha nincs bejelentkezve
    exit();
}

include 'includes_db.php'; // Adatbázis kapcsolat betöltése
include 'includes_header.php'; // Fejléc betöltése

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $etel_id = $_POST['etel_id'];
    $mennyiseg = $_POST['mennyiseg'];
    $felhasznalo_id = $_SESSION['felhasznalo_id'];

    // Rendelés rögzítése az adatbázisban
    $sql = "INSERT INTO rendelesek (felhasznalo_id, etel_id, mennyiseg) VALUES ('$felhasznalo_id', '$etel_id', '$mennyiseg')";
    if ($conn->query($sql) === TRUE) {
        echo "Rendelés sikeresen rögzítve!";
    } else {
        echo "Hiba: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT * FROM etelek";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<form method='post' action=''>";
        echo "<h3>" . $row['nev'] . "</h3>";
        echo "<p>" . $row['leiras'] . "</p>";
        echo "<p>Ár: " . $row['ar'] . " Ft</p>";
        echo "<input type='hidden' name='etel_id' value='" . $row['id'] . "'>";
        echo "Mennyiség: <input type='number' name='mennyiseg' min='1' value='1'>";
        echo "<input type='submit' value='Rendelés'>";
        echo "</form>";
    }
} else {
    echo "Nincsenek ételek az étlapon.";
}

include 'includes_footer.php'; // Lábléc betöltése
?>