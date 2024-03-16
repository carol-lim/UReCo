-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2022 at 07:33 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ureco`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `activityID` int(10) NOT NULL,
  `name` text NOT NULL,
  `organizer` text NOT NULL,
  `dateStart` datetime NOT NULL,
  `dateEnd` datetime NOT NULL,
  `venue` varchar(10) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `approveBy` varchar(10) DEFAULT NULL,
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `updationDate` timestamp NULL DEFAULT NULL,
  `reason` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`activityID`, `name`, `organizer`, `dateStart`, `dateEnd`, `venue`, `status`, `approveBy`, `creationDate`, `updationDate`, `reason`) VALUES
(1, 'Pertandingan Bola Keranjang Antara Kelab', 'Arief Azfar', '2021-12-11 12:00:00', '2021-12-11 18:00:00', 'S-01', 0, NULL, '2021-12-03 17:36:23', NULL, ''),
(4, 'Pertandingan Badminton', 'Arief Azfar', '2021-12-11 04:47:00', '2021-12-11 06:47:00', 'S-03', 1, 'S0004', '2021-12-03 20:47:15', '2021-12-18 08:17:06', ''),
(5, 'asdasd', 'Arief Azfar', '2021-12-11 18:28:00', '2021-12-13 18:28:00', 'S-03', 2, 'S0002', '2021-12-06 10:28:27', '2021-12-18 08:17:09', ''),
(6, 'Charity Run', 'Arief Azfar', '2021-12-13 10:00:00', '2021-12-13 11:00:00', 'S-01', 2, 'S0001', '2021-12-08 02:58:15', '2022-01-04 17:37:41', 'Occupied'),
(7, 'BBQ', 'Arief Azfar', '2022-01-06 20:00:00', '2022-01-06 22:00:00', 'L-02', 2, 'S0002', '2022-01-05 06:43:21', '2022-01-05 06:49:33', 'Occuppied'),
(8, 'Pertandingan Badminton', 'Arief Azfar', '2022-01-10 22:02:00', '2022-01-10 23:02:00', 'S-03', 1, 'S0001', '2022-01-10 14:03:08', '2022-01-10 14:05:13', '');

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `annID` int(10) NOT NULL,
  `annAuthor` varchar(50) NOT NULL,
  `title` text NOT NULL,
  `text` longtext NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `updationDate` timestamp NULL DEFAULT NULL,
  `blockID` varchar(10) NOT NULL,
  `approveBy` varchar(10) NOT NULL,
  `display` int(1) NOT NULL,
  `reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`annID`, `annAuthor`, `title`, `text`, `creationDate`, `updationDate`, `blockID`, `approveBy`, `display`, `reason`) VALUES
(22, 'Arief Azfar', 'Fogging in Satria college', 'At 5.00PM 12/12/2021, there will be a fogging in Satria college. All student is advise to leave the room during the event. Your cooperation is appreciated.', '2022-01-04 17:25:34', '2022-01-05 17:28:04', 'T', 'S0004', 1, NULL),
(23, 'Arief Azfar', 'Badminton Open Tournament', 'Badminton Open Tournament organized by Pusat Sukan UTem is going to be held on 15/12/2021 at the Satria\'s badminton court. The will be two categories for the tournament; single and double. Total prize money of RM300 will be given to the winner. Anyone who have the skill to be the champion may fill the form at the sport center.', '2022-01-04 17:25:22', '2021-12-16 14:00:37', 'T', 'S0004', 1, NULL),
(24, 'Arief Azfar', 'Merry Christmas ', 'We would like to wish you all Merry Christmas to all of the college resident from UTeM College Management. Hope all the student will have a very good time celebrating the holiday.', '2022-01-04 17:25:22', '2021-12-21 10:08:41', 'T', 'S0004', 2, NULL),
(25, 'Arief Azfar', 'COVID-19 SOP', 'Due to COVID-19 pandemic, all resident is advice to follow the standard operation procedure that has been issued by the Ministry of Health. Please wear your mask, keep the 1 meter social distancing, and regularly wash your hands. Take care of yourself.', '2022-01-05 16:53:14', '2022-01-05 16:53:14', 'T', 'S0004', 1, NULL),
(26, 'Arief Azfar', 'Stray Dogs', 'Thanks to the student who had report on the stray dogs within our block. We have successfully cooperate with Melaka Animal Rescuer to sent them to animal rescue center.', '2022-01-04 17:25:22', '2021-12-22 06:56:09', 'T', 'S0004', 2, NULL),
(27, 'Arief Azfar', 'Testing', 'For testing purporses', '2022-01-04 17:25:22', '2021-12-16 14:00:37', 'T', 'S0004', 2, NULL),
(29, 'Arief Azfar', 'F', 'f', '2022-01-04 17:25:22', '2021-12-16 14:24:30', 'T', 'S0004', 2, NULL),
(32, 'Abu Bakar', 'Staff testing', 'staff testing only', '2022-01-04 17:25:22', '2021-12-16 14:21:51', 'T', 'S0001', 2, NULL),
(33, 'Abu Bakar', 'Staff', 'staff testing only', '2022-01-04 17:25:22', '2021-12-16 17:13:31', 'T', 'S0001', 2, NULL),
(34, 'Abu Bakar', 'Christmas', 'Merry Christmas', '2022-01-04 17:25:22', NULL, 'T', 'S0001', 1, NULL),
(35, 'Abu Bakar', 'Merry Christmas', 'Merry Christmas to all student.', '2022-01-04 17:24:33', '2021-12-22 06:57:04', 'T', 'S0001', 2, NULL),
(36, 'Arief Azfar', 'Hello World', 'Hello World by Bersi.', '2022-01-04 17:21:49', '2022-01-04 17:21:49', 'T', 'S0004', 2, 'Test'),
(37, 'Arief Azfar', 'COVID-19', 'Take care of yourself.', '2022-01-05 16:56:12', '2022-01-10 13:59:07', 'T', 'S0004', 2, 'Not appropiate.'),
(38, 'Abu Bakar', 'Hello World', 'Hello world by a humble bot.', '2022-01-05 16:29:24', '2022-01-05 17:08:34', 'T', 'S0001', 2, 'Monthly Clearing'),
(39, 'Abu Bakar', 'Hello World', 'Hello world by a humble bot.', '2022-01-05 16:31:03', NULL, 'T', 'S0001', 1, NULL),
(40, 'Abu Bakar', 'Congratulations', 'Congrats Carol, Sumaya, and Ravin', '2022-01-05 16:39:46', '2022-01-07 16:44:08', 'T', 'S0001', 2, 'Monthly Clearing'),
(41, 'Abu Bakar', 'Test', 'Test', '2022-01-05 17:30:46', NULL, 'T', 'S0001', 0, NULL),
(42, 'Arief Azfar', 'COVID-19 SOP', 'Take care of yourself.', '2022-01-10 13:57:42', '2022-01-10 14:00:12', 'T', 'S0004', 2, 'Monthly Clearing');

