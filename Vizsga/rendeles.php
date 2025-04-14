<?php
session_start();
include 'fejlec.php';

// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
if (!isset($_SESSION['felhasznalo_id'])) {
    die('<div class="container mt-5">
            <h2 class="text-center text-danger">Hiba!</h2>
            <p class="text-center">A rendelés megtekintéséhez kérjük, 
                <a href="bejelentkezes.html" class="btn btn-primary">jelentkezzen be</a>.
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

// Az ételek lekérdezése az adatbázisból
$sql = "SELECT id, nev, leiras, ar, kep FROM etelek";
$result = $conn->query($sql);

if (!$result) {
    die("SQL hiba: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Ételek Rendelése</title>
    <style>
        /* Ismétlődő kép hozzáadása az oldal széléhez */
        body {
            background-image: url('kepek/oldalsav.jpg'); /* Kép elérési útját megadni */
            background-repeat: repeat-y; /* Függőleges ismétlődés */
            background-position: left; /* Bal oldalon ismétlődjön */
            background-size: 120px; /* Kép eredeti mérete */
            background-color: white; /* Háttérszín */
            
        }

        /* Kártyák stílusa */
        .card {
            border-radius: 10px; /* Lekerekített sarkok */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Árnyék */
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Hover animáció */
            background-color: #fffaf0; /* Krémszín háttér */
        }

        .card:hover {
            transform: scale(1.05); /* Finom nagyítás */
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.3); /* Erősebb árnyék */
        }

        .card-img-top {
            object-fit: cover;
            height: 200px; /* Fix kép magasság */
            width: 100%; /* Teljes szélesség */
            border-bottom: 2px solid #8b0000; /* Bordó elválasztó vonal */
        }

        .card-title {
            font-size: 20px;
            color: #8b0000; /* Bordó címek */
            text-align: center;
            font-weight: bold; /* Félkövér cím */
        }

        .card-text {
            font-size: 16px;
            color: #333333; /* Sötétszürke szöveg */
            text-align: justify; /* Igazított szöveg */
            margin-top: 10px;
        }

        .card-text:last-child {
            font-weight: bold; /* Ár kiemelése */
            color: #8b0000; /* Bordó ár */
            text-align: center; /* Középre igazítás */
        }

        .quantity-controls {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }

        .quantity-controls button {
            background-color: #8b0000;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 18px;
            padding: 5px 10px;
        }

        .quantity-controls button:hover {
            background-color: #6a0000; 
        }

        .quantity-controls input {
            border: 1px solid #8b0000;
            border-radius: 4px;
            text-align: center;
            width: 60px;
            height: 35px;
            pointer-events: none; /* Kézi szerkesztés tiltása */
        }

        .btn-primary {
            background-color: #8b0000;
            border: none;
            
        }

        .btn-primary:hover {
            background-color: #6a0000;
        }
    </style>
    <script>
        // Funkció a megerősítő kérdéshez
        function confirmAddition(formId) {
            const userConfirm = confirm("Biztosan hozzá szeretné adni ezt a terméket a kosárhoz?");
            if (userConfirm) {
                document.getElementById(formId).submit();
            }
        }

        // Funkció a mennyiség növelésére és csökkentésére
        function changeQuantity(change, inputId) {
            const input = document.getElementById(inputId);
            const currentValue = parseInt(input.value, 10);
            const newValue = currentValue + change;
            if (newValue > 0) {
                input.value = newValue;
            }
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Ételek Rendelése</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php if ($result->num_rows > 0) { ?>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <div class="col">
                        <div class="card h-100">
                            <?php if (!empty($row['kep'])): ?>
                                <img src="kepek/<?php echo htmlspecialchars($row['kep']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['nev']); ?>">
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column">
                                    <h5 class="card-title"><?php echo htmlspecialchars($row['nev']); ?></h5>
                                    <p class="card-text flex-grow-1"><?php echo htmlspecialchars($row['leiras']); ?></p>
                                    <p class="card-text"><strong>Ár: <?php echo htmlspecialchars($row['ar']); ?> Ft</strong></p>
                                    <form id="form-<?php echo $row['id']; ?>" action="kosar_hozzaadas.php" method="POST">
                                        <input type="hidden" name="etel_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                        <input type="hidden" name="felhasznalo_id" value="<?php echo htmlspecialchars($_SESSION['felhasznalo_id']); ?>">
                                        <label for="mennyiseg-<?php echo $row['id']; ?>" class="d-block text-center">Mennyiség:</label>
                                <div class="quantity-controls">
                                    <button type="button" onclick="changeQuantity(-1, 'mennyiseg-<?php echo $row['id']; ?>')">-</button>
                                    <input type="number" id="mennyiseg-<?php echo $row['id']; ?>" name="mennyiseg" min="1" value="1" readonly>
                                    <button type="button" onclick="changeQuantity(1, 'mennyiseg-<?php echo $row['id']; ?>')">+</button>
                                </div>
                                <button type="button" class="btn btn-primary mt-3 mx-auto d-block" onclick="confirmAddition('form-<?php echo $row['id']; ?>')">Hozzáadás a kosárhoz</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p class="text-center">Jelenleg nincs elérhető étel rendelésre.</p>
            <?php } ?>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
