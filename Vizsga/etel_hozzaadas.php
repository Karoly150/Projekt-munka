<?php
session_start();

// Admin hitelesítés ellenőrzése
if (!isset($_SESSION['admin_id'])) {
    die("Hozzáférés megtagadva! Kérjük, jelentkezzen be adminisztrátorként.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nev = $_POST['nev'] ?? null;
    $leiras = $_POST['leiras'] ?? null;
    $ar = $_POST['ar'] ?? null;
    $kep = $_POST['kep'] ?? null;
    $elkeszitheto = isset($_POST['elkeszitheto']) ? 1 : 0;

    // Adatbázis kapcsolat
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "matyas_csarda";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Kapcsolódási hiba: " . $conn->connect_error);
    }

    $sql = "INSERT INTO etelek (nev, leiras, ar, kep, elkeszitheto) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisi", $nev, $leiras, $ar, $kep, $elkeszitheto);

    if ($stmt->execute()) {
        echo "Az étel sikeresen hozzáadásra került!";
    } else {
        echo "Hiba történt: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Új Étel Hozzáadása</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Új Étel Hozzáadása</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="nev" class="form-label">Étel neve:</label>
                <input type="text" id="nev" name="nev" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="leiras" class="form-label">Leírás:</label>
                <textarea id="leiras" name="leiras" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label for="ar" class="form-label">Ár:</label>
                <input type="number" id="ar" name="ar" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="kep" class="form-label">Kép neve (pl. marhaporkolt.jpg):</label>
                <input type="text" id="kep" name="kep" class="form-control">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" id="elkeszitheto" name="elkeszitheto" class="form-check-input">
                <label for="elkeszitheto" class="form-check-label">Elérhetőség (pipáld ki, ha elérhető)</label>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success">Hozzáadás</button>
            </div>
        </form>
    </div>
</body>
</html>
