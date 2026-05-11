-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Maj 11, 2026 at 06:11 PM
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
(11, 'Diuna', 'Szlachetny ród Atrydów przybywa na pustynną planetę Arrakis.', NULL, 'img/m11.jpg', 'https://www.youtube.com/watch?v=8g18jFHCLXk'),
(12, 'Avatar', 'Jake Sully i Neytiri muszą opuścić swój dom i chronić rodzinę na Pandorze.', NULL, 'img/m12.jpg', 'https://www.youtube.com/watch?v=d9MyW72ELq0'),
(13, 'Spider-Man', 'Tożsamość Spider-Mana zostaje ujawniona. Peter prosi o pomoc Doktora Strangea.', NULL, 'img/m13.jpg', 'https://www.youtube.com/watch?v=rt-2cxAiPJk'),
(14, 'Deadpool', 'Były żołnierz zyskuje zdolność samouzdrawiania i wyrusza na łowy.', NULL, 'img/m14.jpg', 'https://www.youtube.com/watch?v=ONHBaC-pfsk'),
(15, 'Top Gun: Maverick', 'Maverick wraca, by wyszkolić nowe pokolenie pilotów do niebezpiecznej misji.', NULL, 'img/m15.jpg', 'https://www.youtube.com/watch?v=qSqVVswa420'),
(16, 'Wilk z Wall Street', 'Prawdziwa historia Jordana Belforta i jego imperium na Wall Street.', NULL, 'img/m16.jpg', 'https://www.youtube.com/watch?v=iszwuX1AK6A'),
(17, 'Harry Potter', 'Chłopiec dowiaduje się, że jest czarodziejem i trafia do Hogwartu.', NULL, 'img/m17.jpg', 'https://www.youtube.com/watch?v=VyHV0BRtdxo'),
(18, 'Gwiezdne wojny', 'Luke Skywalker łączy siły, by ocalić galaktykę przed Imperium.', NULL, 'img/m18.jpg', 'https://www.youtube.com/watch?v=vZ734NWnAHA'),
(19, 'Park Jurajski', 'Park rozrywki z dinozaurami wymyka się spod kontroli.', NULL, 'img/m19.jpg', 'https://www.youtube.com/watch?v=lc0UehYemQA'),
(20, 'Terminator 2', 'Cyborg chroni młodego Johna Connora przed potężniejszym modelem.', NULL, 'img/m20.jpg', 'https://www.youtube.com/watch?v=CRRlbK5w8AE'),
(21, 'Powrót do przyszłości', 'Nastolatek przenosi się w czasie do 1955 roku.', NULL, 'img/m21.jpg', 'https://www.youtube.com/watch?v=qvsgGtivCgs'),
(22, 'Avengers: Koniec gry', 'Superbohaterowie jednoczą siły, by cofnąć działania Thanosa.', NULL, 'img/m22.jpg', 'https://www.youtube.com/watch?v=TcMBFSGVi1c'),
(23, 'Joker', 'Ignorowany przez społeczeństwo komik powoli popada w obłęd.', NULL, 'img/m23.jpg', 'https://www.youtube.com/watch?v=zAGVQLHvwOY'),
(24, 'Mad Max', 'W postapokaliptycznym świecie kobieta buntuje się przeciwko tyranowi.', NULL, 'img/m24.jpg', 'https://www.youtube.com/watch?v=hEJnMQG9ev8');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
