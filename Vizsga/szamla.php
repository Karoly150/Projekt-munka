<?php
session_start();

// Kapcsolódás az adatbázishoz
$servername = "localhost";
$username = "root";
$password = "";
$database = "matyas_csarda";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
if (!isset($_SESSION['felhasznalo_id'])) {
    die('<div class="container mt-5">
            <h2 class="text-center text-danger">Hozzáférés megtagadva!</h2>
            <p>A számla megjelenítéséhez jelentkezzen be.</p>
            <a href="bejelentkezes.html" class="btn btn-primary">Bejelentkezés</a>
         </div>');
}

// Kosár ellenőrzése
if (!isset($_SESSION['kosar']) || empty($_SESSION['kosar'])) {
    die('<div class="container mt-5">
            <h2 class="text-center text-warning">Hiba történt!</h2>
            <p>A kosár jelenleg üres.</p>
            <a href="index.php" class="btn btn-primary">Vissza az oldalra</a>
         </div>');
}

// POST-adatok feldolgozása
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lakhely'], $_POST['telefonszam'], $_POST['fizetes'])) {
    $lakhely = htmlspecialchars($_POST['lakhely']);
    $telefonszam = htmlspecialchars($_POST['telefonszam']);
    $fizetes = htmlspecialchars($_POST['fizetes']);
} else {
    die('<div class="container mt-5">
            <h2 class="text-center text-danger">Hiba!</h2>
            <p>Kérjük, töltse ki az összes mezőt az összegzésnél!</p>
            <a href="osszegzes.php" class="btn btn-primary">Vissza az összegzéshez</a>
         </div>');
}

// Felhasználó azonosítója
$felhasznalo_id = $_SESSION['felhasznalo_id'];

// Végösszeg inicializálása
$vegosszeg = 0;

// Rendelések feldolgozása és végösszeg számítása
foreach ($_SESSION['kosar'] as $item) {
    $vegosszeg += $item['ar'] * $item['mennyiseg'];

    $sql = "INSERT INTO rendelesek (felhasznalo_id, etel_id, mennyiseg, statusz) VALUES (?, ?, ?, 'függőben')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $felhasznalo_id, $item['etel_id'], $item['mennyiseg']);

    if (!$stmt->execute()) {
        die('<div class="container mt-5">
                <h2 class="text-center text-danger">Hiba történt a rendelés mentésekor.</h2>
                <p>Kérjük próbálja újra később.</p>
                <a href="index.php" class="btn btn-primary">Vissza az oldalra</a>
             </div>');
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <title>Számla</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; }
        .container { max-width: 700px; margin-top: 50px; background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); }
        .btn-back { background-color: #007bff; color: white; border: none; padding: 10px 20px; font-size: 16px; border-radius: 5px; cursor: pointer; text-decoration: none; }
        .btn-back:hover { background-color: #0056b3; }
        h2, h3, h4 { color: #343a40; }
        p { font-size: 16px; color: #343a40; }
        ul { list-style-type: square; padding-left: 20px; color: #343a40; }
        hr { border: 1px solid #ccc; }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Számla</h2>
        <p><strong>Teljes Név:</strong> <?php echo $_SESSION['teljesnev']; ?></p>
        <p><strong>Telefonszám:</strong> <?php echo $telefonszam; ?></p>
        <p><strong>Lakhely (szállítási cím):</strong> <?php echo $lakhely; ?></p>
        <p><strong>Fizetési mód:</strong> <?php echo $fizetes === 'keszpenz' ? 'Készpénz' : 'Bankkártya'; ?></p>
        <hr>
        <h3>Rendelt Ételek:</h3>
        <ul>
            <?php foreach ($_SESSION['kosar'] as $item): ?>
                <li>
                    <?php echo htmlspecialchars($item['nev']) . " - " . $item['mennyiseg'] . " db, " . ($item['ar'] * $item['mennyiseg']) . " Ft"; ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <hr>
        <h4><strong>Végösszeg:</strong> <?php echo $vegosszeg; ?> Ft</h4>
        <div class="text-center mt-4">
            <a href="kosar_kiurites.php" class="btn-back">Vissza az oldalra</a>
        </div>
    </div>
</body>
</html>
