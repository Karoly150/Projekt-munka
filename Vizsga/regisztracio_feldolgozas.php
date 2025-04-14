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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $keresztnev = trim($_POST['keresztnev']);
    $vezeteknev = trim($_POST['vezeteknev']);
    $felhasznalonev = trim($_POST['felhasznalonev']);
    $email = trim($_POST['email']);
    $jelszo1 = $_POST['jelszo1'];
    $jelszo2 = $_POST['jelszo2'];


    // Ellenőrizzük, hogy a felhasználónév vagy az e-mail már létezik-e
    $ellenorzes_sql = "SELECT id FROM felhasznalok WHERE felhasznalonev = ? OR email = ?";
    $ellenorzes_stmt = $conn->prepare($ellenorzes_sql);
    $ellenorzes_stmt->bind_param("ss", $felhasznalonev, $email);
    $ellenorzes_stmt->execute();
    $ellenorzes_stmt->store_result();

    
    if ($ellenorzes_stmt->num_rows > 0) {
        $_SESSION['hiba'] = "A megadott felhasználónév vagy e-mail cím már létezik. Kérjük, válasszon másikat.";
        header("Location: regisztracio.html");
        exit;
    }

    $ellenorzes_stmt->close();

    // Jelszó titkosítása
    $titkositott_jelszo = password_hash($jelszo1, PASSWORD_DEFAULT);

    // Teljes név összeállítása
    $teljesnev = $vezeteknev . " " . $keresztnev;

    // Adatok mentése az adatbázisba
    $sql = "INSERT INTO felhasznalok (teljesnev, felhasznalonev, email, jelszo) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Hiba történt az SQL előkészítés során: " . $conn->error);
    }

    $stmt->bind_param("ssss", $teljesnev, $felhasznalonev, $email, $titkositott_jelszo);

    if ($stmt->execute()) {
        // Sikeres regisztráció esetén üzenet és gomb
        echo '
        <div style="text-align: center; margin-top: 50px; font-family: Arial, sans-serif;">
            <h2 style="color: green;">Sikeres regisztráció!</h2>
            <p>Köszönjük, hogy regisztrált. Most már bejelentkezhet a fiókjába.</p>
            <a href="bejelentkezes.php" style="text-decoration: none;">
                <button style="
                    background-color: #007bff; 
                    color: white; 
                    border: none; 
                    padding: 10px 20px; 
                    border-radius: 5px; 
                    cursor: pointer;
                    font-size: 16px;
                ">
                    Tovább a bejelentkezésre
                </button>
            </a>
        </div>';
        exit;
    } else {
        echo '<p class="text-danger">Hiba történt: ' . $stmt->error . '</p>';
    }

    $stmt->close();
}

$conn->close();
?>
