-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2025. Ápr 07. 22:56
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
(2, 'admin', 'admin', 'admin@gmail.com');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `etelek`
--

CREATE TABLE `etelek` (
  `id` int(11) NOT NULL,
  `nev` varchar(255) NOT NULL,
  `leiras` text DEFAULT NULL,
  `kep` varchar(255) DEFAULT NULL,
  `ar` int(11) NOT NULL,
  `elkeszitheto` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `etelek`
--

INSERT INTO `etelek` (`id`, `nev`, `leiras`, `kep`, `ar`, `elkeszitheto`) VALUES
(1, 'Pörkölt', 'Hagyományos sertéspörkölt galuskával.', 'porkolt.jpg', 3000, 1),
(2, 'Marhapörkölt galuskával', 'Hagyományos magyar fogás, szaftos marhapörkölt puha galuskával.', 'marhaporkolt.jpg', 2500, 1),
(3, 'Csirkepaprikás galuskával', 'Szaftos csirkepaprikás galuska körettel.', 'csirkepaprikas.jpg', 2000, 1),
(4, 'Töltött káposzta', 'Savanyú káposzta, darált hús és füstölt kolbász.', 'toltottkaposzta.jpg', 2300, 1),
(5, 'Rántott csirkemell hasábburgonyával', 'Ropogós csirkemell aranybarnára sütve, friss hasábburgonyával.', 'rantottcsirkekrumplival.jpg', 1900, 1),
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
(28, 'Palinka', 'Saját készítésű szilva pálinka.', 'palinka.jpg', 600, 1);

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
(7, 'test1', '$2y$10$kp9gSCmih10cabkJq1HOEOa06/EzJyfWHpMM2xkIjvmHqbY1rI1Ki', 'test1@gmail.com', ''),
(11, 'László11', '$2y$10$/ld6W.QxDzrX.kqpd6kBue/mtjeDqA8wjPpwJ4rf4fWwBzR1tcQLO', 'laszlo@gmail.com', ''),
(13, 'adam1', '$2y$10$Zp3TBkfgq3TMqVEq4ggxSuaWgcNRgNA9LIPlhw8ovI5t4vwzT3fea', 'adam@gmail.com', 'Adam Kiss'),
(14, 'test', '$2y$10$q9DN5qsv9vEmpCX9BBlElOkemf5bZS75YkqD1V1uxJ1vFKdm1n9Sy', 'test11@gmail.com', 'Hova Vala');

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

--
-- A tábla adatainak kiíratása `kosar`
--

INSERT INTO `kosar` (`id`, `felhasznalo_id`, `etel_id`, `mennyiseg`) VALUES
(37, 14, 1, 2);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `rendelesek`
--

CREATE TABLE `rendelesek` (
  `id` int(11) NOT NULL,
  `felhasznalo_id` int(11) NOT NULL,
  `etel_id` int(11) NOT NULL,
  `mennyiseg` int(11) NOT NULL,
  `statusz` varchar(50) DEFAULT 'függőben'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `rendelesek`
--

INSERT INTO `rendelesek` (`id`, `felhasznalo_id`, `etel_id`, `mennyiseg`, `statusz`) VALUES
(49, 14, 1, 1, 'Elutasítva'),
(50, 14, 1, 1, 'Elutasítva'),
(51, 14, 1, 1, 'függőben'),
(52, 14, 1, 1, 'függőben'),
(53, 14, 1, 1, 'függőben'),
(54, 14, 1, 1, 'függőben');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT a táblához `felhasznalok`
--
ALTER TABLE `felhasznalok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT a táblához `kosar`
--
ALTER TABLE `kosar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT a táblához `rendelesek`
--
ALTER TABLE `rendelesek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

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
