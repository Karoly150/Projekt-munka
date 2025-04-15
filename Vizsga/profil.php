<?php
session_start();
include 'fejlec.php';
// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve.
if (!isset($_SESSION['felhasznalo_id'])) {
    header("Location: bejelentkezes.php");
    exit();
}



// Adatbázis kapcsolat létrehozása a korábban használt változókkal.
$servername = "localhost";
$username   = "root";
$password   = "";
$database   = "matyas_csarda";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

// Lekérjük a bejelentkezett felhasználó azonosítóját.
$userId = intval($_SESSION['felhasznalo_id']);

// Felhasználói adatok lekérése a "felhasznalok" táblából.
$sqlUser = "SELECT felhasznalonev, email, teljesnev 
            FROM felhasznalok 
            WHERE id = $userId";
$resultUser = $conn->query($sqlUser);
if ($resultUser && $resultUser->num_rows > 0) {
    $user = $resultUser->fetch_assoc();
} else {
    die("Nem sikerült lekérni a felhasználói adatokat.");
}

/* Lekérjük a felhasználó korábbi rendeléseit a "rendelesek" táblából,
 időrendi sorrendben.*/
$sqlOrders = "SELECT r.id AS order_id, r.rendeles_datuma, r.mennyiseg, r.statusz, e.nev AS etel_nev 
              FROM rendelesek r
              LEFT JOIN etelek e ON r.etel_id = e.id
              WHERE r.felhasznalo_id = $userId 
              ORDER BY r.rendeles_datuma DESC";
$resultOrders = $conn->query($sqlOrders);
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil  <?php echo htmlspecialchars($user['felhasznalonev']); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fdf5e6;
            margin: 20px;
            color: #333;
        }
        .profil-container {
            max-width: 800px;
            margin: 0 auto;
        }
        h1, h2 {
            color: #8b0000;
        }
        .user-info, .orders {
            background: #fff;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0px 4px 6px rgba(0,0,0,0.1);
        }
        .user-info p {
            font-size: 16px;
            line-height: 1.4;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 8px 12px;
            text-align: left;
        }
        th {
            background-color: #8b0000;
            color: #fff;
        }
        .user-header {
            display: flex;
            align-items: center;
        }
        .logoimg{
            width: 100px; /* Kép szélessége */
            height: auto; /* Magasság automatikus */
            margin-right: 20px; /* Jobb oldali margó */
          
        }
        
    </style>
</head>
<body>
    <div class="profil-container">
        <h1>Profilom</h1>
        
        <!-- Felhasználói adatok megjelenítése -->
        <div class="user-info">
            <div class="user-header">
                
                <img src="kepek/matyascsardalogo.jpg" alt="Logo" class="logoimg">
                <div>
                    <p><strong>Felhasználónév:</strong> <?php echo htmlspecialchars($user['felhasznalonev']); ?></p>
                    <p><strong>Teljes név:</strong> <?php echo htmlspecialchars($user['teljesnev']); ?></p>
                    <p><strong>E-mail:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                </div>
            </div>
        </div>
        
        <!-- Korábbi rendelések megjelenítése -->
        <div class="orders">
            <h2>Korábbi rendeléseim</h2>
            <?php if ($resultOrders && $resultOrders->num_rows > 0): ?>
                <table>
                    <tr>
                        <th>Rendelési azonosító</th>
                        <th>Rendelés dátuma</th>
                        <th>Étel neve</th>
                        <th>Mennyiség</th>
                        <th>Státusz</th>
                    </tr>
                    <?php while ($order = $resultOrders->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                        <td><?php echo date("Y-m-d H:i", strtotime($order['rendeles_datuma'])); ?></td>
                        <td><?php echo htmlspecialchars($order['etel_nev']); ?></td>
                        <td><?php echo htmlspecialchars($order['mennyiseg']); ?></td>
                        <td><?php echo htmlspecialchars($order['statusz']); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </table>
            <?php else: ?>
                <p>Még nem adtál le rendelést.</p>
            <?php endif; ?>
        </div>
    </div>
    
    <?php $conn->close(); ?>
</body>
</html>
