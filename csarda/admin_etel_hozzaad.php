<?php
// admin_etel_hozzaad.php - Étel hozzáadása

session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: bejelentkezes.php"); // Átirányítás, ha nincs bejelentkezve
    exit();
}

include 'includes_db.php'; // Adatbázis kapcsolat betöltése
include 'includes_header.php'; // Fejléc betöltése

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nev = $_POST['nev'];
    $leiras = $_POST['leiras'];
    $ar = $_POST['ar'];

    // Étel hozzáadása az adatbázisba
    $sql = "INSERT INTO etelek (nev, leiras, ar) VALUES ('$nev', '$leiras', '$ar')";
    if ($conn->query($sql) === TRUE) {
        echo "Étel sikeresen hozzáadva!";
    } else {
        echo "Hiba: " . $sql . "<br>" . $conn->error;
    }
}
?>

<h2>Étel hozzáadása</h2>
<form method="post" action="">
    Név: <input type="text" name="nev" required><br>
    Leírás: <textarea name="leiras" required></textarea><br>
    Ár: <input type="number" name="ar" required><br>
    <input type="submit" value="Hozzáadás">
</form>

<?php
include 'includes_footer.php'; // Lábléc betöltése
?>