-- --------------------------------------------------------

--
-- Table structure for table `block`
--

CREATE TABLE `block` (
  `blockID` varchar(10) NOT NULL,
  `collegeID` varchar(10) NOT NULL,
  `blockName` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `block`
--

INSERT INTO `block` (`blockID`, `collegeID`, `blockName`) VALUES
('A', 'L', 'Alpha'),
('B', 'L', 'Beta'),
('J', 'S', 'Jebat'),
('K', 'S', 'Kasturi'),
('LK', 'S', 'Lekir'),
('LU', 'S', 'Lekiu'),
('T', 'S', 'Tuah');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `categoryID` int(10) NOT NULL,
  `categoryName` text NOT NULL,
  `categoryDescription` text NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `createdBy` varchar(10) NOT NULL,
  `updationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `updatedBy` varchar(10) NOT NULL,
  `display` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryID`, `categoryName`, `categoryDescription`, `creationDate`, `createdBy`, `updationDate`, `updatedBy`, `display`) VALUES
(2, 'Complaint(indoor/my house)', 'Including every facilities in student\'s unit. ', '2021-12-04 08:29:09', 'S0001', NULL, '', 1),
(3, 'Complaint(Common Area)', 'Area outside hostel rooms, including laundry room, surau, public toilet, corridor, etc.', '2021-12-20 03:32:04', 'S0001', NULL, '', 1),
(4, 'Common Query', 'Need not inform Maintenance Team because most of the time it is just a question not a complaint. Just reply the query via updating status. ', '2022-01-05 12:45:58', 'S0001', NULL, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `college`
--

CREATE TABLE `college` (
  `collegeID` varchar(10) NOT NULL,
  `collegeName` text NOT NULL,
  `noStudent` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `college`
--

INSERT INTO `college` (`collegeID`, `collegeName`, `noStudent`) VALUES
('L', 'Lestari', 0),
('S', 'Satria', 0);

-- --------------------------------------------------------

--
-- Table structure for table `facility`
--

CREATE TABLE `facility` (
  `facilityID` varchar(10) NOT NULL,
  `collegeID` varchar(10) NOT NULL,
  `facilityName` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `facility`
--

INSERT INTO `facility` (`facilityID`, `collegeID`, `facilityName`) VALUES
('L-01', 'L', 'Dewan Besar'),
('L-02', 'L', 'Padang Kawad'),
('L-03', 'L', 'Bilik TV'),
('L-04', 'L', 'Ball'),
('S-01', 'S', 'Gelanggang Bola Keranjang'),
('S-02', 'S', 'Gelanggang Futsal'),
('S-03', 'S', 'Gelanggang Badminton');

-- --------------------------------------------------------

--
-- Table structure for table `fileuploaded`
--

CREATE TABLE `fileuploaded` (
  `fuID` int(10) NOT NULL,
  `hdID` int(10) DEFAULT NULL,
  `hdtID` int(10) DEFAULT NULL,
  `annID` int(10) DEFAULT NULL,
  `aID` int(10) DEFAULT NULL,
  `fileName` varchar(255) NOT NULL,
  `filePath` varchar(255) NOT NULL,
  `createdBy` varchar(10) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fileuploaded`
--

INSERT INTO `fileuploaded` (`fuID`, `hdID`, `hdtID`, `annID`, `aID`, `fileName`, `filePath`, `createdBy`, `creationDate`) VALUES
(15, NULL, NULL, NULL, 4, '20211204044715_AI Assignment No. 4.pdf', '../uploaded_files/activity/4', 'B032010342', '2021-12-03 20:47:15'),
(16, 3, 1, NULL, NULL, '20211204180531_milky-way.jpg', '../uploaded_files/helpdesk/3', 'B032010342', '2021-12-04 10:05:31'),
(17, 4, 2, NULL, NULL, '20211204182914_Untitled.png', '../uploaded_files/helpdesk/4', 'B032010342', '2021-12-04 10:29:14'),
(18, 5, 3, NULL, NULL, '20211206181919_southpark-01.png', '../uploaded_files/helpdesk/5', 'B032010342', '2021-12-06 10:19:19'),
(20, NULL, NULL, NULL, 5, '20211206182827_AI Assignment No. 4.pdf', '../uploaded_files/activity/5', 'B032010342', '2021-12-06 10:28:27'),
(21, NULL, NULL, 22, NULL, '20211217014016_dw-thermalfogging-180304.jpg', '../uploaded_files/announcement/22', 'B032010342', '2021-12-16 17:40:16'),
(22, NULL, NULL, 23, NULL, '20211207233621_1386891.jpg', '../uploaded_files/announcement/23', 'B032010342', '2021-12-07 15:36:21'),
(23, NULL, NULL, 24, NULL, '20211207234206_79925290.webp', '../uploaded_files/announcement/24', 'B032010342', '2021-12-07 15:42:06'),
(24, NULL, NULL, 25, NULL, '20211207235004_web_sopcovid19.jpg', '../uploaded_files/announcement/25', 'B032010342', '2021-12-07 15:50:04'),
(25, NULL, NULL, 26, NULL, '20211207235537_Stray_dogs_crosswalk.jpg', '../uploaded_files/announcement/26', 'B032010342', '2021-12-07 15:55:37'),
(26, 6, 4, NULL, NULL, '20211208104525_milky-way.jpg', '../uploaded_files/helpdesk/6', 'B032010342', '2021-12-08 02:45:25'),
(27, NULL, NULL, 27, NULL, '20211208105216_ass 2 math.png', '../uploaded_files/announcement/27', 'B032010342', '2021-12-08 02:52:16'),
(28, NULL, NULL, NULL, 6, '20211208105815_AI Assignment No. 4.pdf', '../uploaded_files/activity/6', 'B032010342', '2021-12-08 02:58:15'),
(29, NULL, NULL, 29, NULL, '20211216200701_calc.JPG', '../uploaded_files/announcement/29', 'B032010342', '2021-12-16 12:07:01'),
(30, NULL, NULL, 32, NULL, '20211217013831_hi.png', '../uploaded_files/announcement/32', 'S0001', '2021-12-16 17:38:31'),
(31, NULL, NULL, 33, NULL, '20211217011254_hi.png', '../uploaded_files/announcement/33', 'S0001', '2021-12-16 17:12:54'),
(32, 4, 6, NULL, NULL, '20211219010948_ann.JPG', '../uploaded_files/helpdesk/4', 'S0001', '2021-12-21 14:13:18'),
(34, 3, 8, NULL, NULL, '20211221180237_team.JPG', '../uploaded_files/helpdesk/3', 'S0001', '2021-12-21 14:13:27'),
(35, NULL, NULL, 34, NULL, '20211221180747_79925290.webp', '../uploaded_files/announcement/34', 'S0001', '2021-12-21 10:07:47'),
(36, 3, 11, NULL, NULL, '20211221224916_flex.JPG', '../uploaded_files/helpdesk/3', 'M0003', '2022-01-04 15:06:30'),
(37, 3, 12, NULL, NULL, '20211221225153_hi.png', '../uploaded_files/helpdesk/3', 'M0003', '2022-01-04 15:06:33'),
(38, 3, 14, NULL, NULL, '20211221225749_tulu.JPG', '../uploaded_files/helpdesk/3', 'S0001', '2022-01-04 15:05:02'),
(39, 5, 17, NULL, NULL, '20211222144517_Capture.PNG', '../uploaded_files/helpdesk/5', 'M0001', '2021-12-22 06:45:17'),
(40, 5, 18, NULL, NULL, '20211222144732_biller code yuran.JPG', '../uploaded_files/helpdesk/5', 'M0001', '2021-12-22 06:47:32'),
(41, NULL, NULL, 35, NULL, '20211222145509_79925290.webp', '../uploaded_files/announcement/35', 'S0001', '2021-12-22 06:55:09'),
(42, NULL, NULL, 36, NULL, '20220104023852_bersi.jpg', '../uploaded_files/announcement/36', 'B032010342', '2022-01-03 18:38:52'),
(43, 7, 21, NULL, NULL, '20220105142656_lightnowork.jpg', '../uploaded_files/helpdesk/7', 'B032010342', '2022-01-05 06:26:56'),
(44, 7, 23, NULL, NULL, '20220105143057_lightwork.jpg', '../uploaded_files/helpdesk/7', 'M0003', '2022-01-05 06:30:57'),
(45, 7, 24, NULL, NULL, '20220105143142_lightwork.jpg', '../uploaded_files/helpdesk/7', 'M0003', '2022-01-05 06:31:42'),
(46, NULL, NULL, 37, NULL, '20220105143927_web_sopcovid19.jpg', '../uploaded_files/announcement/37', 'B032010342', '2022-01-05 06:39:27'),
(47, NULL, NULL, NULL, 7, '20220105144321_Proposal.pdf', '../uploaded_files/activity/7', 'B032010342', '2022-01-05 06:43:21'),
(48, 8, 26, NULL, NULL, '20220105210251_20210107171525_broken water tap.jpg', '../uploaded_files/helpdesk/8', 'B032010342', '2022-01-05 13:02:51'),
(49, 8, 29, NULL, NULL, '20220105213741_20210107213000_water tap.jpg', '../uploaded_files/helpdesk/8', 'M0003', '2022-01-05 13:37:41'),
(51, 8, 31, NULL, NULL, '20220105214347_20210107213815_done water tap.jfif', '../uploaded_files/helpdesk/8', 'M0003', '2022-01-05 13:43:47'),
(52, NULL, NULL, 38, NULL, '20220106002924_79925290.webp', '../uploaded_files/announcement/38', 'S0001', '2022-01-05 16:29:24'),
(53, NULL, NULL, 39, NULL, '20220106003103_79925290.webp', '../uploaded_files/announcement/39', 'S0001', '2022-01-05 16:31:03'),
(54, NULL, NULL, 40, NULL, '20220106003946_1386891.jpg', '../uploaded_files/announcement/40', 'S0001', '2022-01-05 16:39:46'),
(55, NULL, NULL, 41, NULL, '20220106013046_Daki_in_anime.jpg', '../uploaded_files/announcement/41', 'S0001', '2022-01-05 17:30:46'),
(57, 10, 35, NULL, NULL, '20220110212418_20210107171525_broken water tap.jpg', '../uploaded_files/helpdesk/10', 'B032010342', '2022-01-10 13:24:18'),
(58, 11, 36, NULL, NULL, '20220110213119_20210107171525_broken water tap.jpg', '../uploaded_files/helpdesk/11', 'B032010342', '2022-01-10 13:31:19'),
(59, 11, 38, NULL, NULL, '20220110213512_20210107213000_water tap.jpg', '../uploaded_files/helpdesk/11', 'M0003', '2022-01-10 13:35:12'),
(60, 11, 39, NULL, NULL, '20220110213601_20210107213815_done water tap.jfif', '../uploaded_files/helpdesk/11', 'M0003', '2022-01-10 13:36:01'),
(61, 12, 42, NULL, NULL, '20220110214842_20210107171525_broken water tap.jpg', '../uploaded_files/helpdesk/12', 'B032010342', '2022-01-10 13:48:42'),
(62, 12, 44, NULL, NULL, '20220110215131_20210107213000_water tap.jpg', '../uploaded_files/helpdesk/12', 'M0003', '2022-01-10 13:51:31'),
(63, 12, 45, NULL, NULL, '20220110215214_20210107213815_done water tap.jfif', '../uploaded_files/helpdesk/12', 'M0003', '2022-01-10 13:52:14'),
(64, NULL, NULL, 42, NULL, '20220110215742_web_sopcovid19.jpg', '../uploaded_files/announcement/42', 'B032010342', '2022-01-10 13:57:42'),
(65, NULL, NULL, NULL, 8, '20220110220308_DUMMY PAPERWORK.pdf', '../uploaded_files/activity/8', 'B032010342', '2022-01-10 14:03:08');

-- --------------------------------------------------------

--
-- Table structure for table `helpdesk`
--

CREATE TABLE `helpdesk` (
  `hdID` int(10) NOT NULL,
  `matrixNo` varchar(10) NOT NULL,
  `category` int(10) NOT NULL,
  `subcategory` int(10) NOT NULL,
  `description` mediumtext NOT NULL,
  `openDate` timestamp NULL DEFAULT current_timestamp(),
  `daysNeed` int(2) NOT NULL,
  `daysUsed` int(2) NOT NULL,
  `closeDate` timestamp NULL DEFAULT NULL,
  `mtView` int(1) NOT NULL DEFAULT 0,
  `mtWork` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `helpdesk`
--

INSERT INTO `helpdesk` (`hdID`, `matrixNo`, `category`, `subcategory`, `description`, `openDate`, `daysNeed`, `daysUsed`, `closeDate`, `mtView`, `mtWork`) VALUES
(3, 'B032010342', 2, 2, 'Ceiling Fan Malfunction.', '2021-12-04 10:05:31', 3, 18, '2021-12-21 14:57:49', 2, 3),
(4, 'B032010342', 2, 1, 'Broken Bed.', '2021-12-04 10:29:14', 2, 0, NULL, 0, 0),
(5, 'B032010342', 2, 1, 'Cracked Window', '2021-12-06 10:19:19', 2, 17, '2021-12-22 06:50:13', 2, 3),
(6, 'B032010342', 2, 2, 'Crack windows.', '2021-12-08 02:45:25', 3, 0, '2021-12-20 14:50:31', 2, 3),
(7, 'B032010342', 2, 1, 'Light is not broken', '2022-01-05 06:26:56', 2, 0, '2022-01-05 06:36:54', 2, 3),
(8, 'B032010342', 2, 4, 'My water tap is broken. Please fix it ASAP.', '2022-01-05 13:02:51', 2, 1, '2022-01-05 13:56:52', 2, 3),
(10, 'B032010342', 2, 4, 'Broken water tap.', '2022-01-10 13:24:18', 2, 0, NULL, 0, 0),
(11, 'B032010342', 2, 4, 'Broken water tap.', '2022-01-10 13:31:19', 2, 1, '2022-01-10 13:39:42', 2, 3),
(12, 'B032010342', 2, 4, 'Water tap broken.', '2022-01-10 13:48:42', 2, 1, '2022-01-10 13:54:45', 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `helpdesktracker`
--

CREATE TABLE `helpdesktracker` (
  `hdtID` int(10) NOT NULL,
  `statusName` text NOT NULL,
  `description` mediumtext NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `createdBy` varchar(10) NOT NULL,
  `hdID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `helpdesktracker`
--

INSERT INTO `helpdesktracker` (`hdtID`, `statusName`, `description`, `creationDate`, `createdBy`, `hdID`) VALUES
(1, 'Ticket Submitted', 'Student submitted new service desk form.', '2021-12-04 10:05:31', 'B032010342', 3),
(2, 'Ticket Submitted', 'Student submitted new service desk form.', '2021-12-04 10:29:14', 'B032010342', 4),
(3, 'Ticket Submitted', 'Student submitted new service desk form.', '2021-12-06 10:19:19', 'B032010342', 5),
(4, 'Ticket Submitted', 'Student submitted new service desk form.', '2021-12-08 02:45:25', 'B032010342', 6),
(5, 'Closed', 'Windows is okay.', '2021-12-20 14:48:50', 'B032010342', 6),
(6, 'Ticket Accepted', 'test', '2021-12-18 17:16:04', 'S0001', 4),
(8, 'Ticket Accepted', 'We will investigate!!', '2021-12-21 10:02:37', 'S0001', 3),
(10, 'Informed Maintenance Team', 'Waiting Maintenance Team to response and fix the reported problem', '2021-12-21 10:04:24', 'S0001', 3),
(11, 'Working on It', 'Maintenance Team is working on the problem, please be patient.', '2022-01-04 15:07:38', 'M0003', 3),
(12, 'Done, feedback needed', 'Maintenance Team has fixed the problem, student please provide feedback.', '2022-01-04 15:07:41', 'M0003', 3),
(13, 'Satisfied', 'Ceiling fan is working well.', '2021-12-21 14:53:56', 'B032010342', 3),
(14, 'Closed', 'Problem is successfully fixed!', '2021-12-21 14:57:49', 'S0001', 3),
(15, 'Ticket Accepted', 'It will be take care of.', '2021-12-22 06:43:15', 'S0001', 5),
(16, 'Informed Maintenance Team', 'Waiting Maintenance Team to response and fix the reported problem', '2022-01-04 13:30:59', 'S0003', 5),
(17, 'Working on It', 'Maintenance Team is working on the problem, please be patient.', '2022-01-04 13:30:56', 'M0003', 5),
(18, 'Done, feedback needed', 'Maintenance Team has fixed the problem, student please provide feedback.', '2022-01-04 13:30:52', 'M0003', 5),
(19, 'Satisfied', 'Window is now fixed.', '2021-12-22 06:49:05', 'B032010342', 5),
(20, 'Closed', 'Problem is successfully solved.', '2021-12-22 06:50:13', 'S0001', 5),
(21, 'Ticket Submitted', 'Student submitted new service desk form.', '2022-01-05 06:26:56', 'B032010342', 7),
(22, 'Informed Maintenance Team', 'Waiting Maintenance Team to response and fix the reported problem', '2022-01-05 06:29:18', 'S0001', 7),
(23, 'Working on It', 'Maintenance Team is working on the problem, please be patient.', '2022-01-05 06:30:57', 'M0003', 7),
(24, 'Working on It', 'Maintenance Team is working on the problem, please be patient.', '2022-01-05 06:31:42', 'M0003', 7),
(25, 'Satisfied', 'The light is working fine', '2022-01-05 06:34:13', 'B032010342', 7),
(26, 'Ticket Submitted', 'Student submitted new service desk form.', '2022-01-05 13:02:51', 'B032010342', 8),
(27, 'Ticket Accepted', 'We will send a maintenance team to fix it.', '2022-01-05 13:20:19', 'S0001', 8),
(28, 'Informed Maintenance Team', 'Waiting Maintenance Team to response and fix the reported problem', '2022-01-05 13:25:25', 'S0001', 8),
(29, 'Working on It', 'Maintenance Team is working on the problem, please be patient.', '2022-01-05 13:37:41', 'M0003', 8),
(31, 'Done, feedback needed', 'Maintenance Team has fixed the problem, student please provide feedback.', '2022-01-05 13:43:47', 'M0003', 8),
(32, 'Satisfied', 'Water tap has been fix. Thank you.', '2022-01-05 13:48:09', 'B032010342', 8),
(33, 'Closed', 'The problem has been fixed.', '2022-01-05 13:56:52', 'S0001', 8),
(35, 'Ticket Submitted', 'Student submitted new service desk form.', '2022-01-10 13:24:18', 'B032010342', 10),
(36, 'Ticket Submitted', 'Student submitted new service desk form.', '2022-01-10 13:31:19', 'B032010342', 11),
(37, 'Informed Maintenance Team', 'Waiting Maintenance Team to response and fix the reported problem', '2022-01-10 13:33:24', 'S0001', 11),
(38, 'Working on It', 'Maintenance Team is working on the problem, please be patient.', '2022-01-10 13:35:12', 'M0003', 11),
(39, 'Done, feedback needed', 'Maintenance Team has fixed the problem, student please provide feedback.', '2022-01-10 13:36:01', 'M0003', 11),
(40, 'Satisfied', 'Water is now fixed.', '2022-01-10 13:37:44', 'B032010342', 11),
(41, 'Closed', 'Problem has been fix.', '2022-01-10 13:39:42', 'S0001', 11),
(42, 'Ticket Submitted', 'Student submitted new service desk form.', '2022-01-10 13:48:42', 'B032010342', 12),
(43, 'Informed Maintenance Team', 'Waiting Maintenance Team to response and fix the reported problem', '2022-01-10 13:50:23', 'S0001', 12),
(44, 'Working on It', 'Maintenance Team is working on the problem, please be patient.', '2022-01-10 13:51:31', 'M0003', 12),
(45, 'Done, feedback needed', 'Maintenance Team has fixed the problem, student please provide feedback.', '2022-01-10 13:52:14', 'M0003', 12),
(46, 'Satisfied', 'It has been fix.', '2022-01-10 13:53:26', 'B032010342', 12),
(47, 'Closed', 'Problem has been solve.', '2022-01-10 13:54:45', 'S0001', 12);

-- --------------------------------------------------------

--
-- Table structure for table `maintenance`
--

CREATE TABLE `maintenance` (
  `maintID` varchar(10) NOT NULL,
  `maintName` varchar(50) NOT NULL,
  `gender` int(1) NOT NULL,
  `maintEmail` varchar(50) NOT NULL,
  `maintTel` varchar(20) NOT NULL,
  `blockID` varchar(10) NOT NULL,
  `collegeID` varchar(10) NOT NULL,
  `profilePic` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `maintenance`
--

INSERT INTO `maintenance` (`maintID`, `maintName`, `gender`, `maintEmail`, `maintTel`, `blockID`, `collegeID`, `profilePic`) VALUES
('M0001', 'Haziq Aiman', 1, 'm0001@maintenance.utem.edu.my', '60123456789', 'J', 'S', '../../asset/default.jpg'),
('M0003', 'Faris Farhan', 1, 'm0003@maintenance.utem.edu.my', '60123456789', 'T', 'S', '../uploaded_files/profile/M0003/20220105145410_bersi.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `reservationID` int(10) NOT NULL,
  `facilityID` varchar(10) NOT NULL,
  `date` date DEFAULT NULL,
  `timeStart` time DEFAULT NULL,
  `timeEnd` time DEFAULT NULL,
  `remarks` longtext NOT NULL,
  `approveBy` varchar(10) DEFAULT NULL,
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `updationDate` timestamp NULL DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `applicant` text NOT NULL,
  `reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`reservationID`, `facilityID`, `date`, `timeStart`, `timeEnd`, `remarks`, `approveBy`, `creationDate`, `updationDate`, `status`, `applicant`, `reason`) VALUES
(1, 'S-01', '2021-12-05', '20:00:00', '22:00:00', '', 'S0001', '2021-12-03 15:40:01', '2021-12-18 06:26:23', 1, 'Arief Azfar', ''),
(2, 'S-02', '2021-12-05', '22:00:00', '23:00:00', '', 'S0001', '2021-12-03 16:25:59', '2021-12-18 06:26:27', 1, 'Arief Azfar', ''),
(3, 'S-02', '2021-12-06', '16:00:00', '18:00:00', 'Tournament organized by Sports Clubs.', 'S0001', '2021-12-03 16:34:19', '2022-01-04 17:34:47', 2, 'Arief Azfar', 'Occupied'),
(4, 'S-01', '2021-12-08', '12:00:00', '18:00:00', 'Basketball  tournament', 'S0004', '2021-12-06 10:24:53', NULL, 0, 'Arief Azfar', ''),
(5, 'L-01', '2021-12-10', '12:00:00', '15:00:00', 'For Club meeting. ', 'S0004', '2021-12-08 02:56:08', NULL, 2, 'Arief Azfar', ''),
(6, 'L-04', '2021-12-20', '22:30:00', '23:30:00', 'Hello', 'S0004', '2021-12-19 10:30:10', NULL, 0, 'Arief Azfar', ''),
(7, 'S-01', '2022-01-06', '12:00:00', '14:00:00', 'College Program.', 'S0001', '2022-01-05 06:41:36', '2022-01-05 06:47:57', 2, 'Arief Azfar', 'Occupied');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `roomID` varchar(10) NOT NULL,
  `blockID` varchar(10) NOT NULL,
  `capacity` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`roomID`, `blockID`, `capacity`) VALUES
('A-01', 'A', 2),
('A-02', 'A', 2),
('B-01', 'B', 2),
('B-02', 'B', 2),
('J-01', 'J', 2),
('J-02', 'J', 2),
('K-01', 'K', 2),
('K-02', 'K', 2),
('LK-01', 'LK', 2),
('LK-02', 'LK', 2),
('LU-01', 'LU', 2),
('LU-02', 'LU', 2),
('T-01', 'T', 2),
('T-02', 'T', 2);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staffID` varchar(10) NOT NULL,
  `staffName` varchar(50) NOT NULL,
  `gender` int(1) NOT NULL,
  `staffEmail` varchar(50) NOT NULL,
  `staffTel` varchar(20) NOT NULL,
  `blockID` varchar(10) NOT NULL,
  `collegeID` varchar(10) NOT NULL,
  `profilePic` text NOT NULL DEFAULT '../../asset/default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staffID`, `staffName`, `gender`, `staffEmail`, `staffTel`, `blockID`, `collegeID`, `profilePic`) VALUES
('S0001', 'Abu Bakar', 1, 's0001@staff.utem.edu.my', '60129670000', 'T', 'S', '../uploaded_files/profile/S0001/20220110221132_carol.jpg'),
('S0002', 'Siti Aminah', 2, 's0002@staff.utem.edu.my', '60123456789', 'LK', 'S', '../../asset/default.jpg'),
('S0003', 'Ahmad Husaini', 1, 's0003@staff.utem.edu.my', '60123456789', 'A', 'L', '../../asset/default.jpg'),
('S0004', 'Kamal', 1, 's0004@staff.utem.edu.my', '60123456789', 'T', 'S', '../../asset/default.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `matrixNo` varchar(10) NOT NULL,
  `studName` varchar(50) NOT NULL,
  `gender` int(1) NOT NULL,
  `faculty` text NOT NULL,
  `year` int(1) NOT NULL,
  `studTel` varchar(20) NOT NULL,
  `roomID` varchar(10) NOT NULL,
  `blockID` varchar(10) NOT NULL,
  `collegeID` varchar(10) NOT NULL,
  `studEmail` varchar(50) NOT NULL,
  `profilePic` text NOT NULL DEFAULT '../../asset/default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`matrixNo`, `studName`, `gender`, `faculty`, `year`, `studTel`, `roomID`, `blockID`, `collegeID`, `studEmail`, `profilePic`) VALUES
('B031920511', 'Sumaya Azad Jerin', 2, 'FTMK', 2, '601161600353', 'T-02', 'T', 'S', 'b031920511@student.utem.edu.my', '../../asset/default.jpg'),
('B032010342', 'Arief Azfar', 1, 'FTMK', 2, '60129684705', 'T-01', 'T', 'S', 'b032010342@student.utem.edu.my', '../uploaded_files/profile/B032010342/20220105202516_bersi.jpg'),
('B032010362', 'Ravindran Genesan', 1, 'FTMK', 2, '60189864035', 'T-01', 'T', 'S', 'b032010362@student.utem.edu.my', '../../asset/default.jpg'),
('B032020025', 'Carol Lim', 2, 'FTMK', 3, '60187767378', 'T-02', 'T', 'S', 'b032020025@student.utem.edu.my', '../../asset/default.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

CREATE TABLE `subcategory` (
  `scID` int(10) NOT NULL,
  `categoryID` int(10) NOT NULL,
  `scName` text NOT NULL,
  `avgFixDay` int(2) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `createdBy` varchar(10) NOT NULL,
  `updationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `updatedBy` varchar(10) NOT NULL,
  `display` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`scID`, `categoryID`, `scName`, `avgFixDay`, `creationDate`, `createdBy`, `updationDate`, `updatedBy`, `display`) VALUES
(1, 2, 'Bedroom', 2, '2021-12-04 08:31:45', 'S0001', '2021-12-04 08:54:16', '', 1),
(2, 2, 'Living Room', 3, '2021-12-04 08:31:45', 'S0001', '2021-12-04 08:54:20', '', 1),
(3, 3, 'Laundry Room', 5, '2021-12-21 09:16:05', 'S0001', NULL, '', 1),
(4, 2, 'Toilet', 2, '2022-01-05 12:52:50', 'S0001', NULL, '', 1),
(5, 2, 'WiFi', 1, '2022-01-05 12:52:50', 'S0001', NULL, '', 1),
(6, 2, 'Other', 7, '2022-01-05 12:52:50', 'S0001', NULL, '', 1),
(13, 3, 'Corridor', 3, '2022-01-05 12:57:40', 'S0001', NULL, '', 1),
(14, 3, 'Drain', 4, '2022-01-05 12:57:40', 'S0001', NULL, '', 1),
(15, 3, 'Water Dispenser', 3, '2022-01-05 12:57:40', 'S0001', NULL, '', 1),
(16, 3, 'Public Toilet', 5, '2022-01-05 12:57:40', 'S0001', NULL, '', 1),
(17, 3, 'Surau', 2, '2022-01-05 12:57:40', 'S0001', NULL, '', 1),
(18, 3, 'Other', 7, '2022-01-05 12:57:40', 'S0001', NULL, '', 1),
(19, 4, 'Fee', 1, '2022-01-05 12:59:22', 'S0001', NULL, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(5) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(32) NOT NULL,
  `accType` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `accType`) VALUES
(1, 'admin', '6f5393979d674de36c433b47b7d8908e', 0),
(2, 'B032010342', '25a72642706125c6b4a3a320e5e7a816', 1),
(3, 'S0001', '7da99e0a9e834d7f4a5e2653ef56b497', 2),
(5, 'B032020025', '2c6946beaa3c8ec05119caa0419211e4', 1),
(8, 'S0002', '7da99e0a9e834d7f4a5e2653ef56b497', 2),
(10, 'B031920511', '25a72642706125c6b4a3a320e5e7a816', 1),
(11, 'S0003', '7da99e0a9e834d7f4a5e2653ef56b497', 2),
(12, 'M0003', '10e05001f9c0462552e19efcfa0aba7e', 3),
(19, 'S0004', '7da99e0a9e834d7f4a5e2653ef56b497', 2),
(20, 'B032010362', '4b097568d31fca3704fd861d3c7e37ce', 1),
(24, 'M0001', '10e05001f9c0462552e19efcfa0aba7e', 3);

-- --------------------------------------------------------

--
-- Table structure for table `visitor`
--

CREATE TABLE `visitor` (
  `visitorID` int(10) NOT NULL,
  `name` text NOT NULL,
  `ic` varchar(15) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `reason` varchar(30) NOT NULL,
  `blockID` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `visitor`
--

INSERT INTO `visitor` (`visitorID`, `name`, `ic`, `date`, `reason`, `blockID`) VALUES
(1, 'Ahmad Husaini', '980101010101', '2021-12-18 19:07:57', 'Testing', NULL),
(2, 'Faris Farhan', '980101010101', '2021-12-20 14:09:15', 'testing 2', NULL),
(3, 'Amirul', '980101010101', '2022-01-04 18:05:20', 'Jumpa kawan.', NULL),
(4, 'Arief Azfar', '980101010101', '2022-01-05 06:55:58', 'Discussion with classmates', NULL),
(5, 'Arief Azfar', '980101010101', '2022-01-10 14:07:45', 'Ambil anak.', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`activityID`),
  ADD KEY `acsID_FK` (`approveBy`),
  ADD KEY `fID_FK` (`venue`);

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`annID`),
  ADD KEY `annBID_FK` (`blockID`),
  ADD KEY `asID_FK` (`approveBy`);

--
-- Indexes for table `block`
--
ALTER TABLE `block`
  ADD PRIMARY KEY (`blockID`),
  ADD KEY `bcollege_FK` (`collegeID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`categoryID`);

--
-- Indexes for table `college`
--
ALTER TABLE `college`
  ADD PRIMARY KEY (`collegeID`);

--
-- Indexes for table `facility`
--
ALTER TABLE `facility`
  ADD PRIMARY KEY (`facilityID`),
  ADD KEY `fcollege_FK` (`collegeID`);

--
-- Indexes for table `fileuploaded`
--
ALTER TABLE `fileuploaded`
  ADD PRIMARY KEY (`fuID`),
  ADD KEY `aID_FK` (`aID`),
  ADD KEY `fuannID_FK` (`annID`),
  ADD KEY `fuhdID_FK` (`hdID`),
  ADD KEY `fuhdtID_FK` (`hdtID`);

--
-- Indexes for table `helpdesk`
--
ALTER TABLE `helpdesk`
  ADD PRIMARY KEY (`hdID`),
  ADD KEY `hsID_FK` (`matrixNo`),
  ADD KEY `sID_FK` (`category`),
  ADD KEY `scID_FK` (`subcategory`);

--
-- Indexes for table `helpdesktracker`
--
ALTER TABLE `helpdesktracker`
  ADD PRIMARY KEY (`hdtID`),
  ADD KEY `thdID_FK` (`hdID`);

--
-- Indexes for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD PRIMARY KEY (`maintID`),
  ADD KEY `mblock_FK` (`blockID`),
  ADD KEY `mcollege_FK` (`collegeID`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`reservationID`),
  ADD KEY `rsID_FK` (`approveBy`),
  ADD KEY `rfacility_FK` (`facilityID`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`roomID`),
  ADD KEY `rblock_FK` (`blockID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staffID`),
  ADD KEY `block_FK` (`blockID`),
  ADD KEY `sCollege_FK` (`collegeID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`matrixNo`),
  ADD KEY `college_FK` (`collegeID`),
  ADD KEY `room_FK` (`roomID`),
  ADD KEY `sBlock_FK` (`blockID`);

--
-- Indexes for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD PRIMARY KEY (`scID`),
  ADD KEY `scategory_FK` (`categoryID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visitor`
--
ALTER TABLE `visitor`
  ADD PRIMARY KEY (`visitorID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `activityID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `annID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `categoryID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `fileuploaded`
--
ALTER TABLE `fileuploaded`
  MODIFY `fuID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `helpdesk`
--
ALTER TABLE `helpdesk`
  MODIFY `hdID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `helpdesktracker`
--
ALTER TABLE `helpdesktracker`
  MODIFY `hdtID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `reservationID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `scID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `visitor`
--
ALTER TABLE `visitor`
  MODIFY `visitorID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity`
--
ALTER TABLE `activity`
  ADD CONSTRAINT `acsID_FK` FOREIGN KEY (`approveBy`) REFERENCES `staff` (`staffID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fID_FK` FOREIGN KEY (`venue`) REFERENCES `facility` (`facilityID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `announcement`
--
ALTER TABLE `announcement`
  ADD CONSTRAINT `annBID_FK` FOREIGN KEY (`blockID`) REFERENCES `block` (`blockID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asID_FK` FOREIGN KEY (`approveBy`) REFERENCES `staff` (`staffID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `block`
--
ALTER TABLE `block`
  ADD CONSTRAINT `bcollege_FK` FOREIGN KEY (`collegeID`) REFERENCES `college` (`collegeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `facility`
--
ALTER TABLE `facility`
  ADD CONSTRAINT `fcollege_FK` FOREIGN KEY (`collegeID`) REFERENCES `college` (`collegeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `fileuploaded`
--
ALTER TABLE `fileuploaded`
  ADD CONSTRAINT `aID_FK` FOREIGN KEY (`aID`) REFERENCES `activity` (`activityID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fuannID_FK` FOREIGN KEY (`annID`) REFERENCES `announcement` (`annID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fuhdID_FK` FOREIGN KEY (`hdID`) REFERENCES `helpdesk` (`hdID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fuhdtID_FK` FOREIGN KEY (`hdtID`) REFERENCES `helpdesktracker` (`hdtID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `helpdesk`
--
ALTER TABLE `helpdesk`
  ADD CONSTRAINT `hsID_FK` FOREIGN KEY (`matrixNo`) REFERENCES `student` (`matrixNo`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `sID_FK` FOREIGN KEY (`category`) REFERENCES `category` (`categoryID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `scID_FK` FOREIGN KEY (`subcategory`) REFERENCES `subcategory` (`scID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `helpdesktracker`
--
ALTER TABLE `helpdesktracker`
  ADD CONSTRAINT `thdID_FK` FOREIGN KEY (`hdID`) REFERENCES `helpdesk` (`hdID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD CONSTRAINT `mblock_FK` FOREIGN KEY (`blockID`) REFERENCES `block` (`blockID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mcollege_FK` FOREIGN KEY (`collegeID`) REFERENCES `college` (`collegeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `rfacility_FK` FOREIGN KEY (`facilityID`) REFERENCES `facility` (`facilityID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `rsID_FK` FOREIGN KEY (`approveBy`) REFERENCES `staff` (`staffID`);

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `rblock_FK` FOREIGN KEY (`blockID`) REFERENCES `block` (`blockID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `block_FK` FOREIGN KEY (`blockID`) REFERENCES `block` (`blockID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sCollege_FK` FOREIGN KEY (`collegeID`) REFERENCES `college` (`collegeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `college_FK` FOREIGN KEY (`collegeID`) REFERENCES `college` (`collegeID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `room_FK` FOREIGN KEY (`roomID`) REFERENCES `room` (`roomID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sBlock_FK` FOREIGN KEY (`blockID`) REFERENCES `block` (`blockID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD CONSTRAINT `scategory_FK` FOREIGN KEY (`categoryID`) REFERENCES `category` (`categoryID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
