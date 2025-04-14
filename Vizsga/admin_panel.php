<?php
session_start();

// Ellenőrizzük, hogy az admin be van-e jelentkezve
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_bejelentkezes.html");
    exit;
}

// Kijelentkezés funkció
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy(); // Munkamenet befejezése
    header("Location: admin_bejelentkezes.html"); // Átirányítás az admin bejelentkezési oldalra
    exit;
}

// Adatbázis kapcsolat
$servername = "localhost";
$username = "root";
$password = "";
$database = "matyas_csarda";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

// Ételek lekérdezése az adatbázisból
$etelek_sql = "SELECT id, nev, leiras, ar, elkeszitheto, kep FROM etelek";
$etelek_result = $conn->query($etelek_sql);

if (!$etelek_result) {
    die("SQL hiba: " . $conn->error);
}

// Beérkező rendelések lekérdezése
$rendelesek_sql = "
    SELECT r.id, r.felhasznalo_id, r.etel_id, r.mennyiseg, r.statusz, e.nev AS etel_nev
    FROM rendelesek r
    JOIN etelek e ON r.etel_id = e.id
    WHERE r.statusz = 'függőben'
";
$rendelesek_result = $conn->query($rendelesek_sql);

if (!$rendelesek_result) {
    die("SQL hiba: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <title>Admin Panel</title>
    <style>
        .etel-kep {
            height: 50px;
            width: 50px;
            object-fit: cover; /* Az arányok megőrzése mellett illesztés */
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Adminisztrációs Panel</h2>
        <div class="text-end mb-3">
            <!-- Kijelentkezés gomb -->
            <a href="admin_panel.php?action=logout" class="btn btn-danger">Kijelentkezés</a>
        </div>

        <!-- Ételek kezelése -->
        <h3 class="mt-4">Ételek Kezelése</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Étel Neve</th>
                    <th>Leírás</th>
                    <th>Ár</th>
                    <th>Kép</th>
                    <th>Elérhetőség</th>
                    <th>Műveletek</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $etelek_result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['nev']); ?></td>
                        <td><?php echo htmlspecialchars($row['leiras']); ?></td>
                        <td><?php echo htmlspecialchars($row['ar']); ?> Ft</td>
                        <td>
                            <?php if (!empty($row['kep'])): ?>
                                <img src="kepek/<?php echo htmlspecialchars($row['kep']); ?>" alt="Étel kép" class="etel-kep">
                            <?php else: ?>
                                Nincs kép
                            <?php endif; ?>
                        </td>
                        <td><?php echo $row['elkeszitheto'] == 1 ? 'Elérhető' : 'Nem elérhető'; ?></td>
                        <td>
                            <a href="etel_szerkesztese.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Módosítás</a>
                            <a href="etel_torlese.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Biztosan törölni szeretné ezt az ételt?');">Törlés</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="text-center mt-3">
            <a href="etel_hozzaadas.php" class="btn btn-success">Új Étel Hozzáadása</a>
        </div>

        <!-- Beérkező rendelések -->
        <h3 class="mt-5">Beérkező Rendelések</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Rendelés ID</th>
                    <th>Felhasználó ID</th>
                    <th>Étel Neve</th>
                    <th>Mennyiség</th>
                    <th>Státusz</th>
                    <th>Műveletek</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($rendelesek_result->num_rows > 0) { ?>
                    <?php while ($row = $rendelesek_result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['felhasznalo_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['etel_nev']); ?></td>
                            <td><?php echo htmlspecialchars($row['mennyiseg']); ?></td>
                            <td><?php echo htmlspecialchars($row['statusz']); ?></td>
                            <td>
                                <a href="rendeles_elfogadas.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">Elfogadás</a>
                                <a href="rendeles_elutasitas.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Elutasítás</a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="6" class="text-center">Nincsenek függőben lévő rendelések.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php $conn->close(); ?>
