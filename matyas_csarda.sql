-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2025. Ápr 24. 09:41
-- Kiszolgáló verziója: 10.4.32-MariaDB
-- PHP verzió: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `matyas_csarda`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `adminok`
--

CREATE TABLE `adminok` (
  `id` int(11) NOT NULL,
  `adminnev` varchar(255) NOT NULL,
  `jelszo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `adminok`
--

INSERT INTO `adminok` (`id`, `adminnev`, `jelszo`, `email`) VALUES
(2, 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'admin@gmail.com');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `etelek`
--

CREATE TABLE `etelek` (
  `id` int(11) NOT NULL,
  `nev` varchar(255) NOT NULL,
  `leiras` text NOT NULL,
  `kep` varchar(255) NOT NULL,
  `ar` int(11) NOT NULL,
  `elkeszitheto` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `etelek`
--

INSERT INTO `etelek` (`id`, `nev`, `leiras`, `kep`, `ar`, `elkeszitheto`) VALUES
(1, 'Pörkölt', 'Hagyományos sertéspörkölt galuskával.', 'porkolt.jpg', 3500, 0),
(2, 'Marhapörkölt galuskával', 'Hagyományos magyar fogás, szaftos marhapörkölt puha galuskával.', 'marhaporkolt.jpg', 3500, 1),
(3, 'Csirkepaprikás galuskával', 'Szaftos csirkepaprikás galuska körettel.', 'csirkepaprikas.jpg', 2300, 1),
(4, 'Töltött káposzta', 'Savanyú káposzta, darált hús és füstölt kolbász.', 'toltottkaposzta.jpg', 2300, 1),
(5, 'Rántott csirkemell hasábburgonyával', 'Ropogós csirkemell aranybarnára sütve, friss hasábburgonyával.', 'rantottcsirkekrumplival.jpg', 2900, 1),
(6, 'Bolognai spagetti', 'Olasz bolognai ragu frissen főtt spagettivel.', 'bolognaispagetti.jpg', 1800, 1),
(7, 'Milánói sertésborda', 'Friss sertésborda Milánói raguval és sajttal.', 'milanoisertesborda.jpg', 2200, 1),
(8, 'Gulyásleves', 'Hagyományos magyar gulyásleves, marhahússal és zöldségekkel.', 'gulyasleves.jpg', 1500, 1),
(9, 'Húsleves gazdagon', 'Tartalmas húsleves csirkehússal és zöldségekkel.', 'husleves.jpg', 1400, 1),
(10, 'Lecsó kolbásszal', 'Friss paprika és paradicsom kolbásszal, magyaros ízekkel.', 'kolbaszlecso.jpg', 1600, 1),
(11, 'Vegetáriánus rakott zöldségek', 'Ropogós rakott zöldségek sajtos szószban sütve.', 'rakottzoldseg.jpg', 1700, 1),
(12, 'Sült kacsacomb párolt káposztával', 'Szaftos kacsacomb lilakáposztával és burgonyával.', 'sultkacsacomb.jpg', 2800, 1),
(13, 'Harcsapaprikás túrós csuszával', 'Friss harcsapaprikás házi túrós csuszával.', 'harcsaturoscsusza.jpg', 3200, 1),
(14, 'Lazacfilé grillezett zöldségekkel', 'Lazacfilé párolt zöldségekkel és friss citrommal.', 'lazaczoldeggel.jpg', 3500, 1),
(15, 'Rántott sajt rizzsel és tartármártással', 'Omlós rántott sajt tartármártással és illatos rizzsel.', 'rantottsajttartar.jpg', 1600, 1),
(16, 'Pizza Margherita', 'Klasszikus olasz pizza paradicsomszósszal és sajttal.', 'margherita.jpg', 2400, 1),
(17, 'Pizza Prosciutto', 'Pizza sonkával, mozzarellával és paradicsomszósszal.', 'prosciutto.jpg', 2600, 1),
(18, 'Somlói galuska', 'Édes desszert csokoládéval és tejszínhabbal.', 'somloigaluska.jpg', 1200, 1),
(19, 'Palacsinta Nutellával', 'Friss palacsinta Nutellás töltelékkel.', 'nutellaspalacsinta.jpg', 900, 1),
(20, 'Tiramisu', 'Olasz tiramisu mascarponés krémmel.', 'tiramisu.jpg', 1300, 1),
(21, 'Krémtúró gyümölcsmártással', 'Könnyű túrókrém friss gyümölcsökkel.', 'kremturomartassal.jpg', 1100, 1),
(25, 'Mentes ásvanyvíz', 'Szénsavmentes ásványvíz.', 'mentesviz.jpg', 500, 1),
(26, 'Csapolt sör', 'Frissen csapolt saját hazai korsó sör.', 'sor.jpg', 800, 1),
(28, 'Pálinka', 'Saját készítésű szilva pálinka.', 'palinka.jpg', 600, 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalok`
--

CREATE TABLE `felhasznalok` (
  `id` int(11) NOT NULL,
  `felhasznalonev` varchar(255) NOT NULL,
  `jelszo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `teljesnev` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `felhasznalok`
--

INSERT INTO `felhasznalok` (`id`, `felhasznalonev`, `jelszo`, `email`, `teljesnev`) VALUES
(25, 'ErvinNagy', '$2y$10$Y5bssIZrevwJ3dBB050bJuaj7Hflilk80NUqKnBdvkTHMn1Q/u4fK', 'nagyervin@gmail.com', 'Nagy Ervin'),
(58, 'Máté', '$2y$10$Fh.I8JmUVWMIX1ThJy56teYpXpVx9og6qZWO4BAHf2Yig1bfmti72', 'mate@gmail.com', 'Máté Kiss');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `kosar`
--

CREATE TABLE `kosar` (
  `id` int(11) NOT NULL,
  `felhasznalo_id` int(11) NOT NULL,
  `etel_id` int(11) NOT NULL,
  `mennyiseg` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `rendelesek`
--

CREATE TABLE `rendelesek` (
  `id` int(11) NOT NULL,
  `felhasznalo_id` int(11) NOT NULL,
  `etel_id` int(11) NOT NULL,
  `mennyiseg` int(11) NOT NULL,
  `statusz` varchar(50) DEFAULT 'függőben',
  `rendeles_datuma` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `adminok`
--
ALTER TABLE `adminok`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `etelek`
--
ALTER TABLE `etelek`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `felhasznalok`
--
ALTER TABLE `felhasznalok`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `kosar`
--
ALTER TABLE `kosar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `felhasznalo_id` (`felhasznalo_id`),
  ADD KEY `etel_id` (`etel_id`);

--
-- A tábla indexei `rendelesek`
--
ALTER TABLE `rendelesek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `felhasznalo_id` (`felhasznalo_id`),
  ADD KEY `etel_id` (`etel_id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `adminok`
--
ALTER TABLE `adminok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `etelek`
--
ALTER TABLE `etelek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT a táblához `felhasznalok`
--
ALTER TABLE `felhasznalok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT a táblához `kosar`
--
ALTER TABLE `kosar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT a táblához `rendelesek`
--
ALTER TABLE `rendelesek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `kosar`
--
ALTER TABLE `kosar`
  ADD CONSTRAINT `kosar_ibfk_1` FOREIGN KEY (`felhasznalo_id`) REFERENCES `felhasznalok` (`id`),
  ADD CONSTRAINT `kosar_ibfk_2` FOREIGN KEY (`etel_id`) REFERENCES `etelek` (`id`);

--
-- Megkötések a táblához `rendelesek`
--
ALTER TABLE `rendelesek`
  ADD CONSTRAINT `rendelesek_ibfk_1` FOREIGN KEY (`felhasznalo_id`) REFERENCES `felhasznalok` (`id`),
  ADD CONSTRAINT `rendelesek_ibfk_2` FOREIGN KEY (`etel_id`) REFERENCES `etelek` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
