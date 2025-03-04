<?php
// index.php - Főoldal

session_start(); // Munkamenet indítása (csak egyszer hívjuk meg)
include 'includes_header.php'; // Fejléc betöltése
?>

<h1>Üdvözöljük a Csárda éttermünkben!</h1>
<p>Kérjük, jelentkezzen be a rendeléshez.</p>

<?php
include 'includes_footer.php'; // Lábléc betöltése
?>