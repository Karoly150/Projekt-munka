<?php
include 'fejlec.php';

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
    <title>Étlap</title>
    <style>
        /* Ismétlődő kép hozzáadása az oldal széléhez */
        body {
            background-image: url('kepek/oldalsav.jpg'); /* Kép elérési útját megadni */
            background-repeat: repeat-y; /* Függőleges ismétlődés */
            background-position: left; /* Bal oldalon ismétlődjön */
            
            background-size: 120px; /* Kép mérete */
            background-color:white; /* Háttérszín */
            
        }

        /* Kártyák testreszabott stílusa */
        .card {
            border: 1px solid #8b0000; /* Bordó keret */
            border-radius: 10px; /* Lekerekített sarkok */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); /* Árnyék */
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Hover animáció */
        }

        .card:hover {
            transform: scale(1.05); /* Finom nagyítás hoverkor */
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.3); /* Erősebb árnyék hoverkor */
        }

        .card-img-top {
            object-fit: cover;
            height: 200px; /* Fix kép magasság */
            width: 100%; /* Teljes szélesség */
            border-bottom: 2px solid #8b0000; /* Bordó vonal a kép alatt */
        }

        .card-body {
            background-color: #fffaf0; /* Krémszín háttér a kártya tartalmának */
            padding: 15px; /* Kényelmes margók */
            display: flex;
            flex-direction: column;
        }

        .card-title {
            font-size: 20px;
            color: #8b0000; /* Bordó cím */
            text-align: center;
            font-weight: bold; /* Félkövér cím */
        }

        .card-text {
            font-size: 16px;
            color: #333333; /* Sötét szöveg */
            text-align: justify; /* Igazított szöveg */
            margin-top: 10px;
        }

        .card-text:last-child {
            font-weight: bold; /* Az ár kiemelése */
            color: #8b0000; /* Bordó ár */
            text-align: center;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Étlap</h2>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php if ($result->num_rows > 0) { ?>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="col">
                    <div class="card h-100">
                        <?php if (!empty($row['kep'])): ?>
                            <img src="kepek/<?php echo htmlspecialchars($row['kep']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['nev']); ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['nev']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($row['leiras']); ?></p>
                            <p class="card-text"><strong>Ár: <?php echo htmlspecialchars($row['ar']); ?> Ft</strong></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p class="text-center">Jelenleg nincs elérhető étel az étlapon.</p>
        <?php } ?>
    </div>
</div>

</body>
</html>

<?php
$conn->close();
?>
