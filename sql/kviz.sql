-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2023 at 05:46 PM
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
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `text` varchar(256) NOT NULL,
  `points_value` decimal(10,2) NOT NULL DEFAULT 1.00,
  `type` varchar(5) NOT NULL,
  `quiz_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `text`, `points_value`, `type`, `quiz_type_id`) VALUES
(3, 'Kako se zvao prvi kompjuterski virus?', '1.00', 'radio', 1),
(4, 'Šta je \'malware\'?', '1.00', 'radio', 1),
(5, 'Šta je od navedenog tačno?', '1.00', 'chbox', 1),
(7, 'Dopuni značenje skraćenice PDF', '1.00', 'input', 1),
(8, 'Šta od navedenog nije operativni sistem?', '1.00', 'radio', 1),
(9, 'Kompjuterska memorija je podeljena i adresirana kao ćelije veličine od?', '1.00', 'radio', 1),
(10, 'Šta znači RAM?', '1.00', 'input', 1),
(11, 'Šta znači ROM?', '1.00', 'radio', 1),
(12, 'U većini programskih jezika šta predstavlja && znak?', '1.00', 'radio', 1),
(13, 'U sledećem kodu (u programskom jeziku C) šta će sve biti ispisano?\r\n    <code>for(int i = 1; i < 3; i++) {\r\n		printf(\'%d\n\', i);\r\n	}</code>\r\n     ', '1.00', 'chbox', 1),
(14, 'Dopuni sledeći kod (u programskom jeziku Python) da bi izvršio ispis broja 5 na ekranu:', '1.00', 'input', 1),
(15, 'Kojim slovom se najčešće označava primarna particija hard diska na personalnim računarima?', '1.00', 'input', 1),
(16, 'Šta znači CPU?', '1.00', 'radio', 1),
(17, 'Koji deo računara sadrži CPU, RAM i konektore za spoljašnje uredjaje?', '1.00', 'radio', 1),
(18, 'Šta znači OOP?', '1.00', 'input', 1),
(19, 'Šta znači skraćenica LAN?', '1.00', 'radio', 1),
(20, 'Termin hardver predstavlja?', '1.00', 'radio', 1),
(21, 'Koji je, po ISO standardu, tačan prikaz datuma?', '1.00', 'radio', 1),
(22, 'Šta označava HTML?', '1.00', 'input', 1),
(23, 'Kako, u većini programskih jezika, pristupa prvom elementu niza? ', '1.00', 'radio', 1),
(24, 'CLI predstavlja?', '1.00', 'radio', 1),
(25, 'Šta je datoteka (fajl)?', '1.00', 'radio', 1),
(26, 'Izaberite tačne tvrdnje:', '1.00', 'chbox', 1),
(27, 'Izaberite tačne tvrdnje:', '1.00', 'chbox', 1),
(28, 'Šta je IDE?', '1.00', 'radio', 1),
(29, 'Šta kao rezultat daje sledeći kod (u C++): <code>(true && !false) && !(!true)</code>?', '1.00', 'radio', 1),
(30, 'Šta znači DNS? ', '1.00', 'input', 1),
(31, 'Šta znači SMTP?', '1.00', 'input', 1),
(32, 'Šta znači HTTP?', '1.00', 'input', 1),
(33, 'Koji protokol je sigurniji?', '1.00', 'radio', 1),
(34, 'Šta znači GPU?', '1.00', 'radio', 1),
(35, 'Softver predstavlja programske celine koje se sastoje iz dva dela i to:', '1.00', 'chbox', 1),
(36, 'U decimalnom brojnom sistemu, binarno 1010 je?', '1.00', 'radio', 1),
(37, 'Koje klase postoje u klasnom sistemu subnet maski?', '1.00', 'radio', 1),
(38, 'Šta je VPN?', '1.00', 'input', 1),
(39, 'Koji od ponudjenih pojmova su dva osnovna tipa kriptografije?', '1.00', 'chbox', 1),
(40, 'Šta je PKI?', '1.00', 'input', 1),
(41, 'Na šta se odnosi pojam XSS?', '1.00', 'radio', 1),
(42, 'Koji jezik se, najčešće, koristi prilikom XSS?', '1.00', 'radio', 1),
(43, 'Šta je od navedenog svrstano u \'malware\'?', '1.00', 'chbox', 1),
(44, 'Za šta je, od navedenog, zaduženo sertifikaciono telo?', '1.00', 'chbox', 1),
(45, 'Šta, u web programiranju, predstavlja izraz DOM?', '1.00', 'input', 1),
(46, 'Koji od navedenih komandi je za ispis teksta \'hello\' u javascript-u?', '1.00', 'radio', 1),
(47, 'Ako nizovi počinju od 1, mi radimo u kom od navedenih jezika?', '1.00', 'radio', 1),
(48, 'Koji od sledećih jezika ima tačno navedene ekstenzije datoteka?', '1.00', 'chbox', 1),
(49, 'Programi za obradu slika koji rade na principu piksela zovu se?', '1.00', 'radio', 1),
(50, 'U programskom jeziku Python komentare označavamo sa?', '1.00', 'radio', 1),
(51, 'Kako se u CSS-u pristupa nekom elementu sa id-em <code>idPrimer</code>?', '1.00', 'radio', 1),
(52, 'Kako se u CSS-u pristupa nekom elementu sa klasom <code>klasa_primer</code>?', '1.00', 'radio', 1),
(53, 'Ako koristimo operacije PUSH i POP mi imamo veze sa kojim tipom podataka?', '1.00', 'radio', 1),
(54, 'Koji protokol se koristi prilikom \'torrent-ovanja\'?', '1.00', 'radio', 1),
(55, 'Koliko je x na kraju ovog koda u javascript-u?\r\n     <code>\r\n     let x = 5;\r\n     if(x % 2 == 0) {\r\n     x += 10;\r\n     } else {\r\n     x *= 2;\r\n     }\r\n     </code>', '1.00', 'input', 1),
(56, 'Šta je od sledećih tačno?', '1.00', 'chbox', 1),
(57, 'Kojom jedinicom se izražava radni takt procesora?', '1.00', 'radio', 1),
(58, 'Šta znači skraćenica BIOS?', '1.00', 'input', 1),
(59, 'Memorija koja gubi podatke pri isključenju računara je?', '1.00', 'radio', 1),
(60, 'Čemu služe programski prevodioci?', '1.00', 'radio', 1),
(61, 'Šta je multimedija?', '1.00', 'radio', 1),
(62, 'Šta sadrži \'.mp3\' datoteka?', '1.00', 'radio', 1),
(63, 'Šta znači SQL?', '1.00', 'radio', 1);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_type`
--

CREATE TABLE `quiz_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `times_played` int(11) NOT NULL DEFAULT 0,
  `score` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz_type`
--

INSERT INTO `quiz_type` (`id`, `name`, `times_played`, `score`) VALUES
(1, 'Informatika', 0, '0.00');

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
  `last_log_in` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `first_name`, `last_name`, `date_of_birth`, `registration_date`, `last_log_in`) VALUES
(1, 'ice@gmail.com', 'ice', 'e10adc3949ba59abbe56e057f20f883e', 'Jovan', 'Isailovic', '2001-10-03', '2023-01-10', '2023-01-10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_answers_questions` (`questions_id`) USING BTREE;

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_questions_quiz_type` (`quiz_type_id`);

--
-- Indexes for table `quiz_type`
--
ALTER TABLE `quiz_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `quiz_type`
--
ALTER TABLE `quiz_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `FK_odgovori_pitanja` FOREIGN KEY (`questions_id`) REFERENCES `questions` (`id`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `FK_questions_quiz_type` FOREIGN KEY (`quiz_type_id`) REFERENCES `quiz_type` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
