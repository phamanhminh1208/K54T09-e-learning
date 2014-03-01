-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2014 at 07:43 PM
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `allowed_ips`
--

INSERT INTO `allowed_ips` (`id`, `IP`) VALUES
(1, '::1');

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
  `FileName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Link` text COLLATE utf8_unicode_ci NOT NULL,
  `Description` text COLLATE utf8_unicode_ci,
  `Status` int(11) DEFAULT NULL COMMENT '0: normal  1:locked',
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
  `Status` int(11) DEFAULT '0' COMMENT '0:normal  1:locked',
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `managers`
--

INSERT INTO `managers` (`id`, `user_id`) VALUES
(1, 1),
(2, 13),
(3, 14);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE IF NOT EXISTS `reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ReportedLessonID` int(11) DEFAULT NULL,
  `ReportPersonID` int(11) NOT NULL,
  `ReportPersonUsername` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ReportedPersonID` int(11) NOT NULL,
  `ReportTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ReportType` int(11) NOT NULL COMMENT '1:lesson  2:file  3:test  4:comment   5:others',
  `Reason` text COLLATE utf8_unicode_ci,
  `Status` int(11) NOT NULL COMMENT '0:reject 1:accept',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='select users.Username\r\nfrom reports, users\r\nwhere users.id in (`ReportedPersonID`,`ReportPersonID`)' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `ReportedLessonID`, `ReportPersonID`, `ReportPersonUsername`, `ReportedPersonID`, `ReportTime`, `ReportType`, `Reason`, `Status`) VALUES
(1, 1, 2, 'teacher1', 1, '2014-02-25 08:42:43', 2, 'absafkajfh', 1),
(2, 1, 3, 'student1', 2, '2014-02-25 08:45:12', 1, 'asfjasfk', 2);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `user_id`, `CreditCardNum`) VALUES
(1, 3, '09328024-7980-2312-3633-8632'),
(2, 9, '09328024-7980-2312-3633-8632'),
(3, 10, '09328024-7980-2312-3633-8632'),
(4, 11, '09328024-7980-2312-3633-8632'),
(5, 12, '09328024-7980-2312-3633-8632');

-- --------------------------------------------------------

--
-- Table structure for table `system_params`
--

CREATE TABLE IF NOT EXISTS `system_params` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ParamName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Value` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

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
(8, 'AUTO_BACKUP_TIME', 7),
(9, 'TEMP_LOCK_TIME', 60);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE IF NOT EXISTS `teachers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `BankAccount` varchar(50) COLLATE utf32_unicode_ci NOT NULL,
  `SecretQuestion` varchar(255) COLLATE utf32_unicode_ci NOT NULL,
  `FirstAnswer` varchar(40) COLLATE utf32_unicode_ci NOT NULL,
  `Answer` varchar(40) COLLATE utf32_unicode_ci NOT NULL,
  `LastIP` varchar(50) COLLATE utf32_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `user_id`, `BankAccount`, `SecretQuestion`, `FirstAnswer`, `Answer`, `LastIP`) VALUES
(1, 2, '2980-948-1-5214933', 'あなたの名前？', '3c34b06a0f31bf3c0ae61bb14e8314eec23a8ff6', '3c34b06a0f31bf3c0ae61bb14e8314eec23a8ff6', '::1'),
(2, 4, '2980-948-1-5214936', 'What is name of your first pet?', '22940f2a0a3696072ca02126fea01857b499cd49', '22940f2a0a3696072ca02126fea01857b499cd49', '192.168.0.9'),
(3, 5, '2980-948-1-5214938', 'あなたの名前？', 'f9366484804ba17ba715d8102a0a45b281172606', 'f9366484804ba17ba715d8102a0a45b281172606', '::1'),
(4, 6, '2980-948-1-5214937', 'What is name of your first pet?', 'b18b59d46b5ef26716217d814167270bc0c1a21c', 'b18b59d46b5ef26716217d814167270bc0c1a21c', '::1'),
(5, 7, '2980-948-1-5214935', 'What is name of your first pet?', 'd8cb15e10f4ca47bf6f615cb141910566738e94c', 'd8cb15e10f4ca47bf6f615cb141910566738e94c', '::1'),
(6, 8, '2980-948-1-5214934', 'What is name of your first pet?', '4482ba5bcfd9da0b339701d35aa408e1dd247724', '4482ba5bcfd9da0b339701d35aa408e1dd247724', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE IF NOT EXISTS `tests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TestName` varchar(255) COLLATE utf32_unicode_ci NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `Description` text COLLATE utf32_unicode_ci,
  `Status` int(11) NOT NULL COMMENT '0:normal  1:locked',
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
  `Username` varchar(36) COLLATE utf32_unicode_ci NOT NULL,
  `Password` varchar(40) COLLATE utf32_unicode_ci NOT NULL,
  `FirstPass` varchar(40) COLLATE utf32_unicode_ci NOT NULL,
  `UserType` int(11) NOT NULL DEFAULT '3' COMMENT '1: manager  2:teacher  3:student',
  `RealName` varchar(128) COLLATE utf32_unicode_ci NOT NULL,
  `Email` varchar(255) COLLATE utf32_unicode_ci DEFAULT NULL,
  `Birthday` date DEFAULT NULL,
  `FilterChar` varchar(1) COLLATE utf32_unicode_ci NOT NULL,
  `Address` text COLLATE utf32_unicode_ci,
  `PhoneNum` varchar(24) COLLATE utf32_unicode_ci DEFAULT NULL,
  `CreateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Status` int(11) NOT NULL DEFAULT '3' COMMENT '1:temp_locked 2:normal 3:not_active 4:login_locked',
  `WarnNum` int(11) NOT NULL DEFAULT '0',
  `LockTime` datetime DEFAULT NULL,
  `LastActionTime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci AUTO_INCREMENT=15 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `Username`, `Password`, `FirstPass`, `UserType`, `RealName`, `Email`, `Birthday`, `FilterChar`, `Address`, `PhoneNum`, `CreateTime`, `Status`, `WarnNum`, `LockTime`, `LastActionTime`) VALUES
