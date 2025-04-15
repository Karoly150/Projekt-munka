<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <title>Bejelentkezés</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('kepek/bejelentkezes.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #4b3621;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .header {
            position: absolute;
            top: 20px;
            text-align: center;
        }

        .header a {
            font-size: 2rem;
            font-weight: bold;
            color: #8b0000;
            text-decoration: none;
        }

        .header a:hover {
            text-decoration: underline;
        }

        .container {
            background-color: rgba(255, 250, 240, 0.9);
            border: 2px solid #deb887;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            padding: 30px;
            max-width: 500px;
            width: 100%;
        }

        h2 {
            color: #8b0000;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: bold;
            color: #4b3621;
        }

        .btn-primary {
            background-color: #8b4513;
            border: none;
        }

        .btn-primary:hover {
            background-color: #5a2d0c;
        }

        .alert {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Fejléc -->
    <div class="header">
        <a href="index.php">Mátyás Csárda</a>
    </div>

    <!-- Bejelentkezési űrlap -->
    <div class="container">
        <h2>Bejelentkezés</h2>
        <!-- Hibaüzenet megjelenítése -->
        <?php
        session_start();
        if (isset($_SESSION['hiba'])) {
            echo "<div class='alert alert-danger text-center'>" . htmlspecialchars($_SESSION['hiba']) . "</div>";
            unset($_SESSION['hiba']); // Hibaüzenet törlése a megjelenítés után
        }
        ?>
        <form action="bejelentkezes_ellenorzes.php" method="POST">
            <div class="mb-3">
                <label for="felhasznalonev" class="form-label">Felhasználónév</label>
                <input type="text" id="felhasznalonev" name="felhasznalonev" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="jelszo" class="form-label">Jelszó</label>
                <input type="password" id="jelszo" name="jelszo" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Bejelentkezés</button>
        </form>
        <div class="text-center mt-3">
            <a href="regisztracio.html">Még nincs fiókja? Regisztráljon itt.</a>
        </div>
    </div>
</body>
</html>