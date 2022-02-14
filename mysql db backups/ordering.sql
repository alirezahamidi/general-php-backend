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
-- Database: `ordering`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) NOT NULL,
  `user` int(10) NOT NULL,
  `source` varchar(15) COLLATE utf8_persian_ci NOT NULL,
  `type` varchar(15) COLLATE utf8_persian_ci NOT NULL,
  `typeDescription` varchar(500) COLLATE utf8_persian_ci NOT NULL,
  `title` varchar(500) COLLATE utf8_persian_ci NOT NULL,
  `description` longtext COLLATE utf8_persian_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8_persian_ci NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user`, `source`, `type`, `typeDescription`, `title`, `description`, `phone`, `date`) VALUES
(1, 1, 'commerical_web', 'costumeWeb', '', 'وبسایت اختصاصی فروش لوازم منزل', 'با سلام ما قصد داریم فقط وبسایت شما رو تست کنیم وگرنه دلیل دیگه ای نداریم\n\nلطفا قبل از سفارش مطالب زیر را به خوبی مطالعه نمایید شرایط استفاده از خدمات:\n\n    نرم افزار های وب نیازمند سرور یا هاست اشتراکی به همراه دامین میباشند\n    تهیه هاست و دامین سفارش جداگانه میباشد و جزو امکانات سفارش سایت اصلی نمیباشد\n    شما میتوانید ضمن سفارش نرم افزار سایت و نرم افزار درخواست پشتیبانی را در هنگام سفارش ثبت نمایید\n    هزینه پشتیبانی نرم افزار و وبسایت همچنین هزینه هاست و دامین به صورت سالیانه میباشد\n    تغییرات در نرم افزار وافزایش امکانات پس از تحویل نرم افزار و در حین آماده سازی سفارش امکانپذیر میباشد\n    ارایه امکانات درخواستی شما که در سفارش خود قید نموده اید جزو وظایف ماست و در صورت نبود هر یک از امکانات در بخش ارتباط با ما به مدیریت اطلاع دهید\n\n', '09350832905', '2020-04-16'),
(2, 1, 'commerical_web', 'personalWeb', '', 'وبسایت اختصاصی فروش لوازم منزل', 'با سلام ما قصد داریم فقط وبسایت شما رو تست کنیم وگرنه دلیل دیگه ای نداریم\n\nلطفا قبل از سفارش مطالب زیر را به خوبی مطالعه نمایید شرایط استفاده از خدمات:\n\n    نرم افزار های وب نیازمند سرور یا هاست اشتراکی به همراه دامین میباشند\n    تهیه هاست و دامین سفارش جداگانه میباشد و جزو امکانات سفارش سایت اصلی نمیباشد\n    شما میتوانید ضمن سفارش نرم افزار سایت و نرم افزار درخواست پشتیبانی را در هنگام سفارش ثبت نمایید\n    هزینه پشتیبانی نرم افزار و وبسایت همچنین هزینه هاست و دامین به صورت سالیانه میباشد\n    تغییرات در نرم افزار وافزایش امکانات پس از تحویل نرم افزار و در حین آماده سازی سفارش امکانپذیر میباشد\n    ارایه امکانات درخواستی شما که در سفارش خود قید نموده اید جزو وظایف ماست و در صورت نبود هر یک از امکانات در بخش ارتباط با ما به مدیریت اطلاع دهید\n\n', '09350832905', '2020-04-16'),
(3, 1, 'commerical_web', 'other', 'یه وبسایت خفن', 'وبسایت اختصاصی فروش لوازم منزل', 'با سلام ما قصد داریم فقط وبسایت شما رو تست کنیم وگرنه دلیل دیگه ای نداریم\n\nلطفا قبل از سفارش مطالب زیر را به خوبی مطالعه نمایید شرایط استفاده از خدمات:\n\n    نرم افزار های وب نیازمند سرور یا هاست اشتراکی به همراه دامین میباشند\n    تهیه هاست و دامین سفارش جداگانه میباشد و جزو امکانات سفارش سایت اصلی نمیباشد\n    شما میتوانید ضمن سفارش نرم افزار سایت و نرم افزار درخواست پشتیبانی را در هنگام سفارش ثبت نمایید\n    هزینه پشتیبانی نرم افزار و وبسایت همچنین هزینه هاست و دامین به صورت سالیانه میباشد\n    تغییرات در نرم افزار وافزایش امکانات پس از تحویل نرم افزار و در حین آماده سازی سفارش امکانپذیر میباشد\n    ارایه امکانات درخواستی شما که در سفارش خود قید نموده اید جزو وظایف ماست و در صورت نبود هر یک از امکانات در بخش ارتباط با ما به مدیریت اطلاع دهید\n\n', '09350832905', '2020-04-16'),
(4, 1, 'commerical_web', 'costumeWeb', '', 'dasdsaasd', 'dsadasdasdadasdsa', '09350832905', '2020-04-16'),
(5, 1, 'commerical_web', 'costumeWeb', '', 'یشیسشیسش', 'یشسیشسیششیس', '09350832905', '2020-04-16'),
(6, 15, 'commerical_web', 'costumeWeb', '', 'پروژه ساخت سایت محله مسعودیه', 'نمونه متن', '09350832905', '2020-04-17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
