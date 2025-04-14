<?php
session_start();
include 'fejlec.php'; // Fejléc beillesztése
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Máté Csárda - Főoldal</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Leaflet.js CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #fdf5e6; /* Világos bézs háttér */
            color: #4b3621; /* Sötétbarna szöveg */
        }

        h1, h2 {
            color: #8b0000; /* Mély bordó címsorok */
        }

        .content-section {
            background-color: #fffaf0; /* Világos bézs doboz */
            border: 2px solid #deb887; /* Világos barna keret */
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            margin: 20px auto;
        }

        .content-section h2 {
            font-size: 1.8rem;
            margin-bottom: 15px;
        }

        .content-section p {
            text-align: justify;
        }

        .csarda-img {
            max-width: 70%; /* A kép szélessége a szülőelem 70%-ára korlátozva */
            height: auto; /* Az arányok megőrzése */
            margin: 0 auto; /* Középre igazítás */
        }

        #map {
            height: 300px; /* Térkép magassága */
            border: 2px solid #deb887; /* Világos barna keret */
            border-radius: 10px; /* Lekerekített sarkok */
        }
    </style>
</head>
<body>
    <!-- Fejléc -->
    <div class="header">
        <!-- Fejléc tartalma az include-ból érkezik -->
    </div>

    <!-- Tartalom szekciók -->
    <div id="bemutatkozas" class="content-section">
        <div class="row align-items-center">
            <!-- Bal oldali kép -->
            <div class="col-md-4 text-center">
                <img src="kepek/csarda.jpg" alt="Bemutatkozás kép 1" class="img-fluid rounded csarda-img">
            </div>

            <!-- Szöveg középen -->
            <div class="col-md-4">
                <h2 class="text-center">Bemutatkozás</h2>
                <p>A Máté Csárda a magyar gasztronómia hagyományait őrzi, és a legjobb alapanyagokból készült házias ételekkel várja vendégeit. 
                A csárda története több évtizedre nyúlik vissza, és célunk, hogy a tradicionális magyar ízeket megőrizzük. 
                Látogasson el hozzánk, és élvezze a családias légkört, amely minden vendégünket magával ragadja!</p>
            </div>

            <!-- Jobb oldali kép -->
            <div class="col-md-4 text-center">
                <img src="kepek/csarda2.jpg" alt="Bemutatkozás kép 2" class="img-fluid rounded csarda-img">
            </div>
        </div>
    </div>

    <div id="elerhetoseg" class="content-section">
        <h2 class="text-center">Elérhetőség</h2>
        <ul class="list-unstyled">
            <li><strong>E-mail:</strong> info@matecsarda.hu</li>
            <li><strong>Telefonszám:</strong> +36 30 123 4567</li>
            <li><strong>Helyszín:</strong> 1234 Budapest, Csárda utca 5.</li>
        </ul>
        <p>Keressen minket bizalommal, ha kérdése van, vagy szeretne asztalt foglalni. Mindig örömmel állunk rendelkezésére!</p>
        
        <!-- OpenStreetMap Térkép -->
        <div id="map"></div>
    </div>

    <div id="nyitvatartas" class="content-section">
        <h2 class="text-center">Nyitvatartás</h2>
        <ul class="list-unstyled">
            <li><strong>Hétfő - Péntek:</strong> 10:00 - 18:00</li>
            <li><strong>Szombat:</strong> 11:00 - 17:00</li>
            <li><strong>Vasárnap:</strong> Zárva tartunk</li>
        </ul>
        <p>Nyitvatartási időnk alatt bármikor szívesen látjuk Önt és családját. Foglaljon asztalt, hogy biztosan legyen helye nálunk!</p>
    </div>

    <div id="asztalfoglalas" class="content-section">
        <h2 class="text-center">Foglalás</h2>
        <p>Az asztalfoglaláshoz kérjük, hívja telefonszámunkat. 
        Munkatársaink segítenek Önnek, hogy a lehető legjobb élményben legyen része nálunk.</p>
        <p><strong>Telefonszám:</strong> +36 30 123 4567</p>
    </div>

    <!-- Leaflet.js JavaScript -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <script>
        // Térkép inicializálása
        const map = L.map('map').setView([47.497913, 19.040236], 15); // Budapest koordináták

        // OpenStreetMap csempe hozzáadása
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Marker hozzáadása a csárda helyére
        L.marker([47.497913, 19.040236]).addTo(map)
            .bindPopup('Máté Csárda<br>1234 Budapest, Csárda utca 5.')
            .openPopup();
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>