<?php
// admin_index.php - Admin főoldal

session_start(); // Munkamenet indítása
if (!isset($_SESSION['felhasznalo_id']) || $_SESSION['admin'] != 1) {
    header("Location: bejelentkezes.php"); // Átirányítás, ha nincs bejelentkezve vagy nem admin
    exit();
}

include 'includes_db.php'; // Adatbázis kapcsolat betöltése
include 'includes_header.php'; // Fejléc betöltése
?>

<h2>Admin felület</h2>
<ul>
    <li><a href="admin_etel_hozzaad.php">Étel hozzáadása</a></li>
    <li><a href="admin_etel_kezel.php">Ételek kezelése</a></li>
</ul>

<?php
include 'includes_footer.php'; // Lábléc betöltése
?>