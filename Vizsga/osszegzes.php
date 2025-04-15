<?php
session_start();

if (!isset($_SESSION['felhasznalo_id'])) {
    die('<div class="container mt-5">
            <h2 class="text-center text-danger">Hozzáférés megtagadva!</h2>
            <p class="text-center">A rendelés véglegesítéséhez jelentkezzen be.</p>
            <a href="bejelentkezes.html" class="btn btn-primary">Bejelentkezés</a>
         </div>');
}

// Kosár ellenőrzése
if (!isset($_SESSION['kosar']) || empty($_SESSION['kosar'])) {
    die('<div class="container mt-5">
            <h2 class="text-center text-danger">Üres kosár</h2>
            <p class="text-center">Kérjük, adjon hozzá ételeket a kosárhoz!</p>
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
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #fdf5e6; /* Világos bézs háttér */
            color: #4b3621; /* Sötétbarna szöveg */
        }

        h2 {
            color: #8b0000; /* Bordó cím */
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
        }

        p {
            font-size: 18px;
            color: #333333; /* Sötét szöveg */
            margin-bottom: 20px;
        }

        label {
            color: #8b0000; /* Bordó szöveg */
            font-weight: bold;
        }

        .form-control,
        .form-select {
            border: 1px solid #8b0000; /* Bordó keret */
            border-radius: 5px;
        }

        .form-control:focus, 
        .form-select:focus {
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2); /* Enyhe árnyék fókuszkor */
            border-color: #6a0000; /* Sötétebb bordó */
        }

        .btn { /* Gombok stílusa */
            border: none;
            border-radius: 5px;
        }

        .btn-warning {
            background-color: #ffa500; /* Narancssárga gomb */
            color: white;
        }

        .btn-warning:hover {
            background-color: #cc8400; /* Sötétebb narancssárga */
            color: white;
        }

        .btn-success {
            background-color: #28a745; /* Zöld gomb */
        }

        .btn-success:hover {
            background-color: #1e7e34; /* Sötétebb zöld */
        }

        .container {
            background-color: #fffaf0; /* Világos bézs doboz */
            border: 2px solid #deb887; /* Világos barna keret */
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            padding: 30px;
            max-width: 600px;
            margin: 50px auto;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Rendelés Összegzése</h2>
    
    <!-- Rendelt ételek megjelenítése -->
    <div class="mb-4">
        <h4>Rendelt ételek:</h4>
        <ul class="list-group">
            <?php foreach ($_SESSION['kosar'] as $item) { ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?php echo htmlspecialchars($item['nev']); ?>
                    <span class="badge bg-primary rounded-pill"><?php echo htmlspecialchars($item['mennyiseg']); ?> db</span>
                </li>
            <?php } ?>
        </ul>
    </div>

    <form action="szamla.php" method="POST"> <!-- A form action a szamla.php-ra mutat -->
        <div class="mb-3">
            <label for="telepules" class="form-label">Település (Megye)</label>
            <input type="text" id="telepules" name="telepules" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="varos" class="form-label">Város</label>
            <input type="text" id="varos" name="varos" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="utca" class="form-label">Utca</label>
            <input type="text" id="utca" name="utca" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="hazszam" class="form-label">Házszám</label>
            <input type="text" id="hazszam" name="hazszam" class="form-control" required>
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
        <p><strong>Végösszeg:</strong> <?php echo $vegosszeg; ?> Ft</p>
        <div class="text-center">
            <a href="kosar.php" class="btn btn-warning">Rendelés módosítása</a>
            <button type="submit" class="btn btn-success">Rendelés véglegesítése</button>
        </div>
    </form>
</div>
</body>
</html>