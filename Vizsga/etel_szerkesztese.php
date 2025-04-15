<?php
session_start();

// Admin hitelesítés ellenőrzése
if (!isset($_SESSION['admin_id'])) {
    die("Hozzáférés megtagadva! Jelentkezzen be adminisztrátorként.");
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

// Étel ID ellenőrzése
$etel_id = $_GET['id'] ?? null;
if (!$etel_id) {
    die("Hibás vagy hiányzó ID.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nev = $_POST['nev'] ?? null;
    $leiras = $_POST['leiras'] ?? null;
    $ar = $_POST['ar'] ?? null;
    $kep = $_POST['kep'] ?? null;
    $elkeszitheto = isset($_POST['elkeszitheto']) ? 1 : 0;

    // Étel adatainak frissítése
    $sql = "UPDATE etelek SET nev = ?, leiras = ?, ar = ?, kep = ?, elkeszitheto = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisii", $nev, $leiras, $ar, $kep, $elkeszitheto, $etel_id);

    if ($stmt->execute()) {
        echo "Az étel sikeresen frissítve lett!";
    } else {
        echo "Hiba történt: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    exit;
}

// Étel adatainak betöltése
$sql = "SELECT nev, leiras, ar, kep, elkeszitheto FROM etelek WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $etel_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    die("Nem található az adott étel.");
}

$etel = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Étel Szerkesztése</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Étel Szerkesztése</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="nev" class="form-label">Étel neve:</label>
                <input type="text" id="nev" name="nev" value="<?php echo htmlspecialchars($etel['nev']); ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="leiras" class="form-label">Leírás:</label>
                <textarea id="leiras" name="leiras" class="form-control" required><?php echo htmlspecialchars($etel['leiras']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="ar" class="form-label">Ár:</label>
                <input type="number" id="ar" name="ar" value="<?php echo htmlspecialchars($etel['ar']); ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="kep" class="form-label">Kép neve:</label>
                <input type="text" id="kep" name="kep" value="<?php echo htmlspecialchars($etel['kep']); ?>" class="form-control">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" id="elkeszitheto" name="elkeszitheto" class="form-check-input" <?php echo $etel['elkeszitheto'] ? 'checked' : ''; ?>>
                <label for="elkeszitheto" class="form-check-label">Elérhetőség (pipáld ki, ha elérhető)</label>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Mentés</button>
            </div>
        </form>
    </div>
</body>
</html>
