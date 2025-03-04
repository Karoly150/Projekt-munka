<?php
// kijelentkezes.php - Kijelentkezés

session_start(); // Munkamenet indítása

// Session megszakítása
session_unset(); // Minden session változó törlése
session_destroy(); // Session megsemmisítése

// Átirányítás a főoldalra
header("Location: index.php");
exit();
?>