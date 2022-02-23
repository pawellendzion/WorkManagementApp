-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 23 Lut 2022, 15:58
-- Wersja serwera: 10.4.21-MariaDB
-- Wersja PHP: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `dbwmapp`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `customers`
--

CREATE TABLE `customers` (
  `ID` int(11) NOT NULL,
  `Name` varchar(20) NOT NULL,
  `Lastname` varchar(30) NOT NULL,
  `Phone` varchar(16) NOT NULL,
  `Email` varchar(70) NOT NULL,
  `Last_Contact` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `customers`
--

INSERT INTO `customers` (`ID`, `Name`, `Lastname`, `Phone`, `Email`, `Last_Contact`) VALUES
(1, 'Jan', 'Kowalski', '(+48)000-111-222', 'jkowal@email.com', NULL),
(2, 'Adam', 'Sopek', '(+48)111-222-333', 'asopek@email.com', NULL),
(3, 'Marta', 'Kini', '(+48)222-333-444', 'mkini@email.com', NULL),
(4, 'Piotr', 'Wita', '(+48)333-444-555', 'pwita@email.com', NULL),
(5, 'Marcin', 'Melski', '(+48)444-555-666', 'mmelski@email.com', NULL),
(6, 'Mateusz', 'Kiro', '(+48)555-666-777', 'mkiro@email.com', NULL),
(7, 'Aleksandra', 'Wolinowska', '(+48)666-777-888', 'awolinowska@email.com', NULL),
(8, 'Adam', 'Policki', '(+48)777-888-999', 'apolicki@email.com', NULL),
(9, 'Damian', 'Chwilo', '(+48)888-999-000', 'dchwilo@email.com', NULL),
(10, 'Anna', 'Jonik', '(+48)999-000-111', 'ajonik@email.com', NULL),
(11, 'Beata', 'Tomik', '(+48)000-222-111', 'btomik@email.com', NULL),
(12, 'Alicja', 'Mowik', '(+48)111-333-222', 'amowik@email.com', NULL),
(13, 'Piotr', 'Omotek', '(+48)222-444-333', 'pomotek@email.com', NULL),
(14, 'Anna', 'Nomicka', '(+48)333-555-444', 'anomicka@email.com', NULL),
(15, 'Witold', 'Grecki', '(+48)444-666-555', 'wgrecki@email.com', NULL),
(16, 'Paweł', 'Gracki', '(+48)555-777-666', 'pgracki@email.com', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `employees`
--

CREATE TABLE `employees` (
  `ID` int(11) NOT NULL,
  `Name` varchar(20) NOT NULL,
  `Lastname` varchar(30) NOT NULL,
  `Phone` varchar(16) NOT NULL,
  `Email` varchar(70) NOT NULL,
  `Employment_date` date NOT NULL,
  `Salary` decimal(10,2) NOT NULL,
  `Team` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `employees`
--

INSERT INTO `employees` (`ID`, `Name`, `Lastname`, `Phone`, `Email`, `Employment_date`, `Salary`, `Team`) VALUES
(1, 'Marek', 'Tomko', '123-123-123', 'mtonko@email.com', '2021-08-14', '3000.00', 1),
(2, 'Paweł', 'Budyń', '132-123-123', 'pbudyn@email.com', '2015-10-11', '8000.00', 2),
(3, 'Agata', 'Kinko', '213-123-123', 'akinko@email.com', '2018-01-03', '4500.00', 1),
(4, 'Marcin', 'Potok', '231-123-123', 'mpotok@email.com', '2019-03-18', '4000.00', 1),
(5, 'Urszula', 'Rotka', '321-123-123', 'urotka@email.com', '2016-09-11', '8000.00', 2),
(6, 'Piotr', 'Gora', '312-123-123', 'pgora@email.com', '2015-10-11', '8300.00', 2),
(7, 'Karol', 'Lotek', '123-132-123', 'klotek@email.com', '2017-04-25', '4800.00', 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tasks`
--

CREATE TABLE `tasks` (
  `ID` int(11) NOT NULL,
  `Title` varchar(30) NOT NULL,
  `ID_Customer` int(11) NOT NULL,
  `ID_Team` int(11) DEFAULT NULL,
  `Deadline` date DEFAULT NULL,
  `Status` enum('to do','working on','completed') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `tasks`
--

INSERT INTO `tasks` (`ID`, `Title`, `ID_Customer`, `ID_Team`, `Deadline`, `Status`) VALUES
(1, 'Catering website', 10, NULL, '2022-03-22', 'to do'),
(2, 'Sport website', 2, 1, '2022-01-15', 'completed'),
(3, 'Gov website', 3, 2, '2022-02-12', 'working on'),
(4, 'Blog', 4, 1, '2022-02-05', 'working on');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `teams`
--

CREATE TABLE `teams` (
  `ID` int(11) NOT NULL,
  `Name` varchar(20) NOT NULL,
  `Leader` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `teams`
--

INSERT INTO `teams` (`ID`, `Name`, `Leader`) VALUES
(1, 'ABC', 4),
(2, 'DEF', 2);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Phone` (`Phone`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indeksy dla tabeli `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Phone` (`Phone`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `Team` (`Team`);

--
-- Indeksy dla tabeli `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_Team` (`ID_Team`),
  ADD KEY `ID_Customer` (`ID_Customer`);

--
-- Indeksy dla tabeli `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`),
  ADD UNIQUE KEY `Leader` (`Leader`) USING BTREE;

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `customers`
--
ALTER TABLE `customers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT dla tabeli `employees`
--
ALTER TABLE `employees`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `tasks`
--
ALTER TABLE `tasks`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `teams`
--
ALTER TABLE `teams`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`Team`) REFERENCES `teams` (`ID`);

--
-- Ograniczenia dla tabeli `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`ID_Customer`) REFERENCES `customers` (`ID`),
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`ID_Team`) REFERENCES `teams` (`ID`),
  ADD CONSTRAINT `tasks_ibfk_3` FOREIGN KEY (`ID_Customer`) REFERENCES `customers` (`ID`);

--
-- Ograniczenia dla tabeli `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `teams_ibfk_1` FOREIGN KEY (`Leader`) REFERENCES `employees` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
