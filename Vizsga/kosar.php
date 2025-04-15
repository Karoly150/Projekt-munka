<!-- filepath: c:\xampp\htdocs\Vizsga\kosar.php -->
<?php
session_start();
include 'fejlec.php';

// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
if (!isset($_SESSION['felhasznalo_id'])) {
    die('<div class="container mt-5">
            <h2 class="text-center text-danger">Hiba!</h2>
            <p class="text-center">A kosár megtekintéséhez kérjük, 
                <a href="bejelentkezes.html">jelentkezzen be</a>.
            </p>
         </div>');
}

// Kapcsolódás az adatbázishoz
$servername = "localhost";
$username = "root";
$password = "";
$database = "matyas_csarda";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

// Kosár tartalmának lekérdezése
$felhasznalo_id = $_SESSION['felhasznalo_id'];
$sql = "SELECT k.id AS kosar_id, e.nev, e.ar, k.mennyiseg, (e.ar * k.mennyiseg) AS osszeg 
        FROM kosar k 
        JOIN etelek e ON k.etel_id = e.id 
        WHERE k.felhasznalo_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $felhasznalo_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Kosár</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <style>
        h2 {
            color: #8b0000; /* Bordó cím */
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
        }

        .table {
            background-color: #fffaf0; /* Krémszín háttér a táblázatnak */
            border: 1px solid #8b0000; /* Bordó keret */
            border-radius: 10px;
            overflow: hidden; /* Lekerekített sarkok */
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2); /* Árnyék */
        }

        .table thead {
            background-color: #8b0000; /* Bordó fejlécek */
            color: white; /* Fehér szöveg */
        }

        .table th,
        .table td {
            vertical-align: middle;
            text-align: center; /* Középre igazított szöveg */
        }

        .table tbody tr:hover {
            background-color: #f9f5e6; /* Világosabb árnyék soronként hoverkor */
        }

        .btn {
            border: none;
            border-radius: 5px;
        }

        .btn-outline-secondary {
            color: #8b0000; /* Bordó szöveg */
            border-color: #8b0000; /* Bordó keret */
        }

        .btn-outline-secondary:hover {
            background-color: #8b0000; /* Bordó háttér */
            color: white; /* Fehér szöveg */
        }

        .btn-danger {
            background-color: #dc3545; /* Piros gombok */
        }

        .btn-danger:hover {
            background-color: #a71d2a; /* Sötétebb piros hover */
        }

        .btn-success {
        background-color: #8b0000; /* Bordó szín */
        color: white; /* Fehér szöveg */
        }

        .btn-success:hover {
        background-color: #8b0000; /* Ugyanaz a szín marad hover esetén */
        color: white; /* Szöveg színe változatlan */
        }
        
        .kosaralatt {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: auto;
         
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Kosár tartalma</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Étel neve</th>
                    <th>Ár (Ft)</th>
                    <th>Mennyiség</th>
                    <th>Összeg (Ft)</th>
                    <th>Műveletek</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                <?php if ($result->num_rows > 0) { ?>
                    <?php while ($row = $result->fetch_assoc()) { 
                        $total += $row['osszeg'];
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nev']); ?></td>
                            <td><?php echo htmlspecialchars($row['ar']); ?></td>
                            <td>
                                <form action="kosar_modositas.php" method="POST" class="d-flex align-items-center justify-content-center">
                                    <input type="hidden" name="kosar_id" value="<?php echo htmlspecialchars($row['kosar_id']); ?>">
                                    <button type="submit" name="action" value="decrease" class="btn btn-outline-secondary btn-sm">-</button>
                                    <input type="number" name="mennyiseg" min="1" value="<?php echo htmlspecialchars($row['mennyiseg']); ?>" class="form-control text-center mx-2" style="width: 60px;" readonly>
                                    <button type="submit" name="action" value="increase" class="btn btn-outline-secondary btn-sm">+</button>
                                </form>
                            </td>
                            <td><?php echo htmlspecialchars($row['osszeg']); ?></td>
                            <td>
                                <form action="kosar_torles.php" method="POST">
                                    <input type="hidden" name="kosar_id" value="<?php echo htmlspecialchars($row['kosar_id']); ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Törlés</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="5" class="text-center">A kosár üres.</td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Teljes összeg:</th>
                    <th colspan="2"><?php echo $total; ?> Ft</th>
                </tr>
            </tfoot>
        </table>
        <div class="text-center">
            <?php if ($total > 0) { ?>
                <a href="rendeles.php" class="btn btn-success d-inline-block">Rendelés folytatása</a>
                <form action="rendeles_befejezes.php" method="POST" class="d-inline">
                    <button type="submit" class="btn btn-success">Rendelés befejezése</button>
                </form>
            <?php } ?>
        </div>
    </div>
    <img class="kosaralatt" src="kepek/kosaralatt.jpg" alt="kep">
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>