(1, 'anhminh1208', '574fdd18538a9858b1857a4c5f1d432bc4d15627', '574fdd18538a9858b1857a4c5f1d432bc4d15627', 1, 'Minh Phạm', NULL, '0000-00-00', 'a', 'Bắc Ninh', '012345678902', '2014-02-13 16:31:33', 2, 0, NULL, NULL),
(2, 'teacher1', '8269da729699f7d98e37ae5c192e263038a8837b', '8269da729699f7d98e37ae5c192e263038a8837b', 2, 'Teacher 1', NULL, '1988-02-14', 'a', 'AAAA', '012345678904', '2014-02-14 16:14:04', 2, 0, '2014-02-28 23:51:10', '2014-03-01 01:38:36'),
(3, 'student1', '0926a1d5a0ed1b4f67e3e608c85671c4eab4d40f', '0926a1d5a0ed1b4f67e3e608c85671c4eab4d40f', 3, 'Student 1', NULL, '1990-04-14', 'a', 'BBBB', '012345678903', '2014-02-14 16:16:58', 2, 0, '2014-02-28 23:47:49', '2014-03-01 01:24:34'),
(4, 'teacher2', '44e1cf77c58119b289d15349d766f712eb38b8b8', '44e1cf77c58119b289d15349d766f712eb38b8b8', 2, 'アイン・ミン', 'teacher2@email.com', '1991-08-12', 'K', 'Home', '0129817130', '2014-02-25 18:02:15', 4, 0, NULL, NULL),
(5, 'teacher3', '798966d1cb54ba0d06193b839b01c5c56993e3f0', '798966d1cb54ba0d06193b839b01c5c56993e3f0', 2, 'ミン', 'teacher3@email.com', '1991-08-12', '1', 'Home', '012345678908', '2014-02-25 20:21:49', 3, 0, NULL, NULL),
(6, 'teacher4', 'a16baa636d4862f9dec9712831181a44cc915d66', 'a16baa636d4862f9dec9712831181a44cc915d66', 2, 'アイン・ミン', 'teacher2@email.com', '1991-08-12', 'h', 'Home', '0129817130', '2014-02-26 19:12:36', 3, 0, NULL, NULL),
(7, 'teacher5', 'd7ab4f606c0ae44cc094243951570f36ccd92ecd', 'd7ab4f606c0ae44cc094243951570f36ccd92ecd', 2, 'Teacher5', 'teacher5@email.com', '1991-08-12', 'O', 'Home', '0129817130', '2014-02-26 19:46:39', 3, 0, NULL, NULL),
(8, 'teacher6', '8059d220fff9ac0e93636d6d576ebbd31acf5a0e', '8059d220fff9ac0e93636d6d576ebbd31acf5a0e', 2, 'Teacher6', 'teacher6@email.com', '1991-08-12', 'f', 'Home', '012345678906', '2014-02-26 19:50:10', 3, 0, NULL, NULL),
(9, 'student2', 'aa5da025601289a62b6b72e9fc5a756d52a85380', 'aa5da025601289a62b6b72e9fc5a756d52a85380', 3, 'Student2', 'studen2@email.com', '1991-08-08', 'g', 'Home', '012345678900', '2014-02-26 20:32:53', 3, 0, NULL, NULL),
(10, 'student3', '45086c87104f4b6a071fdf3e4d235bd672f6cdee', '45086c87104f4b6a071fdf3e4d235bd672f6cdee', 3, 'Student3', 'studen3@email.com', '1991-08-08', 'v', 'Home', '012345678900', '2014-02-26 23:03:20', 3, 0, NULL, NULL),
(11, 'student4', '23bb2ee2594037a58c880501e230edbccf13447d', '23bb2ee2594037a58c880501e230edbccf13447d', 3, 'Student4', 'studen4@email.com', '1991-08-08', 'G', 'Home', '012345678900', '2014-02-26 23:04:08', 3, 0, NULL, NULL),
(12, 'student5', '532cdcc0d9ba2b5c475431ffc9ca947cfbf1b873', '532cdcc0d9ba2b5c475431ffc9ca947cfbf1b873', 3, 'Student5', 'studen5@email.com', '1991-08-08', 'a', 'Home', '012345678900', '2014-02-26 23:04:33', 3, 0, NULL, NULL),
(13, 'manager2', 'a343cf2eed1b355f7247e1284f9f34eac361aa53', 'a343cf2eed1b355f7247e1284f9f34eac361aa53', 1, 'Manager2', NULL, NULL, '2', NULL, NULL, '2014-02-28 15:33:03', 2, 0, NULL, '2014-03-01 01:28:33'),
(14, 'manager3', '4e88cbcbc0ddae15ea438061f05ece1a67107b04', '4e88cbcbc0ddae15ea438061f05ece1a67107b04', 1, 'Manager3', NULL, NULL, 'X', NULL, NULL, '2014-02-28 15:51:23', 2, 0, NULL, NULL);

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
  `WarnType` int(11) NOT NULL COMMENT '1:lesson  2:file  3:test  4:comment  5:others',
  `WarnTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `WarnedLessonID` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
