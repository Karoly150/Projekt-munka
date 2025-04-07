<?php
session_start();

if (!isset($_SESSION['felhasznalo_id'])) {
    die('<div class="container mt-5">
            <h2 class="text-center text-danger">Hozzáférés megtagadva!</h2>
            <p>A rendelés véglegesítéséhez jelentkezzen be.</p>
            <a href="bejelentkezes.html" class="btn btn-primary">Bejelentkezés</a>
         </div>');
}

// Kosár ellenőrzése
if (!isset($_SESSION['kosar']) || empty($_SESSION['kosar'])) {
    die('<div class="container mt-5">
            <h2 class="text-center text-danger">Üres kosár</h2>
            <p>Kérjük, adjon hozzá ételeket a kosárhoz!</p>
            <a href="kosar.php" class="btn btn-primary">Vissza a kosárhoz</a>
         </div>');
}

// Végösszeg kiszámítása
$vegosszeg = 0;
foreach ($_SESSION['kosar'] as $item) {
    $vegosszeg += $item['ar'] * $item['mennyiseg'];
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <title>Rendelés Összegzése</title>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Rendelés Összegzése</h2>
        <p><strong>Végösszeg:</strong> <?php echo $vegosszeg; ?> Ft</p>
        <form action="szamla.php" method="POST">
            <div class="mb-3">
                <label for="lakhely" class="form-label">Lakhely (szállítási cím)</label>
                <input type="text" id="lakhely" name="lakhely" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="telefonszam" class="form-label">Telefonszám</label>
                <input type="tel" id="telefonszam" name="telefonszam" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="fizetes" class="form-label">Fizetési mód</label>
                <select id="fizetes" name="fizetes" class="form-select" required>
                    <option value="keszpenz">Készpénz</option>
                    <option value="bankkartya" disabled>Bankkártya (Fejlesztés alatt)</option>
                </select>
            </div>
            <div class="text-center">
                <a href="kosar.php" class="btn btn-warning">Rendelés Módosítása</a>
                <button type="submit" class="btn btn-success">Rendelés Véglegesítése</button>
            </div>
        </form>
    </div>
</body>
</html>
