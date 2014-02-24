-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2014 at 05:46 AM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `e-learning`
--
CREATE DATABASE IF NOT EXISTS `e-learning` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `e-learning`;

-- --------------------------------------------------------

--
-- Table structure for table `allowed_ips`
--

CREATE TABLE IF NOT EXISTS `allowed_ips` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `IP` varchar(50) COLLATE utf32_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE IF NOT EXISTS `answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `result_id` int(11) NOT NULL,
  `QuestionNum` int(11) NOT NULL,
  `Answer` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `backups`
--

CREATE TABLE IF NOT EXISTS `backups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `BackupTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Link` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ban_students`
--

CREATE TABLE IF NOT EXISTS `ban_students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `BanTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lesson_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Content` text COLLATE utf32_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `Link` text COLLATE utf8_unicode_ci NOT NULL,
  `Description` text COLLATE utf8_unicode_ci,
  `Status` int(11) DEFAULT NULL COMMENT '0: normal  1:lock',
  `Type` int(11) NOT NULL,
  `UploadTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE IF NOT EXISTS `lessons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `LessonName` varchar(255) COLLATE utf32_unicode_ci NOT NULL,
  `Description` text COLLATE utf32_unicode_ci,
  `user_id` int(11) NOT NULL,
  `MakeTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `LessonName`, `Description`, `user_id`, `MakeTime`, `Status`) VALUES
(1, 'IT日本語', 'IT日本語', 2, '2014-02-24 04:42:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lesson_students`
--

CREATE TABLE IF NOT EXISTS `lesson_students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lesson_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Cost` int(11) NOT NULL,
  `Remunaration` float NOT NULL,
  `EndTime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lesson_tags`
--

CREATE TABLE IF NOT EXISTS `lesson_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lesson_id` int(11) NOT NULL,
  `Tag` varchar(255) COLLATE utf32_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `lesson_tags`
--

INSERT INTO `lesson_tags` (`id`, `lesson_id`, `Tag`) VALUES
(1, 1, '日本語'),
(2, 1, 'IT');

-- --------------------------------------------------------

--
-- Table structure for table `managers`
--

CREATE TABLE IF NOT EXISTS `managers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `managers`
--

INSERT INTO `managers` (`id`, `user_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE IF NOT EXISTS `reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ReportLessonID` int(11) NOT NULL,
  `ReportPersonID` int(11) NOT NULL,
  `ReportedPersonID` int(11) NOT NULL,
  `ReportTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ReportType` int(11) NOT NULL COMMENT '1:lesson  2:file  3:test  4:comment   5:others',
  `Reason` text COLLATE utf8_unicode_ci,
  `Status` int(11) NOT NULL COMMENT '0:reject 1:accept',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE IF NOT EXISTS `results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TestTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `Score` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `CreditCardNum` varchar(50) COLLATE utf32_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `user_id`, `CreditCardNum`) VALUES
(1, 3, '09328024-7980-2312-3633-8632');

-- --------------------------------------------------------

--
-- Table structure for table `system_params`
--

CREATE TABLE IF NOT EXISTS `system_params` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ParamName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Value` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `system_params`
--

INSERT INTO `system_params` (`id`, `ParamName`, `Value`) VALUES
(1, 'REQUEST_TIMEOUT', 3000),
(2, 'MAX_TIME_WRONG_PASSWORD', 5),
(3, 'AUTO_LOGOUT_TIME', 3),
(4, 'PRICE_OF_LESSON', 20000),
(5, 'TEACHER_REMUNERATION', 0.6),
(6, 'AVAILABLE_TIME', 7),
(7, 'MAX_TIME_WARNING', 3),
(8, 'AUTO_BACKUP_TIME', 7);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE IF NOT EXISTS `teachers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `BankAccount` varchar(50) COLLATE utf32_unicode_ci NOT NULL,
  `SecretQuestion` text COLLATE utf32_unicode_ci NOT NULL,
  `FirstAnswer` varchar(40) COLLATE utf32_unicode_ci NOT NULL,
  `Answer` varchar(40) COLLATE utf32_unicode_ci NOT NULL,
  `LastIP` varchar(50) COLLATE utf32_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `user_id`, `BankAccount`, `SecretQuestion`, `FirstAnswer`, `Answer`, `LastIP`) VALUES
(1, 2, '9997-626-3-5891158', 'あなたの名前？', 'd1f1bc361b75d25bf77af2e2ad67a39439b372fb', 'd1f1bc361b75d25bf77af2e2ad67a39439b372fb', '192.168.0.9');

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE IF NOT EXISTS `tests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TestName` varchar(255) COLLATE utf32_unicode_ci NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `Description` text COLLATE utf32_unicode_ci,
  `Status` int(11) NOT NULL COMMENT '0:normal  1:lock',
  `LinkTsv` text COLLATE utf32_unicode_ci NOT NULL,
  `LinkHtml` text COLLATE utf32_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(50) COLLATE utf32_unicode_ci NOT NULL,
  `Password` varchar(40) COLLATE utf32_unicode_ci NOT NULL,
  `FirstPass` varchar(40) COLLATE utf32_unicode_ci NOT NULL,
  `UserType` int(11) NOT NULL DEFAULT '3' COMMENT '1: manager  2:teacher  3:student',
  `RealName` varchar(50) COLLATE utf32_unicode_ci DEFAULT NULL,
  `Email` varchar(255) COLLATE utf32_unicode_ci DEFAULT NULL,
  `Birthday` date DEFAULT NULL,
  `FilterChar` varchar(1) COLLATE utf32_unicode_ci NOT NULL,
  `Address` text COLLATE utf32_unicode_ci NOT NULL,
  `PhoneNum` varchar(15) COLLATE utf32_unicode_ci DEFAULT NULL,
  `CreateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Status` int(11) NOT NULL COMMENT '1:locked 2:normal 3:not_active 4:login_locked',
  `WarnNum` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `Username`, `Password`, `FirstPass`, `UserType`, `RealName`, `Email`, `Birthday`, `FilterChar`, `Address`, `PhoneNum`, `CreateTime`, `Status`, `WarnNum`) VALUES
(1, 'anhminh1208', '574fdd18538a9858b1857a4c5f1d432bc4d15627', '574fdd18538a9858b1857a4c5f1d432bc4d15627', 1, 'Minh Phạm', NULL, NULL, 'a', 'Bắc Ninh', NULL, '2014-02-13 16:31:33', 2, 0),
(2, 'teacher1', '8269da729699f7d98e37ae5c192e263038a8837b', '8269da729699f7d98e37ae5c192e263038a8837b', 2, 'Teacher 1', NULL, '1988-02-14', 'a', 'AAAA', NULL, '2014-02-14 16:14:04', 2, 0),
(3, 'student1', '0926a1d5a0ed1b4f67e3e608c85671c4eab4d40f', '0926a1d5a0ed1b4f67e3e608c85671c4eab4d40f', 3, 'Student 1', NULL, '1990-04-14', 'a', 'BBBB', NULL, '2014-02-14 16:16:58', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE IF NOT EXISTS `votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lesson_id` int(11) NOT NULL,
  `Vote` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `warnings`
--

CREATE TABLE IF NOT EXISTS `warnings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `WarnContent` text COLLATE utf8_unicode_ci NOT NULL,
  `WarnedPersonID` int(11) NOT NULL,
  `WarnType` int(11) NOT NULL,
  `WarnTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
