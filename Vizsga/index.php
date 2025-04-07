<?php
// Kezdjük a munkamenet indításával (például bejelentkezéshez szükséges)
session_start();
include 'fejlec.php'; // A meglévő fejléc beillesztése
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <title>Máté Csárda</title>
    <style>
        body {
            font-family: 'Georgia', serif;
            background-color: #fdf5e6;
            color: #4b3832;
        }
        h1, h2, h3 {
            font-family: 'Garamond', serif;
            color: #8b0000;
        }
        .hero-section {
            background-color: #ffe4c4;
            padding: 40px;
            border: 2px solid #8b0000;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 40px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .contact-section, .opening-hours, .reservation-section {
            background-color: #fffaf0;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid #d2b48c;
            margin-bottom: 30px;
        }
        .contact-section ul, .opening-hours ul {
            list-style-type: square;
            padding-left: 20px;
        }
        .contact-section ul li, .opening-hours ul li {
            margin-bottom: 5px;
        }
        a {
            text-decoration: none;
            color: #8b0000;
        }
        a:hover {
            text-decoration: underline;
            color: #b22222;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <!-- Bemutatkozás -->
        <div id="bemutatkozas" class="hero-section">
            <h1>Üdvözöljük a Máté Csárdában!</h1>
            <p>
                A Máté Csárda a magyar gasztronómia hagyományait és ízeit őrzi. Házias ételekkel, barátságos környezetben
                várjuk kedves vendégeinket. Legyen szó családi ebédről, üzleti vacsoráról vagy baráti találkozóról, nálunk
                mindenki megtalálja a számítását!
            </p>
        </div>

        <!-- Elérhetőség -->
        <div id="elerhetoseg" class="contact-section">
            <h2>Elérhetőség</h2>
            <ul>
                <li><strong>E-mail:</strong> info@matecsarda.hu</li>
                <li><strong>Telefonszám:</strong> +36 30 123 4567</li>
                <li><strong>Helyszín:</strong> 1234 Budapest, Csárda utca 5.</li>
            </ul>
        </div>

        <!-- Nyitvatartás -->
        <div id="nyitvatartas" class="opening-hours">
            <h2>Nyitvatartás</h2>
            <ul>
                <li><strong>Hétfő - Péntek:</strong> 12:00 - 22:00</li>
                <li><strong>Szombat:</strong> 11:00 - 23:00</li>
                <li><strong>Vasárnap:</strong> 11:00 - 21:00</li>
            </ul>
        </div>

        <!-- Asztalfoglalás -->
        <div id="asztalfoglalas" class="reservation-section">
            <h2>Asztalfoglalás</h2>
            <p>Az asztalfoglaláshoz hívja telefonszámunkat:</p>
            <p><strong>+36 30 123 4567</strong></p>
        </div>
    </div>
</body>
</html>
