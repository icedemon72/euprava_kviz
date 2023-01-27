-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2023 at 12:12 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kviz`
--

-- --------------------------------------------------------

--
-- Table structure for table `achievements`
--

CREATE TABLE `achievements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `users_unlocked` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `achievements`
--

INSERT INTO `achievements` (`id`, `title`, `description`, `image`, `users_unlocked`) VALUES
(1, 'Zvezde Grandice I', 'Završi kviz 5 puta (sa barem 5 tačnih odgovora)', 'star_bronze.png', 0),
(2, 'Zvezde Grandice II', 'Završi kviz 10 puta (sa barem 5 tačnih odgovora)', 'star_silver.png', 0),
(3, 'Zvezde Grandice III', 'Završi kviz 15 puta (sa barem 5 tačnih odgovora)', 'star_gold.png', 0),
(4, 'Trofej Bradete Jarice I', 'Završi kviz sa barem 8 tačnih odgovora', 'trophy_bronze.png', 0),
(5, 'Trofej Bradete Jarice II', 'Završi kviz sa barem 9 tačnih odgovora', 'trophy_silver.png', 0),
(6, 'Trofej Bradete Jarice III', 'Završi kviz sa barem 10 tačnih odgovora', 'trophy_gold.png', 0),
(7, 'Konačno sam našao deo koji mi nedostaje', 'Dodaj opis', 'about_achievement.png', 0),
(8, 'It\'s OK let him play', 'Odigraj jednom', 'itsokay.png', 0),
(9, 'Nemoj ga rush-ati, samo mu ga daj malo po gasu', 'Završi kviz sa barem 7 tačnih odgovora za manje od jednog minuta', 'gas.jpg', 0),
(10, 'I meni je mene žao, zaplak\'o sam zamalo', 'Završi kviz bez tačnog odgovora', 'cry.jpg', 0),
(11, 'Kap koja je prelila čašu', 'Dodaj jedno pitanje', 'plus.png', 0),
(20, 'Vukov \"Riječnik\" I izdanje', 'Osvoji sva dostignućna', 'vuk.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `text` varchar(255) NOT NULL,
  `correct` bit(1) NOT NULL,
  `questions_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `text`, `correct`, `questions_id`) VALUES
(7, 'Trojan', b'0', 3),
(8, 'Creeper', b'1', 3),
(9, 'Rabbit', b'0', 3),
(10, 'MinerDoom', b'0', 3),
(11, 'Štetan program', b'1', 4),
(12, 'Program za kucanje', b'0', 4),
(13, 'Antivirus', b'0', 4),
(14, 'Program za igrice', b'0', 4),
(15, 'B < KB < GB < TB', b'1', 5),
(16, 'B < KB < TB < MB', b'0', 5),
(17, 'B < MB < GB < TB', b'1', 5),
(18, 'B < KB < MB', b'1', 5),
(19, 'Portable Document Format', b'1', 7),
(20, 'C', b'1', 8),
(21, 'Mac OS X', b'0', 8),
(22, 'Unix', b'0', 8),
(23, 'Linux', b'0', 8),
(24, 'Jednog bita', b'0', 9),
(25, 'Dva bita', b'0', 9),
(26, 'Tri bita', b'0', 9),
(27, 'Četiri bita', b'1', 9),
(28, 'Random Access Memory', b'1', 10),
(29, 'Random Output Memory', b'0', 11),
(30, 'Read Only Memory', b'1', 11),
(31, 'Ready Operative Machine', b'0', 11),
(32, 'Remove Or Mount', b'0', 11),
(33, 'Operaciju množenja', b'0', 12),
(34, 'Operand AND (I)', b'1', 12),
(35, 'Operand OR (ILI)', b'0', 12),
(36, 'Sve navedeno', b'0', 12),
(37, '0', b'0', 13),
(38, '1', b'1', 13),
(39, '2', b'1', 13),
(40, '3', b'0', 13),
(41, 'print', b'1', 14),
(42, 'C', b'1', 15),
(43, 'Computer Programming Unit', b'0', 16),
(44, 'Computer Processing Unit', b'0', 16),
(45, 'Central Processing Unit', b'1', 16),
(46, 'Central Programming Unit', b'0', 16),
(47, 'Matična ploča', b'1', 17),
(48, 'Grafička kartica', b'0', 17),
(49, 'Optički disk', b'0', 17),
(50, 'Mrežna kartica', b'0', 17),
(51, 'Object Oriented Programming', b'1', 18),
(52, 'Large Area Network', b'0', 19),
(53, 'Local Anti-Network', b'0', 19),
(54, 'Local Area Notebook', b'0', 19),
(55, 'Local Area Network', b'1', 19),
(56, 'Vrstu monitora', b'0', 20),
(57, 'Sve fizičke komponente računara', b'1', 20),
(58, 'Sekundarnu memoriju', b'0', 20),
(59, 'Ulazno-izlazne uredjaje', b'0', 20),
(60, '25.01.2023.', b'0', 21),
(61, '01.25.2023.', b'0', 21),
(62, '2023-25-01', b'0', 21),
(63, '2023-01-25', b'1', 21),
(64, 'Hypertext markup language', b'1', 22),
(65, '<code>niz[0]</code>', b'1', 23),
(66, '<code>niz[\'first\']</code>', b'0', 23),
(67, '<code>niz[1]</code>', b'0', 23),
(68, '<code>niz[1.]</code>', b'0', 23),
(69, 'Current line interface', b'0', 24),
(70, 'Common line interface', b'0', 24),
(71, 'Command line interface', b'1', 24),
(72, 'Command line internet', b'0', 24),
(73, 'Datoteka je kolekcija podataka koji se čuvaju na računaru ili drugim uredjajima', b'1', 25),
(74, 'Datoteka je kolekcija procesorskih komandi koji se čuvaju na računaru ili drugim uredjajima', b'0', 25),
(75, 'Datoteka je skup hardverskih i softverskih uredjaja', b'0', 25),
(76, 'Datoteka je sredstvo za čuvanje podataka', b'0', 25),
(77, 'Otvaranjem datoteke (fajla), otvara se kopija sa podacima', b'1', 26),
(78, 'Operativni sistem služi da instaliramo programe', b'0', 26),
(79, 'Na računaru (PC) može biti instaliran samo jedan operativni sistem', b'0', 26),
(80, 'Procesor je centralna jedinica koja procesuira informacije i kontroliše kompjuterske operacije', b'1', 26),
(81, 'Svaki programski jezik može se koristiti samo za jednu stvar', b'0', 27),
(82, 'Niz je struktura koja može da sadrži puno podataka', b'1', 27),
(83, 'Svaka naredba je potpuno ista u svakom programskom jeziku', b'0', 27),
(84, 'Programski jezik je kompjuterski jezik koji se koristi za kreiranje programa (softvera) ', b'1', 27),
(85, 'Integrated Development Enviorment', b'1', 28),
(86, 'Integrated Designing Enviorment', b'0', 28),
(87, 'Integrated Domain Enviorment', b'0', 28),
(88, 'Integrated Debugging Enviorment', b'0', 28),
(89, '1 (true)', b'1', 29),
(90, '0 (false)', b'0', 29),
(91, 'Domain Name System', b'1', 30),
(92, 'Simple Mail Transfer Protocol', b'1', 31),
(93, 'Hypertext Transfer Protocol', b'1', 32),
(94, 'HTTP', b'0', 33),
(95, 'HTTPS', b'1', 33),
(96, 'Graphic Processing Unit', b'1', 34),
(97, 'Graphic Programming Unit', b'0', 34),
(98, 'General Processing Unit', b'0', 34),
(99, 'General Programming Unit', b'0', 34),
(100, 'Radna površina', b'0', 35),
(101, 'Operativni sistem', b'1', 35),
(102, 'Programski paketi ', b'1', 35),
(103, 'Pristup internetu', b'0', 35),
(104, '6', b'0', 36),
(105, '8', b'0', 36),
(106, '10', b'1', 36),
(107, '12', b'0', 36),
(108, 'A, B, C, D, E i F', b'0', 37),
(109, 'A, B, C, D i E', b'1', 37),
(110, 'A, B, C i D', b'0', 37),
(111, 'A, B i C', b'0', 37),
(112, 'Virtual Private Network', b'1', 38),
(113, 'Simetrična', b'1', 39),
(114, 'Sinhrona', b'0', 39),
(115, 'Asimetrična', b'1', 39),
(116, 'Asinhrona', b'0', 39),
(117, 'Public Key Infrastructure', b'1', 40),
(118, 'XAMPP Server Status', b'0', 41),
(119, 'XAMPP Server Service', b'0', 41),
(120, 'Cross-Site Scripting', b'1', 41),
(121, 'Cross-Site Status', b'0', 41),
(122, 'Python', b'0', 42),
(123, 'Javascript', b'1', 42),
(124, 'Lua', b'0', 42),
(125, 'Java', b'0', 42),
(126, 'Trojanci', b'1', 43),
(127, 'Crvi', b'1', 43),
(128, 'DDoS napadi', b'0', 43),
(129, 'Fišing napadi', b'0', 43),
(130, 'Za promovisanje usluga', b'0', 44),
(131, 'Za učestvovanje u razvoju web tehnologija', b'0', 44),
(132, 'Za registraciju korisnika', b'1', 44),
(133, 'Za upravljanje procedurama opozivanja i obezbedjivanja statusa sertifikata', b'1', 44),
(134, 'Document Object Model', b'1', 45),
(135, '<code>console.log(\'hello\');</code>', b'1', 46),
(136, '<code>Console.Write(\'hello\');</code>', b'0', 46),
(137, '<code>System.out.print(\'hello\');</code>', b'0', 46),
(138, '<code>std::cout << \'hello\';</code>', b'0', 46),
(139, 'Java', b'0', 47),
(140, 'C#', b'0', 47),
(141, 'Lua', b'1', 47),
(142, 'Go', b'0', 47),
(143, '<code>.cpp</code> (C++)', b'1', 48),
(144, '<code>.js</code> (Javascript)', b'1', 48),
(145, '<code>.py</code> (Python)', b'1', 48),
(146, '<code>.jv</code> (Java)', b'0', 48),
(147, 'Pikselski', b'0', 49),
(148, 'Rasterski', b'1', 49),
(149, 'Vektorski', b'0', 49),
(150, 'Ništa od navedenog', b'0', 49),
(151, '#', b'1', 50),
(152, '//', b'0', 50),
(153, '/* */', b'0', 50),
(154, '~', b'0', 50),
(155, '<code>id:idPrimer</code>', b'0', 51),
(156, '<code>!idPrimer</code>', b'0', 51),
(157, '<code>.idPrimer</code>', b'0', 51),
(158, '<code>#idPrimer</code>', b'1', 51),
(159, '<code>class:klasa_primer</code>', b'0', 52),
(160, '<code>!klasa_primer</code>', b'0', 52),
(161, '<code>.klasa_primer</code>', b'0', 52),
(162, '<code>#klasa_primer</code>', b'1', 52),
(163, 'Stack', b'1', 53),
(164, 'List', b'0', 53),
(165, 'Queue', b'0', 53),
(166, 'UDP', b'0', 54),
(167, 'Peer-to-Peer (P2P)', b'1', 54),
(168, 'HTTP', b'0', 54),
(169, 'SMTP', b'0', 54),
(170, '10', b'1', 55),
(171, 'Framework je struktura na kojoj se pravi softver', b'1', 56),
(172, 'Framework se obično asocira na mnogo programskih jezika', b'0', 56),
(173, 'Korišćenjem framework-a gubi se na sigurnosti', b'0', 56),
(174, 'Korišćenjem framework-a kod postaje čitkiji', b'1', 56),
(175, 'MN', b'0', 57),
(176, 'nM/s', b'0', 57),
(177, 'GHz', b'1', 57),
(178, 'Hz', b'0', 57),
(179, 'Basic Input-Output System', b'1', 58),
(180, 'Hard disk', b'0', 59),
(181, 'RAM i ROM', b'0', 59),
(182, 'ROM', b'0', 59),
(183, 'RAM', b'1', 59),
(184, 'Prevodjenje teksta u lokalni jezik', b'0', 60),
(185, 'Prevodjenje programa u mašinski kod', b'1', 60),
(186, 'Prevodjenje mašinskog koda u programski', b'0', 60),
(187, 'Prevodjenje vektorske u rastersku grafiku', b'0', 60),
(188, 'Masovni mediji', b'0', 61),
(189, 'Skup mrežnih servisa', b'0', 61),
(190, 'Lokacija web-stranice', b'0', 61),
(191, 'Ništa od navedenog', b'1', 61),
(192, 'Sliku', b'0', 62),
(193, 'Video', b'0', 62),
(194, 'Zvuk', b'1', 62),
(195, 'Tekst', b'0', 62),
(196, 'System Query Language', b'0', 63),
(197, 'Syntax Quality Language', b'0', 63),
(198, 'Structured Query Language', b'1', 63),
(199, 'Sound Quality Listening', b'0', 63);

-- --------------------------------------------------------

--
-- Table structure for table `answers_existing_requests`
--

CREATE TABLE `answers_existing_requests` (
  `id` int(11) NOT NULL,
  `text` varchar(255) DEFAULT NULL,
  `correct` bit(1) DEFAULT NULL,
  `questions_existing_requests_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `answers_existing_requests`
--

INSERT INTO `answers_existing_requests` (`id`, `text`, `correct`, `questions_existing_requests_id`) VALUES
(1, 'x', b'1', 1),
(2, 'd', b'0', 1),
(3, 'f', b'0', 1),
(4, 'g', b'0', 1),
(5, 'x', b'1', 2),
(6, 'd', b'0', 2),
(7, 'f', b'0', 2),
(8, 'g', b'0', 2),
(9, 'asdasd', b'1', 3),
(10, 'asdasd', b'0', 3),
(11, 'asdasd', b'0', 3),
(12, 'asdasda', b'0', 3),
(13, 'asdasd', b'1', 4),
(14, 'dasdasd', b'0', 4),
(15, 'sdasda', b'0', 4),
(16, 'sdaasdasd', b'0', 4),
(17, 'asdasdasdasdas', b'1', 5);

-- --------------------------------------------------------

--
-- Table structure for table `answers_not_existing_requests`
--

CREATE TABLE `answers_not_existing_requests` (
  `id` int(11) NOT NULL,
  `text` varchar(255) DEFAULT NULL,
  `correct` bit(1) DEFAULT NULL,
  `questions_not_existing_requests_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `answers_not_existing_requests`
--

INSERT INTO `answers_not_existing_requests` (`id`, `text`, `correct`, `questions_not_existing_requests_id`) VALUES
(1, '4', b'1', 1),
(2, '5', b'0', 1),
(3, '6', b'0', 1),
(4, '7', b'0', 1);

-- --------------------------------------------------------

--
-- Table structure for table `is_admin`
--

CREATE TABLE `is_admin` (
  `id` int(11) NOT NULL,
  `users_id` int(11) DEFAULT NULL,
  `date_assigned` datetime DEFAULT current_timestamp(),
  `date_resigned` datetime DEFAULT NULL,
  `questions_approved` int(11) DEFAULT 0,
  `categories_added` int(11) DEFAULT 0,
  `status` bit(1) DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `is_admin`
--

INSERT INTO `is_admin` (`id`, `users_id`, `date_assigned`, `date_resigned`, `questions_approved`, `categories_added`, `status`) VALUES
(1, 1, '2023-01-12 13:26:16', NULL, 0, 0, b'1'),
(2, 6, '2023-01-23 15:10:52', '2023-01-23 15:19:38', 0, 0, b'0'),
(3, 5, '2023-01-23 15:11:11', '2023-01-23 15:20:26', 0, 0, b'0'),
(4, 4, '2023-01-23 15:11:49', '2023-01-23 15:18:33', 0, 0, b'0'),
(5, 4, '2023-01-23 15:18:19', '2023-01-23 15:19:07', 0, 0, b'0'),
(7, 2, '2023-01-23 15:20:33', NULL, 0, 0, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `text` varchar(256) NOT NULL,
  `type` varchar(5) NOT NULL,
  `quiz_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `text`, `type`, `quiz_type_id`) VALUES
(3, 'Kako se zvao prvi kompjuterski virus?', 'radio', 1),
(4, 'Šta je \'malware\'?', 'radio', 1),
(5, 'Šta je od navedenog tačno?', 'chbox', 1),
(7, 'Dopuni značenje skraćenice PDF', 'input', 1),
(8, 'Šta od navedenog nije operativni sistem?', 'radio', 1),
(9, 'Kompjuterska memorija je podeljena i adresirana kao ćelije veličine od?', 'radio', 1),
(10, 'Šta znači RAM?', 'input', 1),
(11, 'Šta znači ROM?', 'radio', 1),
(12, 'U većini programskih jezika šta predstavlja && znak?', 'radio', 1),
(13, 'U sledećem kodu (u programskom jeziku C) šta će sve biti ispisano?\r\n    <code>for(int i = 1; i < 3; i++) {\r\n		printf(\'%d\n\', i);\r\n	}</code>\r\n     ', 'chbox', 1),
(14, 'Dopuni sledeći kod (u programskom jeziku Python) da bi izvršio ispis broja 5 na ekranu:', 'input', 1),
(15, 'Kojim slovom se najčešće označava primarna particija hard diska na personalnim računarima?', 'input', 1),
(16, 'Šta znači CPU?', 'radio', 1),
(17, 'Koji deo računara sadrži CPU, RAM i konektore za spoljašnje uredjaje?', 'radio', 1),
(18, 'Šta znači OOP?', 'input', 1),
(19, 'Šta znači skraćenica LAN?', 'radio', 1),
(20, 'Termin hardver predstavlja?', 'radio', 1),
(21, 'Koji je, po ISO standardu, tačan prikaz datuma?', 'radio', 1),
(22, 'Šta označava HTML?', 'input', 1),
(23, 'Kako, u većini programskih jezika, pristupa prvom elementu niza? ', 'radio', 1),
(24, 'CLI predstavlja?', 'radio', 1),
(25, 'Šta je datoteka (fajl)?', 'radio', 1),
(26, 'Izaberite tačne tvrdnje:', 'chbox', 1),
(27, 'Izaberite tačne tvrdnje:', 'chbox', 1),
(28, 'Šta je IDE?', 'radio', 1),
(29, 'Šta kao rezultat daje sledeći kod (u C++): <code>(true && !false) && !(!true)</code>?', 'radio', 1),
(30, 'Šta znači DNS? ', 'input', 1),
(31, 'Šta znači SMTP?', 'input', 1),
(32, 'Šta znači HTTP?', 'input', 1),
(33, 'Koji protokol je sigurniji?', 'radio', 1),
(34, 'Šta znači GPU?', 'radio', 1),
(35, 'Softver predstavlja programske celine koje se sastoje iz dva dela i to:', 'chbox', 1),
(36, 'U decimalnom brojnom sistemu, binarno 1010 je?', 'radio', 1),
(37, 'Koje klase postoje u klasnom sistemu subnet maski?', 'radio', 1),
(38, 'Šta je VPN?', 'input', 1),
(39, 'Koji od ponudjenih pojmova su dva osnovna tipa kriptografije?', 'chbox', 1),
(40, 'Šta je PKI?', 'input', 1),
(41, 'Na šta se odnosi pojam XSS?', 'radio', 1),
(42, 'Koji jezik se, najčešće, koristi prilikom XSS?', 'radio', 1),
(43, 'Šta je od navedenog svrstano u \'malware\'?', 'chbox', 1),
(44, 'Za šta je, od navedenog, zaduženo sertifikaciono telo?', 'chbox', 1),
(45, 'Šta, u web programiranju, predstavlja izraz DOM?', 'input', 1),
(46, 'Koji od navedenih komandi je za ispis teksta \'hello\' u javascript-u?', 'radio', 1),
(47, 'Ako nizovi počinju od 1, mi radimo u kom od navedenih jezika?', 'radio', 1),
(48, 'Koji od sledećih jezika ima tačno navedene ekstenzije datoteka?', 'chbox', 1),
(49, 'Programi za obradu slika koji rade na principu piksela zovu se?', 'radio', 1),
(50, 'U programskom jeziku Python komentare označavamo sa?', 'radio', 1),
(51, 'Kako se u CSS-u pristupa nekom elementu sa id-em <code>idPrimer</code>?', 'radio', 1),
(52, 'Kako se u CSS-u pristupa nekom elementu sa klasom <code>klasa_primer</code>?', 'radio', 1),
(53, 'Ako koristimo operacije PUSH i POP mi imamo veze sa kojim tipom podataka?', 'radio', 1),
(54, 'Koji protokol se koristi prilikom \'torrent-ovanja\'?', 'radio', 1),
(55, 'Koliko je x na kraju ovog koda u javascript-u?\r\n     <code>\r\n     let x = 5;\r\n     if(x % 2 == 0) {\r\n     x += 10;\r\n     } else {\r\n     x *= 2;\r\n     }\r\n     </code>', 'input', 1),
(56, 'Šta je od sledećih tačno?', 'chbox', 1),
(57, 'Kojom jedinicom se izražava radni takt procesora?', 'radio', 1),
(58, 'Šta znači skraćenica BIOS?', 'input', 1),
(59, 'Memorija koja gubi podatke pri isključenju računara je?', 'radio', 1),
(60, 'Čemu služe programski prevodioci?', 'radio', 1),
(61, 'Šta je multimedija?', 'radio', 1),
(62, 'Šta sadrži \'.mp3\' datoteka?', 'radio', 1),
(63, 'Šta znači SQL?', 'radio', 1);

-- --------------------------------------------------------

--
-- Table structure for table `questions_existing_requests`
--

CREATE TABLE `questions_existing_requests` (
  `id` int(11) NOT NULL,
  `text` varchar(255) DEFAULT NULL,
  `type` varchar(5) DEFAULT NULL,
  `quiz_type_id` int(11) DEFAULT NULL,
  `added_status` bit(1) DEFAULT b'0',
  `deleted` bit(1) NOT NULL DEFAULT b'0',
  `date_added` date DEFAULT NULL,
  `date_approved` date DEFAULT NULL,
  `users_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `questions_existing_requests`
--

INSERT INTO `questions_existing_requests` (`id`, `text`, `type`, `quiz_type_id`, `added_status`, `deleted`, `date_added`, `date_approved`, `users_id`) VALUES
(1, 'Hello', 'radio', 1, b'0', b'0', '2023-01-18', NULL, 1),
(2, 'Hello', 'radio', 1, b'0', b'0', '2023-01-18', NULL, 1),
(3, 'Asdasdas', 'radio', 1, b'0', b'0', '2023-01-18', NULL, 1),
(4, 'Asdasdasd', 'radio', 1, b'0', b'0', '2023-01-18', NULL, 1),
(5, 'Asdasdasdas', 'input', 1, b'0', b'0', '2023-01-18', NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `questions_not_existing_requests`
--

CREATE TABLE `questions_not_existing_requests` (
  `id` int(11) NOT NULL,
  `text` varchar(255) DEFAULT NULL,
  `type` varchar(5) DEFAULT NULL,
  `quiz_type_requests_id` int(11) DEFAULT NULL,
  `added_status` bit(1) DEFAULT b'1',
  `deleted` bit(1) NOT NULL DEFAULT b'0',
  `date_added` date DEFAULT NULL,
  `date_approved` date DEFAULT NULL,
  `users_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `questions_not_existing_requests`
--

INSERT INTO `questions_not_existing_requests` (`id`, `text`, `type`, `quiz_type_requests_id`, `added_status`, `deleted`, `date_added`, `date_approved`, `users_id`) VALUES
(1, 'Koliko je 2+2?', 'radio', 6, b'1', b'0', '2023-01-18', NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_playing`
--

CREATE TABLE `quiz_playing` (
  `id` int(11) NOT NULL,
  `time_started` datetime DEFAULT NULL,
  `time_finished` datetime DEFAULT NULL,
  `score` decimal(10,2) DEFAULT NULL,
  `quiz_type_id` int(11) DEFAULT NULL,
  `users_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz_playing`
--

INSERT INTO `quiz_playing` (`id`, `time_started`, `time_finished`, `score`, `quiz_type_id`, `users_id`) VALUES
(2, '2023-01-21 15:22:17', '2023-01-21 15:23:23', '1.00', 1, 1),
(3, '2023-01-21 15:24:22', '2023-01-21 15:24:44', '8.00', 1, 1),
(5, '2023-01-21 15:33:58', '2023-01-21 15:33:59', '0.00', 1, 1),
(7, '2023-01-21 15:34:17', '2023-01-21 15:34:18', '0.00', 1, 1),
(8, '2023-01-21 15:34:20', '2023-01-21 15:34:22', '0.00', 1, 1),
(9, '2023-01-21 15:34:24', '2023-01-21 15:34:28', '0.00', 1, 1),
(10, '2023-01-21 15:34:51', '2023-01-21 15:34:56', '1.00', 1, 1),
(11, '2023-01-21 15:45:30', '2023-01-21 15:45:53', '9.00', 1, 1),
(12, '2023-01-21 15:47:57', '2023-01-21 15:48:33', '10.00', 1, 1),
(14, '2023-01-21 15:48:50', '2023-01-21 15:49:17', '10.00', 1, 1),
(15, '2023-01-21 15:49:19', '2023-01-21 15:49:47', '9.00', 1, 1),
(17, '2023-01-21 16:35:31', '2023-01-21 16:35:51', '9.00', 1, 1),
(18, '2023-01-21 16:48:51', '2023-01-21 16:49:17', '5.00', 1, 2),
(20, '2023-01-21 16:51:04', '2023-01-21 16:51:30', '9.00', 1, 2),
(22, '2023-01-21 17:02:13', '2023-01-21 17:02:19', '0.00', 1, 2),
(23, '2023-01-22 14:19:00', '2023-01-22 14:19:22', '8.00', 1, 1),
(24, '2023-01-22 14:21:09', '2023-01-22 14:21:29', '8.00', 1, 1),
(26, '2023-01-22 16:11:01', '2023-01-22 16:11:22', '5.00', 1, 1),
(31, '2023-01-22 19:30:26', '2023-01-22 19:30:52', '8.00', 1, 1),
(32, '2023-01-22 19:31:06', '2023-01-22 19:31:35', '10.00', 1, 1),
(33, '2023-01-22 19:32:55', '2023-01-22 19:33:17', '10.00', 1, 1),
(34, '2023-01-22 19:33:20', '2023-01-22 19:33:43', '10.00', 1, 1),
(35, '2023-01-22 19:55:09', '2023-01-22 19:55:29', '9.00', 1, 1),
(36, '2023-01-22 19:56:00', '2023-01-22 19:56:29', '9.00', 1, 1),
(37, '2023-01-22 22:34:32', '2023-01-22 22:34:54', '9.00', 1, 2),
(38, '2023-01-22 22:35:52', '2023-01-22 22:36:09', '8.00', 1, 2),
(39, '2023-01-23 00:18:34', '2023-01-23 00:18:56', '8.00', 1, 1),
(40, '2023-01-25 08:53:24', '2023-01-25 08:53:59', '6.00', 1, 11);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_type`
--

CREATE TABLE `quiz_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `times_played` int(11) NOT NULL DEFAULT 0,
  `score` decimal(10,2) NOT NULL DEFAULT 0.00,
  `image` varchar(255) NOT NULL DEFAULT 'reg_quiz.jpg',
  `active` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz_type`
--

INSERT INTO `quiz_type` (`id`, `name`, `times_played`, `score`, `image`, `active`) VALUES
(1, 'Informatika', 0, '0.00', 'categories/informatics.jpg', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_type_requests`
--

CREATE TABLE `quiz_type_requests` (
  `id` int(11) NOT NULL,
  `name` varchar(32) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `users_id` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_accessed` datetime DEFAULT NULL,
  `active` bit(1) DEFAULT b'1',
  `is_admin_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz_type_requests`
--

INSERT INTO `quiz_type_requests` (`id`, `name`, `description`, `users_id`, `date_created`, `date_accessed`, `active`, `is_admin_id`) VALUES
(3, 'hellothere', '1234', 1, '2023-01-14 18:34:07', '2023-01-24 15:06:25', b'0', 1),
(4, 'xd', 'sdadas', 1, '2023-01-14 18:35:55', NULL, b'1', NULL),
(5, 'test 1', 'bla bla', 1, '2023-01-17 21:38:42', NULL, b'1', NULL),
(6, 'Matematika', 'Kviz o matematici, formule, zadaci itd.', 1, '2023-01-18 00:01:36', NULL, b'1', NULL),
(7, 'Fizika', '-', 2, '2023-01-18 00:45:15', NULL, b'1', NULL),
(8, 'Test123', 'RaxD23131sd', 1, '2023-01-24 14:36:29', NULL, b'1', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `registration_date` date NOT NULL,
  `last_log_in` date NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `first_name`, `last_name`, `date_of_birth`, `registration_date`, `last_log_in`, `description`) VALUES
(1, 'ice@gmail.com', 'ice', 'e10adc3949ba59abbe56e057f20f883e', 'Jovan', 'Isailovic', '2001-10-03', '2023-01-10', '2023-01-27', ''),
(2, 'filip@gmail.com', 'filip', '99316929f57da4b64bf99b8f5d9e4b19', 'Filip', 'Radivojevic', '2001-03-12', '2023-01-11', '2023-01-23', NULL),
(3, '123@gmail.com', '123456789012345678906749312879341879341879178914278142879412879412', '4297f44b13955235245b2497399d7a93', 'sdasdasd', 'dasasd', '2020-10-10', '2023-01-11', '2023-01-11', NULL),
(4, 'cone@gmail.com', 'cone', 'ca72bf6284df79b19df339d0f45b9eb7', 'Nemanja', 'Lazarevic', '2001-07-25', '2023-01-12', '2023-01-12', NULL),
(5, '1234@gmail.com', '123', 'e10adc3949ba59abbe56e057f20f883e', 'XYZ', 'YXZ', '2010-10-05', '2023-01-12', '2023-01-12', 'IMAM OPIS!!!'),
(6, 'test1@gmail.com', 'test', 'cc03e747a6afbbcbf8be7668acfebee5', 'test', 'test', '2022-12-13', '2023-01-23', '2023-01-23', NULL),
(7, 'test11@yahoo.com', 'test11', 'cc03e747a6afbbcbf8be7668acfebee5', 'testo', 'testo', '1999-03-11', '2023-01-23', '2023-01-23', NULL),
(8, 'filler@yahoo.com', 'filler', '298b45837188706b7c3c9ff4ae374edc', 'Filler', 'Fill', '2000-03-03', '2023-01-23', '2023-01-23', NULL),
(9, 'lol@gmail.com', 'lolol', '9f2788a951100afe63326ea54ce835ce', 'x', 'sda', '2000-03-12', '2023-01-23', '2023-01-23', NULL),
(10, 'testiranje@test.com', 'testiranje_', '05a671c66aefea124cc08b76ea6d30bb', 'Test', 'Test', '2000-05-10', '2023-01-23', '2023-01-23', NULL),
(11, 'tester@gmail.com', 'tester', 'e10adc3949ba59abbe56e057f20f883e', 'Test', 'Test', '2023-01-24', '2023-01-25', '2023-01-25', 'test opis');

-- --------------------------------------------------------

--
-- Table structure for table `user_has_achievement`
--

CREATE TABLE `user_has_achievement` (
  `id` int(11) NOT NULL,
  `users_id` int(11) DEFAULT NULL,
  `achievements_id` int(11) DEFAULT NULL,
  `status` bit(1) DEFAULT b'0',
  `date_unlocked` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_has_achievement`
--

INSERT INTO `user_has_achievement` (`id`, `users_id`, `achievements_id`, `status`, `date_unlocked`) VALUES
(1, 1, 1, b'1', '2023-01-12 13:48:00'),
(2, 1, 10, b'1', '2023-01-13 02:10:00'),
(5, 1, 11, b'1', '2023-01-18 00:43:10'),
(6, 2, 11, b'1', '2023-01-18 00:44:27'),
(7, 1, 7, b'1', '2023-01-18 00:50:31'),
(8, 1, 4, b'1', '2023-01-21 15:45:53'),
(9, 1, 5, b'1', '2023-01-21 15:45:53'),
(10, 1, 8, b'1', '2023-01-21 15:45:53'),
(11, 1, 9, b'1', '2023-01-21 15:45:53'),
(12, 1, 6, b'1', '2023-01-21 15:48:33'),
(13, 2, 8, b'1', '2023-01-21 16:49:17'),
(14, 2, 4, b'1', '2023-01-21 16:51:30'),
(15, 2, 5, b'1', '2023-01-21 16:51:30'),
(16, 2, 9, b'1', '2023-01-21 16:51:30'),
(17, 2, 10, b'1', '2023-01-21 17:02:19'),
(18, 1, 2, b'1', '2023-01-22 19:30:52'),
(19, 1, 3, b'1', '2023-01-22 19:56:29'),
(20, 1, 20, b'1', '2023-01-22 19:56:29'),
(21, 11, 7, b'1', '2023-01-25 08:52:34'),
(22, 11, 8, b'1', '2023-01-25 08:53:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `achievements`
--
ALTER TABLE `achievements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_answers_questions` (`questions_id`) USING BTREE;

--
-- Indexes for table `answers_existing_requests`
--
ALTER TABLE `answers_existing_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_answers_existing_requests_questions_existing` (`questions_existing_requests_id`);

--
-- Indexes for table `answers_not_existing_requests`
--
ALTER TABLE `answers_not_existing_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_answers_not_existing_requests_questions_not_existing_requests` (`questions_not_existing_requests_id`);

--
-- Indexes for table `is_admin`
--
ALTER TABLE `is_admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_is_admin_users` (`users_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_questions_quiz_type` (`quiz_type_id`);

--
-- Indexes for table `questions_existing_requests`
--
ALTER TABLE `questions_existing_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_questions_existing_requests_quiz_type` (`quiz_type_id`),
  ADD KEY `FK_questions_existing_requests_users` (`users_id`);

--
-- Indexes for table `questions_not_existing_requests`
--
ALTER TABLE `questions_not_existing_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_questions_not_existing_requests_quiz_type_requests` (`quiz_type_requests_id`),
  ADD KEY `FK_questions_not_existing_requests_users` (`users_id`);

--
-- Indexes for table `quiz_playing`
--
ALTER TABLE `quiz_playing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_quiz_playing_quiz_type` (`quiz_type_id`),
  ADD KEY `FK_quiz_playing_users` (`users_id`);

--
-- Indexes for table `quiz_type`
--
ALTER TABLE `quiz_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_type_requests`
--
ALTER TABLE `quiz_type_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_quiz_type_requests_users` (`users_id`),
  ADD KEY `FK_quiz_type_requests_is_admin` (`is_admin_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_has_achievement`
--
ALTER TABLE `user_has_achievement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_users_has_achievement_users` (`users_id`),
  ADD KEY `FK_users_has_achievement_achievements` (`achievements_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `achievements`
--
ALTER TABLE `achievements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

--
-- AUTO_INCREMENT for table `answers_existing_requests`
--
ALTER TABLE `answers_existing_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `answers_not_existing_requests`
--
ALTER TABLE `answers_not_existing_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `is_admin`
--
ALTER TABLE `is_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `questions_existing_requests`
--
ALTER TABLE `questions_existing_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `questions_not_existing_requests`
--
ALTER TABLE `questions_not_existing_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `quiz_playing`
--
ALTER TABLE `quiz_playing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `quiz_type`
--
ALTER TABLE `quiz_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `quiz_type_requests`
--
ALTER TABLE `quiz_type_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_has_achievement`
--
ALTER TABLE `user_has_achievement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `FK_odgovori_pitanja` FOREIGN KEY (`questions_id`) REFERENCES `questions` (`id`);

--
-- Constraints for table `answers_existing_requests`
--
ALTER TABLE `answers_existing_requests`
  ADD CONSTRAINT `FK_answers_existing_requests_questions_existing` FOREIGN KEY (`questions_existing_requests_id`) REFERENCES `questions_existing_requests` (`id`);

--
-- Constraints for table `answers_not_existing_requests`
--
ALTER TABLE `answers_not_existing_requests`
  ADD CONSTRAINT `FK_answers_not_existing_requests_questions_not_existing_requests` FOREIGN KEY (`questions_not_existing_requests_id`) REFERENCES `questions_not_existing_requests` (`id`);

--
-- Constraints for table `is_admin`
--
ALTER TABLE `is_admin`
  ADD CONSTRAINT `FK_is_admin_users` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `FK_questions_quiz_type` FOREIGN KEY (`quiz_type_id`) REFERENCES `quiz_type` (`id`);

--
-- Constraints for table `questions_existing_requests`
--
ALTER TABLE `questions_existing_requests`
  ADD CONSTRAINT `FK_questions_existing_requests_quiz_type` FOREIGN KEY (`quiz_type_id`) REFERENCES `quiz_type` (`id`),
  ADD CONSTRAINT `FK_questions_existing_requests_users` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `questions_not_existing_requests`
--
ALTER TABLE `questions_not_existing_requests`
  ADD CONSTRAINT `FK_questions_not_existing_requests_quiz_type_requests` FOREIGN KEY (`quiz_type_requests_id`) REFERENCES `quiz_type_requests` (`id`),
  ADD CONSTRAINT `FK_questions_not_existing_requests_users` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `quiz_playing`
--
ALTER TABLE `quiz_playing`
  ADD CONSTRAINT `FK_quiz_playing_quiz_type` FOREIGN KEY (`quiz_type_id`) REFERENCES `quiz_type` (`id`),
  ADD CONSTRAINT `FK_quiz_playing_users` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `quiz_type_requests`
--
ALTER TABLE `quiz_type_requests`
  ADD CONSTRAINT `FK_quiz_type_requests_is_admin` FOREIGN KEY (`is_admin_id`) REFERENCES `is_admin` (`users_id`),
  ADD CONSTRAINT `FK_quiz_type_requests_users` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_has_achievement`
--
ALTER TABLE `user_has_achievement`
  ADD CONSTRAINT `FK_users_has_achievement_achievements` FOREIGN KEY (`achievements_id`) REFERENCES `achievements` (`id`),
  ADD CONSTRAINT `FK_users_has_achievement_users` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
