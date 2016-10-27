-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2016 at 08:14 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.5.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fdonor`
--

-- --------------------------------------------------------

--
-- Table structure for table `fizicka`
--

CREATE TABLE `fizicka` (
  `id` int(11) NOT NULL,
  `prezime` varchar(50) NOT NULL,
  `ime` varchar(30) NOT NULL,
  `id_korisnik` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gradovi1`
--

CREATE TABLE `gradovi1` (
  `pbr` int(5) NOT NULL,
  `naziv` varchar(23) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gradovi1`
--

INSERT INTO `gradovi1` (`pbr`, `naziv`) VALUES
(10000, 'Zagreb'),
(10010, 'Zagreb-Sloboština'),
(10020, 'Zagreb-Novi Zagreb'),
(10040, 'Zagreb-Dubrava'),
(10090, 'Zagreb-Susedgrad'),
(10250, 'Lučko'),
(10255, 'Gornji Stupnik'),
(10290, 'Zaprešić'),
(10295, 'Kupljenovo'),
(10310, 'Ivanić-Grad'),
(10315, 'Novoselec'),
(10340, 'Vrbovec'),
(10345, 'Gradec'),
(10360, 'Sesvete'),
(10370, 'Dugo Selo'),
(10380, 'Sveti Ivan Zelina'),
(10410, 'Velika Gorica'),
(10415, 'Novo Čiče'),
(10430, 'Samobor'),
(10435, 'Sveti Martin pod Okićem'),
(10450, 'Jastrebarsko'),
(10455, 'Kostanjevac'),
(20000, 'Dubrovnik'),
(20205, 'Topolo'),
(20210, 'Cavtat'),
(20215, 'Gruda'),
(20225, 'Babino Polje'),
(20230, 'Ston'),
(20235, 'Zaton Veliki'),
(20240, 'Trpanj'),
(20242, 'Oskorušno'),
(20245, 'Trstenik'),
(20250, 'Orebić'),
(20260, 'Korčula'),
(20270, 'Vela Luka'),
(20275, 'Žrnovo'),
(20290, 'Lastovo'),
(20340, 'Ploče'),
(20345, 'Staševica'),
(20350, 'Metković'),
(20355, 'Opuzen'),
(21000, 'Split'),
(21205, 'Donji Dolac'),
(21210, 'Solin'),
(21215, 'Katel Lukić'),
(21220, 'Trogir'),
(21225, 'Drvenik Veliki'),
(21230, 'Sinj'),
(21232, 'Dicmo'),
(21235, 'Otišić'),
(21240, 'Trilj'),
(21245, 'Tijarica'),
(21250, 'Šestanovac'),
(21255, 'Zadvarje'),
(21260, 'Imotski'),
(21265, 'Studenci'),
(21270, 'Zagvozd'),
(21275, 'Dragljane'),
(21300, 'Makarska'),
(21310, 'Omiš'),
(21315, 'Dugi Rat'),
(21320, 'Baška Voda'),
(21325, 'Tučepi'),
(21330, 'Gradac'),
(21335, 'Podaca'),
(21400, 'Supetar'),
(21405, 'Milna'),
(21410, 'Postira'),
(21420, 'Bol'),
(21425, 'Selca'),
(21430, 'Grohote'),
(21450, 'Hvar'),
(21460, 'Stari Grad'),
(21465, 'Jelsa'),
(21480, 'Vis'),
(21485, 'Komiža'),
(22000, 'Šibenik'),
(22010, 'Šibenik-Brodarica'),
(22020, 'Šibenik-Ražine'),
(22030, 'Šibenik-Zablaće'),
(22205, 'Perković'),
(22215, 'Zaton'),
(22235, 'Kaprije'),
(22240, 'Tisno'),
(22300, 'Knin'),
(22305, 'Kistanje'),
(22310, 'Kijevo'),
(22320, 'Drniš'),
(23000, 'Zadar'),
(23205, 'Bibinje'),
(23210, 'Biograd na moru'),
(23235, 'Vrsi'),
(23245, 'Tribanj'),
(23250, 'Pag'),
(23275, 'Ugljan'),
(23285, 'Brbinj'),
(23295, 'Silba'),
(23420, 'Benkovac'),
(23440, 'Gračac'),
(23445, 'Srb'),
(23450, 'Obrovac'),
(31000, 'Osijek'),
(31205, 'Aljmaš'),
(31215, 'Ernestinovo'),
(31220, 'Višnjevac'),
(31225, 'Breznica-Našička'),
(31300, 'Beli Manastir'),
(31301, 'Branjin Vrh'),
(31305, 'Draž'),
(31315, 'Karanac'),
(31325, 'Čeminac'),
(31400, 'Đakovo'),
(31410, 'Strizivojna'),
(31415, 'Selci Đakovački'),
(31500, 'Našice'),
(31530, 'Podravska Moslavina'),
(31531, 'Viljevo'),
(31540, 'Donji Miholjac'),
(31550, 'Valpovo'),
(31555, 'Marijanci'),
(32000, 'Vukovar'),
(32100, 'Vinkovci'),
(32225, 'Bobota'),
(32235, 'Bapska'),
(32240, 'Mirkovci'),
(32245, 'Nijemci'),
(32255, 'Soljani'),
(32260, 'Gunja'),
(32270, 'Županja'),
(32275, 'Bošnjaci'),
(32280, 'Jarmina'),
(33000, 'Virovitica'),
(33405, 'Pitomača'),
(33410, 'Suhopolje'),
(33515, 'Orahovica'),
(33520, 'Slatina'),
(33525, 'Sopje'),
(34000, 'Požega'),
(34310, 'Pleternica'),
(34315, 'Ratkovica'),
(34320, 'Orljavac'),
(34330, 'Velika'),
(34335, 'Vetovo'),
(34340, 'Kutjevo'),
(34350, 'Čaglin'),
(34550, 'Pakrac'),
(35000, 'Slavonski Brod'),
(35210, 'Vrpolje'),
(35215, 'Svilaj'),
(35220, 'Slavonski Šamac'),
(35250, 'Oriovac'),
(35255, 'Slavonski Kobaš'),
(35400, 'Nova Gradiška'),
(35420, 'Staro Petrovo Selo'),
(35425, 'Davor'),
(35430, 'Okučani'),
(35435, 'Stara Gradiška'),
(40000, 'Čakovec'),
(40305, 'Nedelišće'),
(40315, 'Mursko Središće'),
(40320, 'Donji Kraljevec'),
(40325, 'Draškovec'),
(42000, 'Varadin'),
(42205, 'Vidovec'),
(42220, 'Novi Marof'),
(42225, 'Breznički Hum'),
(42230, 'Ludbreg'),
(42240, 'Ivanec'),
(42245, 'Donja Voća'),
(42250, 'Lepoglava'),
(42255, 'Donja Višnjica'),
(43000, 'Bjelovar'),
(43240, 'Čazma'),
(43245, 'Gornji Draganec'),
(43270, 'Veliki Grđevac'),
(43271, 'Velika Pisanica'),
(43280, 'Garešnica'),
(43285, 'Velika Trnovitica'),
(43290, 'Grubišno Polje'),
(43500, 'Daruvar'),
(43505, 'Končanica'),
(43531, 'Veliki Bastaji'),
(44000, 'Sisak'),
(44010, 'Sisak-Caprag'),
(44205, 'Donja Bačuga'),
(44210, 'Sunja'),
(44250, 'Petrinja'),
(44271, 'Letovanić'),
(44320, 'Kutina'),
(44325, 'Krapje'),
(44330, 'Novska'),
(44400, 'Glina'),
(44405, 'Mali Gradac'),
(44410, 'Gvozd'),
(44415, 'Topusko'),
(44425, 'Gornja Bučica'),
(44430, 'Hrvatska Kostajnica'),
(44435, 'Divuša'),
(44440, 'Dvor'),
(44450, 'Hrvatska Dubica'),
(47000, 'Karlovac'),
(47201, 'Draganići'),
(47205, 'Vukmanić'),
(47220, 'Vojnić'),
(47240, 'Slunj'),
(47245, 'Rakovica'),
(47250, 'Duga Resa'),
(47251, 'Bosiljevo'),
(47280, 'Ozalj'),
(47285, 'Radatovići'),
(47300, 'Ogulin'),
(47302, 'Oštarije'),
(47305, 'Lička Jesenica'),
(48000, 'Koprivnica'),
(48260, 'Krievci'),
(48265, 'Raven'),
(48305, 'Reka'),
(48325, 'Novigrad Podravski'),
(48350, 'Đurđevac'),
(48355, 'Novo Virje'),
(49000, 'Krapina'),
(49210, 'Zabok'),
(49215, 'Tuhelj'),
(49221, 'Bedekovčina'),
(49225, 'Đurmanec'),
(49240, 'Donja Stubica'),
(49245, 'Gornja Stubica'),
(49247, 'Zlatar Bistrica'),
(49250, 'Zlatar'),
(49255, 'Novi Golubovec'),
(49290, 'Klanjec'),
(49295, 'Kumrovec'),
(51000, 'Rijeka'),
(51211, 'Matulji'),
(51215, 'Kastav'),
(51225, 'Praputnjak'),
(51250, 'Novi Vinodolski'),
(51251, 'Ledenice'),
(51260, 'Crikvenica'),
(51265, 'Dramalj'),
(51280, 'Rab'),
(51300, 'Delnice'),
(51305, 'Tršće'),
(51315, 'Mrkopalj'),
(51325, 'Moravice'),
(51410, 'Opatija'),
(51415, 'Lovran'),
(51500, 'Krk'),
(51515, 'Šilo'),
(51550, 'Mali Lošinj'),
(51555, 'Belej'),
(52000, 'Pazin'),
(52100, 'Pula'),
(52210, 'Rovinj (Rovigno)'),
(52215, 'Vodnjan (Dignano)'),
(52220, 'Labin'),
(52420, 'Buzet'),
(52425, 'Roč'),
(52440, 'Poreč'),
(52445, 'Baderna'),
(52450, 'Vrsar'),
(52460, 'Buje (Buie)'),
(52465, 'Tar'),
(52470, 'Umag (Umago)'),
(52475, 'Savudrija (Salvore)'),
(53000, 'Gospić'),
(53205, 'Medak'),
(53220, 'Otočac'),
(53225, 'Švica'),
(53230, 'Korenica'),
(53235, 'Bunić'),
(53250, 'Donji Lapac'),
(53260, 'Brinje'),
(53270, 'Senj'),
(53285, 'Lukovo');

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE `korisnik` (
  `id` int(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `kontakt` varchar(30) NOT NULL,
  `tip` int(11) NOT NULL,
  `OIB` varchar(25) NOT NULL,
  `lozinka` varchar(30) NOT NULL,
  `grad` int(11) NOT NULL,
  `adresa` varchar(50) NOT NULL,
  `aktivacijski` varchar(100) NOT NULL,
  `aktivirano` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `paketi`
--

CREATE TABLE `paketi` (
  `id` int(11) NOT NULL,
  `naziv` varchar(20) NOT NULL DEFAULT 'Paket N',
  `vrijeme_slanja` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pristiglo` tinyint(1) NOT NULL,
  `vrijeme_pristiglo` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `naruceno` tinyint(1) NOT NULL,
  `vrijeme_naruceno` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `preuzeto` tinyint(1) NOT NULL,
  `vrijeme_preuzeto` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `id_volonter` int(11) DEFAULT NULL,
  `id_donor` int(11) NOT NULL,
  `id_potrebitog` int(11) DEFAULT NULL,
  `preuzimanje` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pravna`
--

CREATE TABLE `pravna` (
  `id` int(11) NOT NULL,
  `naziv` varchar(100) NOT NULL,
  `id_korisnik` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stavka`
--

CREATE TABLE `stavka` (
  `id` int(11) NOT NULL,
  `naziv` varchar(100) NOT NULL,
  `kolicina` varchar(10) NOT NULL,
  `jedinica` varchar(50) NOT NULL,
  `vrsta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stavka_paket`
--

CREATE TABLE `stavka_paket` (
  `id_stavka` int(11) NOT NULL,
  `id_paket` int(11) NOT NULL,
  `stanje` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tip`
--

CREATE TABLE `tip` (
  `id` int(11) NOT NULL,
  `naziv` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vrsta`
--

CREATE TABLE `vrsta` (
  `id` int(11) NOT NULL,
  `naziv` varchar(100) NOT NULL,
  `opis` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fizicka`
--
ALTER TABLE `fizicka`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_korisnik` (`id_korisnik`);

--
-- Indexes for table `gradovi1`
--
ALTER TABLE `gradovi1`
  ADD PRIMARY KEY (`pbr`),
  ADD UNIQUE KEY `pbr` (`pbr`);

--
-- Indexes for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD PRIMARY KEY (`id`),
  ADD KEY `grad` (`grad`),
  ADD KEY `tip` (`tip`);

--
-- Indexes for table `paketi`
--
ALTER TABLE `paketi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_donor` (`id_donor`),
  ADD KEY `id_volonter` (`id_volonter`),
  ADD KEY `id_potrebitog` (`id_potrebitog`);

--
-- Indexes for table `pravna`
--
ALTER TABLE `pravna`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_korisnik` (`id_korisnik`);

--
-- Indexes for table `stavka`
--
ALTER TABLE `stavka`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vrsta` (`vrsta`);

--
-- Indexes for table `stavka_paket`
--
ALTER TABLE `stavka_paket`
  ADD KEY `id_stavka` (`id_stavka`),
  ADD KEY `id_paket` (`id_paket`);

--
-- Indexes for table `tip`
--
ALTER TABLE `tip`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vrsta`
--
ALTER TABLE `vrsta`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fizicka`
--
ALTER TABLE `fizicka`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `korisnik`
--
ALTER TABLE `korisnik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `paketi`
--
ALTER TABLE `paketi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pravna`
--
ALTER TABLE `pravna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stavka`
--
ALTER TABLE `stavka`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tip`
--
ALTER TABLE `tip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vrsta`
--
ALTER TABLE `vrsta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `fizicka`
--
ALTER TABLE `fizicka`
  ADD CONSTRAINT `fizicka_ibfk_1` FOREIGN KEY (`id_korisnik`) REFERENCES `korisnik` (`id`);

--
-- Constraints for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD CONSTRAINT `korisnik_ibfk_1` FOREIGN KEY (`grad`) REFERENCES `gradovi1` (`pbr`),
  ADD CONSTRAINT `korisnik_ibfk_2` FOREIGN KEY (`tip`) REFERENCES `tip` (`id`);

--
-- Constraints for table `paketi`
--
ALTER TABLE `paketi`
  ADD CONSTRAINT `paketi_ibfk_1` FOREIGN KEY (`id_volonter`) REFERENCES `korisnik` (`id`),
  ADD CONSTRAINT `paketi_ibfk_2` FOREIGN KEY (`id_donor`) REFERENCES `korisnik` (`id`),
  ADD CONSTRAINT `paketi_ibfk_3` FOREIGN KEY (`id_volonter`) REFERENCES `korisnik` (`id`),
  ADD CONSTRAINT `paketi_ibfk_4` FOREIGN KEY (`id_potrebitog`) REFERENCES `korisnik` (`id`);

--
-- Constraints for table `pravna`
--
ALTER TABLE `pravna`
  ADD CONSTRAINT `pravna_ibfk_1` FOREIGN KEY (`id_korisnik`) REFERENCES `korisnik` (`id`);

--
-- Constraints for table `stavka`
--
ALTER TABLE `stavka`
  ADD CONSTRAINT `stavka_ibfk_1` FOREIGN KEY (`vrsta`) REFERENCES `vrsta` (`id`);

--
-- Constraints for table `stavka_paket`
--
ALTER TABLE `stavka_paket`
  ADD CONSTRAINT `stavka_paket_ibfk_1` FOREIGN KEY (`id_stavka`) REFERENCES `stavka` (`id`),
  ADD CONSTRAINT `stavka_paket_ibfk_2` FOREIGN KEY (`id_paket`) REFERENCES `paketi` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
