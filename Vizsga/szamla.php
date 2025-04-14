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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && 
    isset($_POST['telepules'], $_POST['varos'], $_POST['utca'], $_POST['hazszam'], $_POST['telefonszam'], $_POST['fizetes'])) {
    $telepules = htmlspecialchars($_POST['telepules']);
    $varos = htmlspecialchars($_POST['varos']);
    $utca = htmlspecialchars($_POST['utca']);
    $hazszam = htmlspecialchars($_POST['hazszam']);
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

// Lekérjük a legutóbbi rendelés dátumát ami minden esetben a a számlázsás utáni rendelés
$sql = "SELECT rendeles_datuma FROM rendelesek WHERE felhasznalo_id = ? ORDER BY rendeles_datuma DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $felhasznalo_id);
$stmt->execute();
$stmt->bind_result($rendeles_datuma);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <title>Számla</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #fdf5e6; /* Halvány bézs háttér */
            color: #4b3621; /* Sötétbarna szöveg */
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background: #fffaf0; /* Világos bézs háttér */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            border: 2px solid #deb887; /* Világos barna keret */
        }

        h2 {
            color: #8b4513; /* Sötétbarna cím */
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        p, ul {
            font-size: 18px;
            line-height: 1.6;
        }

        ul {
            list-style-type: square;
            padding-left: 20px;
        }

        hr {
            border: 1px solid #deb887; /* Világos barna vonal */
            margin: 20px 0;
        }

        .btn-back {
            background-color: #8b4513; /* Sötétbarna gomb */
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-back:hover {
            background-color: #8b4513; /* Még sötétebb barna */
            color: white;
        }

        .text-center {
            text-align: center ;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Mátyás Csárda számla</h2>
        <p><strong>Teljes Név:</strong> <?php echo $_SESSION['teljesnev']; ?></p>
        <p><strong>Telefonszám:</strong> <?php echo $telefonszam; ?></p>
        <p><strong>Kiszállítási cím:</strong> 
            <?php echo htmlspecialchars($_POST['telepules']) . ", " . 
                       htmlspecialchars($_POST['varos']) . ", " . 
                       htmlspecialchars($_POST['utca']) . " " . 
                       htmlspecialchars($_POST['hazszam']); ?>
        </p>
        <p><strong>Fizetési mód:</strong> <?php echo $fizetes === 'keszpenz' ? 'Készpénz' : 'Bankkártya'; ?></p>
        <p><strong>Rendelés dátuma:</strong> <?php echo $rendeles_datuma; ?></p>
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