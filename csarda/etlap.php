<?php
// etlap.php - Étlap megjelenítése

session_start(); // Munkamenet indítása (csak egyszer hívjuk meg)
include 'includes_db.php'; // Adatbázis kapcsolat betöltése
include 'includes_header.php'; // Fejléc betöltése (itt már nem hívjuk meg a session_start()-ot)

// Ételek lekérése az adatbázisból
$sql = "SELECT * FROM etelek";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<h3>" . $row['nev'] . "</h3>";
        echo "<p>" . $row['leiras'] . "</p>";
        echo "<p>Ár: " . $row['ar'] . " Ft</p>";
        echo "</div>";
    }
} else {
    echo "Nincsenek ételek az étlapon.";
}

include 'includes_footer.php'; // Lábléc betöltése
?>

<h2>Étlap</h2>
<div id="etelek">
    <!-- Az ételek dinamikusan jelennek meg itt -->
</div>

<script>
// Ételek dinamikus megjelenítése JavaScript segítségével
var etelek = <?php echo json_encode($etelek); ?>; // Ételek átadása JavaScriptnek
var etelekDiv = document.getElementById('etelek');

etelek.forEach(function(etel) {
    var etelElem = document.createElement('div');
    etelElem.innerHTML = '<h3>' + etel.nev + '</h3><p>' + etel.leiras + '</p><p>Ár: ' + etel.ar + ' Ft</p>';
    etelekDiv.appendChild(etelElem);
});
</script>

<?php
include 'includes_footer.php'; // Lábléc betöltése
?>