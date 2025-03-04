<?php
// includes_header.php - Fejléc

if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Munkamenet indítása (csak akkor, ha még nem indult el)
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Csárda étterem</title>
    <link rel="stylesheet" href="css/stilus.css">
</head>
<body>
    <header>
        <h1>Csárda étterem</h1>
        <nav>
            <a href="index.php">Főoldal</a> |
            <a href="etlap.php">Étlap</a> |
            <a href="rendeles.php">Rendelés</a> |
            <?php if (isset($_SESSION['felhasznalo_id'])): ?>
                <!-- Ha a felhasználó be van jelentkezve, "Kijelentkezés" gomb -->
                <a href="kijelentkezes.php">Kijelentkezés</a>
            <?php else: ?>
                <!-- Ha a felhasználó nincs bejelentkezve, "Bejelentkezés" és "Regisztráció" gomb -->
                <a href="bejelentkezes.php">Bejelentkezés</a> |
                <a href="regisztracio.php">Regisztráció</a>
            <?php endif; ?>
        </nav>
    </header>