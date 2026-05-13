-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Maj 13, 2026 at 08:31 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vod_platform_db`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `year` int(4) DEFAULT NULL,
  `image_url` varchar(500) DEFAULT NULL,
  `trailer_url` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`id`, `title`, `description`, `year`, `image_url`, `trailer_url`) VALUES
(1, 'Skazani na Shawshank', 'Dwóch uwięzionych mężczyzn zaprzyjaźnia się na przestrzeni lat, znajdując ukojenie i ostateczne odkupienie.', NULL, 'img/m1.jpg', 'https://www.youtube.com/watch?v=6hB3S9bIaco'),
(2, 'Ojciec chrzestny', 'Starzejący się patriarcha dynastii przestępczej przekazuje kontrolę nad swoim imperium niechętnemu synowi.', NULL, 'img/m2.jpg', 'https://www.youtube.com/watch?v=sY1S34973zA'),
(3, 'Mroczny Rycerz', 'Batman musi zmierzyć się z nowym przestępcą znanym jako Joker.', NULL, 'img/m3.jpg', 'https://www.youtube.com/watch?v=EXeTwQWrcwY'),
(4, 'Władca Pierścieni', 'Niezwykła drużyna wyrusza w podróż, by zniszczyć Jedyny Pierścień i pokonać Władcę Ciemności.', NULL, 'img/m4.jpg', 'https://www.youtube.com/watch?v=V75dMMIW2B4'),
(5, 'Pulp Fiction', 'Losy dwóch płatnych morderców, boksera i żony gangstera splotą się w brutalnej opowieści.', NULL, 'img/m5.jpg', 'https://www.youtube.com/watch?v=s7EdQ4FqbhY'),
(6, 'Forrest Gump', 'Historia życia mężczyzny o niskim IQ, który bierze udział w najważniejszych wydarzeniach XX wieku.', NULL, 'img/m6.jpg', 'https://www.youtube.com/watch?v=bLvqoHBptjg'),
(7, 'Incepcja', 'Złodziej wykrada sekrety z podświadomości podczas snu.', NULL, 'img/m7.jpg', 'https://www.youtube.com/watch?v=YoHD9XEInc0'),
(8, 'Matrix', 'Haker Neo dowiaduje się, że świat jest symulacją komputerową.', NULL, 'img/m8.jpg', 'https://www.youtube.com/watch?v=vKQi3bBA1y8'),
(9, 'Interstellar', 'Grupa astronautów wyrusza w podróż przez tunel czasoprzestrzenny.', NULL, 'img/m9.jpg', 'https://www.youtube.com/watch?v=zSWdZVtXT7E'),
(10, 'Gladiator', 'Rzymski generał zostaje zdradzony i zredukowany do roli gladiatora.', NULL, 'img/m10.jpg', 'https://www.youtube.com/watch?v=owK1qxDselE'),
(11, 'Diuna', 'Szlachetny ród Atrydów przybywa na pustynną planetę Arrakis.', NULL, 'img/m11.jpg', 'https://youtu.be/n9xhJrPXop4'),
(12, 'Avatar', 'Jake Sully i Neytiri muszą opuścić swój dom i chronić rodzinę na Pandorze.', NULL, 'img/m12.jpg', 'https://www.youtube.com/watch?v=d9MyW72ELq0'),
(13, 'Spider-Man', 'Tożsamość Spider-Mana zostaje ujawniona. Peter prosi o pomoc Doktora Strangea.', NULL, 'img/m13.jpg', 'https://www.youtube.com/watch?v=rt-2cxAiPJk'),
(14, 'Deadpool', 'Były żołnierz zyskuje zdolność samouzdrawiania i wyrusza na łowy.', NULL, 'img/m14.jpg', 'https://www.youtube.com/watch?v=ONHBaC-pfsk'),
(15, 'Top Gun: Maverick', 'Maverick wraca, by wyszkolić nowe pokolenie pilotów do niebezpiecznej misji.', NULL, 'img/m15.jpg', 'https://youtu.be/qSqVVswa420'),
(16, 'Wilk z Wall Street', 'Prawdziwa historia Jordana Belforta i jego imperium na Wall Street.', NULL, 'img/m16.jpg', 'https://www.youtube.com/watch?v=iszwuX1AK6A'),
(17, 'Harry Potter', 'Chłopiec dowiaduje się, że jest czarodziejem i trafia do Hogwartu.', NULL, 'img/m17.jpg', 'https://www.youtube.com/watch?v=VyHV0BRtdxo'),
(18, 'Gwiezdne wojny', 'Luke Skywalker łączy siły, by ocalić galaktykę przed Imperium.', NULL, 'img/m18.jpg', 'https://www.youtube.com/watch?v=vZ734NWnAHA'),
(19, 'Park Jurajski', 'Park rozrywki z dinozaurami wymyka się spod kontroli.', NULL, 'img/m19.jpg', 'https://youtu.be/QWBKEmWWL38'),
(20, 'Terminator 2', 'Cyborg chroni młodego Johna Connora przed potężniejszym modelem.', NULL, 'img/m20.jpg', 'https://www.youtube.com/watch?v=CRRlbK5w8AE'),
(21, 'Powrót do przyszłości', 'Nastolatek przenosi się w czasie do 1955 roku.', NULL, 'img/m21.jpg', 'https://www.youtube.com/watch?v=qvsgGtivCgs'),
(22, 'Avengers: Koniec gry', 'Superbohaterowie jednoczą siły, by cofnąć działania Thanosa.', NULL, 'img/m22.jpg', 'https://www.youtube.com/watch?v=TcMBFSGVi1c'),
(23, 'Joker', 'Ignorowany przez społeczeństwo komik powoli popada w obłęd.', NULL, 'img/m23.jpg', 'https://www.youtube.com/watch?v=zAGVQLHvwOY'),
(24, 'Mad Max', 'W postapokaliptycznym świecie kobieta buntuje się przeciwko tyranowi.', NULL, 'img/m24.jpg', 'https://www.youtube.com/watch?v=hEJnMQG9ev8'),
(25, 'Podziemny krąg', 'Dwóch mężczyzn zakłada tajny klub walki, który przeradza się w ogólnokrajową organizację.', NULL, 'img/m30.jpg', 'https://www.youtube.com/watch?v=qtRKdVHc-cE'),
(26, 'Siedem', 'Dwóch detektywów tropi seryjnego mordercę, który wybiera swoje ofiary na podstawie siedmiu grzechów głównych.', NULL, 'img/m31.jpg', 'https://www.youtube.com/watch?v=znmZoVkCjpI'),
(27, 'Zielona mila', 'Strażnicy więzienni odkrywają, że jeden ze skazańców skazanych na śmierć posiada nadprzyrodzone moce.', NULL, 'img/m32.jpg', 'https://www.youtube.com/watch?v=Ki4haFrqSrw'),
(28, 'Milczenie owiec', 'Młoda agentka FBI szuka pomocy u uwięzionego, genialnego mordercy-kanibala, by złapać innego seryjnego zabójcę.', NULL, 'img/m33.jpg', 'https://www.youtube.com/watch?v=W6Mm8Sbe__o'),
(29, 'Django', 'Oswobodzony niewolnik łączy siły z niemieckim łowcą nagród, by uratować swoją żonę z rąk brutalnego plantatora.', NULL, 'img/m34.jpg', 'https://youtu.be/2dY7Ad9YhEk'),
(30, 'Bękarty wojny', 'W okupowanej przez nazistów Francji grupa amerykańskich żołnierzy żydowskiego pochodzenia planuje zamach na przywódców III Rzeszy.', NULL, 'img/m35.jpg', 'https://www.youtube.com/watch?v=KnrRy6kSFF0'),
(31, 'Szeregowiec Ryan', 'Podczas lądowania w Normandii oddział żołnierzy wyrusza z misją odnalezienia i ocalenia spadochroniarza.', NULL, 'img/m36.jpg', 'https://www.youtube.com/watch?v=zwhP5b4tD6g'),
(32, 'Truman Show', 'Sprzedawca ubezpieczeń odkrywa, że całe jego życie jest w rzeczywistości telewizyjnym reality show.', NULL, 'img/m37.jpg', 'https://www.youtube.com/watch?v=dlnmQbPGuls'),
(33, 'John Wick', 'Emerytowany płatny morderca wraca do gry, by zemścić się na gangsterach, którzy zabili jego psa.', NULL, 'img/m38.jpg', 'https://www.youtube.com/watch?v=C0BMx-qxsP4'),
(34, 'Strażnicy Galaktyki', 'Zuchwały awanturnik kradnie tajemniczy artefakt i staje się celem potężnego złoczyńcy. Aby przetrwać, łączy siły z grupą kosmicznych wyrzutków.', NULL, 'img/m39.jpg', 'https://www.youtube.com/watch?v=d96cjJhvlMA'),
(35, 'Piraci z Karaibów: Klątwa Czarnej Perły', 'Kowal Will Turner łączy siły z ekscentrycznym piratem, Kapitanem Jackiem Sparrowem, aby uratować swoją ukochaną z rąk nieumarłej załogi.', NULL, 'img/m40.jpg', 'https://www.youtube.com/watch?v=naQr0uTrH_s'),
(36, 'Iron Man', 'Miliarder i genialny wynalazca zostaje porwany. Konstruuje zaawansowaną zbroję, by uciec i walczyć ze złem jako superbohater.', NULL, 'img/m41.jpg', 'https://youtu.be/KAE5ymVLmZg'),
(37, 'Wyspa tajemnic', 'Szeryf federalny bada zniknięcie pacjentki ze szpitala psychiatrycznego o zaostrzonym rygorze na odizolowanej wyspie.', NULL, 'img/m42.jpg', 'https://www.youtube.com/watch?v=5iaYLCiq5RM'),
(38, 'Złap mnie, jeśli potrafisz', 'Prawdziwa historia Franka Abagnale\'a, który przed 19. rokiem życia fałszował czeki na miliony dolarów, uciekając przed agentem FBI.', NULL, 'img/m43.jpg', 'https://www.youtube.com/watch?v=71rDQ7z4eFg'),
(39, 'Lśnienie', 'Pisarz podejmuje pracę stróża w opustoszałym hotelu, gdzie złowrogie siły doprowadzają go do obłędu, zagrażając jego rodzinie.', NULL, 'img/m44.jpg', 'https://www.youtube.com/watch?v=S014oGZiSdI'),
(40, 'Chłopcy z ferajny', 'Historia Henry\'ego Hilla i jego życia w mafii, obejmująca jego relacje z żoną Karen i partnerami przestępczymi w syndykacie.', NULL, 'img/m45.jpg', 'https://www.youtube.com/watch?v=2ilzidi_J8Q'),
(41, 'Whiplash', 'Młody i ambitny perkusista jazzowy trafia pod skrzydła bezwzględnego i wymagającego dyrygenta, który przesuwa jego granice wytrzymałości.', NULL, 'img/m46.jpg', 'https://www.youtube.com/watch?v=7d_jQycdQGo'),
(42, 'Terminator', 'Cyborg-morderca zostaje wysłany w przeszłość z roku 2029 do 1984, by zabić Sarę Connor, której nienarodzony syn uratuje ludzkość.', NULL, 'img/m47.jpg', 'https://www.youtube.com/watch?v=k64P4l2Wmeg'),
(43, 'Deadpool & Wolverine', 'Bezczelny najemnik Wade Wilson łączy siły z Wolverine\'em. Razem wyruszają w szaloną i krwawą podróż, aby ocalić swój świat.', NULL, 'img/m48.jpg', 'https://www.youtube.com/watch?v=73_1biulkYk');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
