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
                                <form action="kosar_modositas.php" method="POST">
                                    <input type="hidden" name="kosar_id" value="<?php echo htmlspecialchars($row['kosar_id']); ?>">
                                    <input type="number" name="mennyiseg" min="1" value="<?php echo htmlspecialchars($row['mennyiseg']); ?>" class="form-control">
                                    <button type="submit" class="btn btn-warning btn-sm mt-1">Módosítás</button>
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
                <form action="rendeles_befejezes.php" method="POST">
                    <button type="submit" class="btn btn-success">Rendelés befejezése</button>
                </form>
            <?php } ?>
        </div>
    </div>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
