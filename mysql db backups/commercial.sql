-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2020 at 07:37 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `commerical`
--

-- --------------------------------------------------------

--
-- Table structure for table `parts`
--

CREATE TABLE `parts` (
  `id` int(10) NOT NULL,
  `title` varchar(200) COLLATE utf8_persian_ci NOT NULL,
  `body` longtext COLLATE utf8_persian_ci NOT NULL,
  `keywords` text COLLATE utf8_persian_ci NOT NULL,
  `date` date NOT NULL,
  `createrid` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `parts`
--

INSERT INTO `parts` (`id`, `title`, `body`, `keywords`, `date`, `createrid`) VALUES
(1, 'طراحی وب و نرم افزار های شخصی و سازمانی', '<div style=\"text-align: right;\">انجام کلیه امور طراحی سایت و نرم افزار های خود را به ما بسپارید.</div><div style=\"text-align: right;\">همچنین در صورت نیاز به مشاور، کارشناس در زمینه فناوری های وب و همچنین نرم افزار های شخصی و سازمانی با ما در تماس باشید.</div><div style=\"text-align: right;\"><br></div><div style=\"text-align: right;\">همچنین برای یادگیری زبان های برنامه نویسی کارآمد در بازار کار نیز میتوانید از بلاگ ما و برای مشاوره در یادگیری از بخش تماس با ما در ارتباط باشید.</div><div style=\"text-align: right;\"><br></div><div style=\"text-align: right;\"><br></div><div class=\"row\"><button class=\"btn btn-primary\">تماس با ما</button><button class=\"btn btn-danger\">سفارش پروژه</button></div>', 'طراحیوب,طراحی وب,وب دیزاین,برنامه نویسی,سفارش سایت,web design,programmer,programming,برنامه نویس,سفارش طراحی,order web,cheap website,adviser,programming advisor', '2020-04-04', 0),
(2, 'طراحی وب و نرم افزار های شخصی و سازمانی', '<div style=\"text-align: right;\">انجام کلیه امور طراحی سایت و نرم افزار های خود را به ما بسپارید.</div><div style=\"text-align: right;\">همچنین در صورت نیاز به مشاور، کارشناس در زمینه فناوری های وب و همچنین نرم افزار های شخصی و سازمانی با ما در تماس باشید.</div><div style=\"text-align: right;\"><br></div><div style=\"text-align: right;\">همچنین برای یادگیری زبان های برنامه نویسی کارآمد در بازار کار نیز میتوانید از بلاگ ما و برای مشاوره در یادگیری از بخش تماس با ما در ارتباط باشید.</div><div style=\"text-align: right;\"><br></div><div style=\"text-align: right;\"><br></div><div class=\"row\"><button class=\"btn btn-primary\">تماس با ما</button><button class=\"btn btn-danger\">سفارش پروژه</button></div>', 'طراحیوب,طراحی وب,وب دیزاین,برنامه نویسی,سفارش سایت,web design,programmer,programming,برنامه نویس,سفارش طراحی,order web,cheap website,adviser,programming advisor', '2020-04-04', 0),
(3, 'طراحی وب و نرم افزار های شخصی و سازمانی', '<div style=\"text-align: right;\">انجام کلیه امور طراحی سایت و نرم افزار های خود را به ما بسپارید.</div><div style=\"text-align: right;\">همچنین در صورت نیاز به مشاور، کارشناس در زمینه فناوری های وب و همچنین نرم افزار های شخصی و سازمانی با ما در تماس باشید.</div><div style=\"text-align: right;\"><br></div><div style=\"text-align: right;\">همچنین برای یادگیری زبان های برنامه نویسی کارآمد در بازار کار نیز میتوانید از بلاگ ما و برای مشاوره در یادگیری از بخش تماس با ما در ارتباط باشید.</div><div style=\"text-align: right;\"><br></div><div style=\"text-align: right;\"><br></div><div class=\"row\"><button class=\"btn btn-primary\">تماس با ما</button><button class=\"btn btn-danger\">سفارش پروژه</button></div>', 'طراحیوب,طراحی وب,وب دیزاین,برنامه نویسی,سفارش سایت,web design,programmer,programming,برنامه نویس,سفارش طراحی,order web,cheap website,adviser,programming advisor', '2020-04-04', 0),
(4, 'طراحی وب و نرم افزار های شخصی و سازمانی', '<div style=\"text-align: right;\">انجام کلیه امور طراحی سایت و نرم افزار های خود را به ما بسپارید.</div><div style=\"text-align: right;\">همچنین در صورت نیاز به مشاور، کارشناس در زمینه فناوری های وب و همچنین نرم افزار های شخصی و سازمانی با ما در تماس باشید.</div><div style=\"text-align: right;\"><br></div><div style=\"text-align: right;\">همچنین برای یادگیری زبان های برنامه نویسی کارآمد در بازار کار نیز میتوانید از بلاگ ما و برای مشاوره در یادگیری از بخش تماس با ما در ارتباط باشید.</div><div style=\"text-align: right;\"><br></div><div style=\"text-align: right;\"><br></div><div class=\"row\"><button class=\"btn btn-primary\">تماس با ما</button><button class=\"btn btn-danger\">سفارش پروژه</button></div>', 'طراحیوب,طراحی وب,وب دیزاین,برنامه نویسی,سفارش سایت,web design,programmer,programming,برنامه نویس,سفارش طراحی,order web,cheap website,adviser,programming advisor', '2020-04-04', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `parts`
--
ALTER TABLE `parts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `parts`
--
ALTER TABLE `parts`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
