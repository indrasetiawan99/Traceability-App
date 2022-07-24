-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2021 at 09:02 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `traceability_qrcode`
--

-- --------------------------------------------------------

--
-- Table structure for table `dandory`
--

CREATE TABLE `dandory` (
  `id` int(11) NOT NULL,
  `total_time` int(11) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dandory`
--

INSERT INTO `dandory` (`id`, `total_time`, `datetime`) VALUES
(1, 30, '2021-05-20 10:31:55');

-- --------------------------------------------------------

--
-- Table structure for table `datapart`
--

CREATE TABLE `datapart` (
  `id` bigint(20) NOT NULL,
  `code` varchar(255) NOT NULL,
  `uniq_number` varchar(255) NOT NULL,
  `nik` varchar(255) NOT NULL,
  `op_name` varchar(255) NOT NULL,
  `part_name` varchar(255) NOT NULL,
  `pn_api` varchar(255) NOT NULL,
  `pn_cust` varchar(255) NOT NULL,
  `job_no` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `sku_maris` varchar(255) NOT NULL,
  `packaging` int(11) NOT NULL,
  `date` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `date_time` varchar(255) NOT NULL,
  `date_time2` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `datapart`
--

INSERT INTO `datapart` (`id`, `code`, `uniq_number`, `nik`, `op_name`, `part_name`, `pn_api`, `pn_cust`, `job_no`, `address`, `sku_maris`, `packaging`, `date`, `time`, `date_time`, `date_time2`) VALUES
(1, '21050001_30-001-110 SC_API_10_004242_M079_200521_07.33.58', '21050001', 'M079', 'Fajar Setiaji Achmari', 'BASE RH 441-D64G-30-001-110 SC', 'JI4MRR-GBAS97BK02', '30-001-110 SC', 'NT-0989', 'ADM 16-4', '004242', 10, '20210520', '07:33:58', '20 May 2021-07:33:58', '20052021073358');

-- --------------------------------------------------------

--
-- Table structure for table `downtime`
--

CREATE TABLE `downtime` (
  `id` bigint(20) NOT NULL,
  `category` varchar(255) NOT NULL,
  `user_start` varchar(255) NOT NULL,
  `start_downtime` datetime NOT NULL,
  `user_end` varchar(255) DEFAULT NULL,
  `end_downtime` datetime DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `total_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `downtime`
--

INSERT INTO `downtime` (`id`, `category`, `user_start`, `start_downtime`, `user_end`, `end_downtime`, `description`, `total_time`) VALUES
(1, 'Robot', 'M079', '2021-05-20 10:32:25', 'M091', '2021-05-20 10:48:45', 'Error', 980),
(2, 'Box', 'M079', '2021-05-20 10:49:18', 'M180', '2021-05-20 11:20:47', 'Habis', 1889),
(3, 'Lain-lain', 'M079', '2021-05-20 15:24:30', 'M180', '2021-05-20 15:39:44', 'Tidak diketahui', 914),
(4, 'Dandory', 'M079', '2021-05-20 15:50:51', 'M091', '2021-05-20 15:54:23', 'aaa', 212),
(5, 'Pemanasan', 'M091', '2021-05-21 08:14:47', 'M079', '2021-05-21 08:15:04', 'aaa', 17),
(6, 'Dandory', 'M091', '2021-05-21 08:16:34', 'M079', '2021-05-21 08:16:50', 'bbb', 16),
(7, 'Lain-lain', 'M091', '2021-05-21 08:17:22', 'M180', '2021-05-21 08:17:42', 'ccc', 20),
(8, 'Robot', 'M091', '2021-05-21 08:18:16', 'M180', '2021-05-21 08:18:30', 'ddd', 14),
(9, 'Material', 'M079', '2021-05-21 10:08:04', 'M180', '2021-05-21 10:47:15', 'Habis', 2351);

-- --------------------------------------------------------

--
-- Table structure for table `jig_and_nut`
--

CREATE TABLE `jig_and_nut` (
  `id` int(11) NOT NULL,
  `jig` varchar(255) NOT NULL,
  `nut` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jig_and_nut`
--

INSERT INTO `jig_and_nut` (`id`, `jig`, `nut`) VALUES
(1, 'D01N', 'D01N');

-- --------------------------------------------------------

--
-- Table structure for table `machine_status`
--

CREATE TABLE `machine_status` (
  `id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `action` varchar(255) NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `machine_status`
--

INSERT INTO `machine_status` (`id`, `status`, `action`) VALUES
(1, 1, 'No');

-- --------------------------------------------------------

--
-- Table structure for table `master_breaktime`
--

CREATE TABLE `master_breaktime` (
  `id` int(11) NOT NULL,
  `break_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `s1_break1_from` time NOT NULL,
  `s1_break1_to` time NOT NULL,
  `s1_break2_from` time NOT NULL,
  `s1_break2_to` time NOT NULL,
  `s2_break1_from` time NOT NULL,
  `s2_break1_to` time NOT NULL,
  `s2_break2_from` time NOT NULL,
  `s2_break2_to` time NOT NULL,
  `s3_break1_from` time NOT NULL,
  `s3_break1_to` time NOT NULL,
  `s3_break2_from` time NOT NULL,
  `s3_break2_to` time NOT NULL,
  `s3_break_OT_from` time NOT NULL,
  `s3_break_OT_to` time NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_breaktime`
--

INSERT INTO `master_breaktime` (`id`, `break_name`, `description`, `s1_break1_from`, `s1_break1_to`, `s1_break2_from`, `s1_break2_to`, `s2_break1_from`, `s2_break1_to`, `s2_break2_from`, `s2_break2_to`, `s3_break1_from`, `s3_break1_to`, `s3_break2_from`, `s3_break2_to`, `s3_break_OT_from`, `s3_break_OT_to`, `status`) VALUES
(1, 'Monday', 'Normal', '08:30:00', '08:40:00', '12:00:00', '12:50:00', '16:00:00', '16:10:00', '18:10:00', '19:00:00', '01:00:00', '01:40:00', '04:40:00', '05:00:00', '22:00:00', '22:10:00', 'Active'),
(2, 'Tuesday', 'Normal', '08:30:00', '08:40:00', '12:00:00', '12:50:00', '16:00:00', '16:10:00', '18:10:00', '19:00:00', '01:00:00', '01:40:00', '04:40:00', '05:00:00', '22:00:00', '22:10:00', 'Active'),
(3, 'Wednesday', 'Normal', '08:30:00', '08:40:00', '12:00:00', '12:50:00', '16:00:00', '16:10:00', '18:10:00', '19:00:00', '01:00:00', '01:40:00', '04:40:00', '05:00:00', '22:00:00', '22:10:00', 'Active'),
(4, 'Thursday', 'Normal', '08:30:00', '08:40:00', '12:00:00', '12:50:00', '16:00:00', '16:10:00', '18:10:00', '19:00:00', '01:00:00', '01:40:00', '04:40:00', '05:00:00', '22:00:00', '22:10:00', 'Active'),
(5, 'Friday', 'Normal', '08:30:00', '08:40:00', '11:40:00', '13:00:00', '16:00:00', '16:10:00', '18:10:00', '19:00:00', '01:00:00', '01:40:00', '04:40:00', '05:00:00', '22:00:00', '22:10:00', 'Active'),
(6, 'Saturday', 'Normal', '08:30:00', '08:40:00', '12:00:00', '12:50:00', '16:00:00', '16:10:00', '18:10:00', '19:00:00', '01:00:00', '01:40:00', '04:40:00', '05:00:00', '22:00:00', '22:10:00', 'Active'),
(7, 'Sunday', 'Normal', '08:30:00', '08:40:00', '12:00:00', '12:50:00', '16:00:00', '16:10:00', '18:10:00', '19:00:00', '01:00:00', '01:40:00', '04:40:00', '05:00:00', '22:00:00', '22:10:00', 'Active'),
(8, 'Monday', 'Puasa', '08:30:00', '08:40:00', '12:00:00', '12:50:00', '16:00:00', '16:10:00', '17:50:00', '18:40:00', '01:00:00', '01:10:00', '04:00:00', '04:50:00', '22:00:00', '22:10:00', 'Inactive'),
(9, 'Tuesday', 'Puasa', '08:30:00', '08:40:00', '12:00:00', '12:50:00', '16:00:00', '16:10:00', '17:50:00', '18:40:00', '01:00:00', '01:10:00', '04:00:00', '04:50:00', '22:00:00', '22:10:00', 'Inactive'),
(10, 'Wednesday', 'Puasa', '08:30:00', '08:40:00', '12:00:00', '12:50:00', '16:00:00', '16:10:00', '17:50:00', '18:40:00', '01:00:00', '01:10:00', '04:00:00', '04:50:00', '22:00:00', '22:10:00', 'Inactive'),
(11, 'Thursday', 'Puasa', '08:30:00', '08:40:00', '12:00:00', '12:50:00', '16:00:00', '16:10:00', '17:50:00', '18:40:00', '01:00:00', '01:10:00', '04:00:00', '04:50:00', '22:00:00', '22:10:00', 'Inactive'),
(12, 'Friday', 'Puasa', '08:30:00', '08:40:00', '11:40:00', '13:00:00', '16:00:00', '16:10:00', '17:50:00', '18:40:00', '01:00:00', '01:10:00', '04:00:00', '04:50:00', '22:00:00', '22:10:00', 'Inactive'),
(13, 'Saturday', 'Puasa', '08:30:00', '08:40:00', '12:00:00', '12:50:00', '16:00:00', '16:10:00', '17:50:00', '18:40:00', '01:00:00', '01:10:00', '04:00:00', '04:50:00', '22:00:00', '22:10:00', 'Inactive'),
(14, 'Sunday', 'Puasa', '08:30:00', '08:40:00', '12:00:00', '12:50:00', '16:00:00', '16:10:00', '17:50:00', '18:40:00', '01:00:00', '01:10:00', '04:00:00', '04:50:00', '22:00:00', '22:10:00', 'Inactive');

-- --------------------------------------------------------

--
-- Table structure for table `master_downtime`
--

CREATE TABLE `master_downtime` (
  `id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_downtime`
--

INSERT INTO `master_downtime` (`id`, `category`) VALUES
(3, 'Box'),
(14, 'Brifing'),
(18, 'Cleaning Mold'),
(16, 'Dandory'),
(4, 'Kereta'),
(5, 'Komponen'),
(11, 'Kuras Barel'),
(17, 'Kuras Manifold'),
(12, 'Man Power'),
(7, 'Material'),
(2, 'Mesin'),
(1, 'Mold'),
(8, 'Pemanasan'),
(9, 'Robot'),
(19, 'Setting Awal'),
(15, 'Setting Mesin'),
(13, 'SR'),
(6, 'STD Kualitas'),
(10, 'Trial Robot');

-- --------------------------------------------------------

--
-- Table structure for table `master_product`
--

CREATE TABLE `master_product` (
  `id` int(11) NOT NULL,
  `line_number` varchar(255) NOT NULL,
  `sku_maris` varchar(255) NOT NULL,
  `part_name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `pn_api` varchar(255) NOT NULL,
  `pn_cust` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `customer` varchar(255) NOT NULL,
  `job_no` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `time_production` int(11) NOT NULL,
  `packaging` int(11) NOT NULL,
  `jig` varchar(255) NOT NULL,
  `nut` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_product`
--

INSERT INTO `master_product` (`id`, `line_number`, `sku_maris`, `part_name`, `position`, `pn_api`, `pn_cust`, `type`, `customer`, `job_no`, `address`, `time_production`, `packaging`, `jig`, `nut`) VALUES
(1, 'EMBEDDING', '004240', 'BASE LH 441-D01N-30-004-111', 'Left', 'JI4MRR-GBAS01BK01', '30-004-111', 'D01N', 'ASKI', 'NT-0986', 'ADM 16-1', 60, 10, 'D01N', 'D01N'),
(2, 'EMBEDDING', '004239', 'BASE RH 441-D01N-30-004-110', 'Right', 'JI4MRR-GBAS01BK02', '30-004-110', 'D01N', 'ASKI', 'NT-0987', 'ADM 16-2', 60, 10, 'D01N', 'D01N'),
(3, 'EMBEDDING', '004243', 'BASE LH 441-D64G-30-001-111 SC', 'Left', 'JI4MRR-GBAS97BK01', '30-001-111 SC', 'D64G', 'ASKI', 'NT-0988', 'ADM 16-3', 60, 10, 'D64G', 'D64G'),
(4, 'EMBEDDING', '004242', 'BASE RH 441-D64G-30-001-110 SC', 'Right', 'JI4MRR-GBAS97BK02', '30-001-110 SC', 'D64G', 'ASKI', 'NT-0989', 'ADM 16-4', 60, 10, 'D64G', 'D64G'),
(5, 'EMBEDDING', '004250', 'SUB ASSY BASE STAY LHD LH 34231-S1900', 'Left', 'JI4MRR-GSAB13BK01', '34231-S1900', 'D13', 'ASKI', 'NT-0990', 'ADM 16-5', 60, 10, 'D13/D14', 'D13/D14'),
(6, 'EMBEDDING', '004249', 'SUB ASSY BASE STAY LHD RH 34232-S1800', 'Right', 'JI4MRR-GSAB13BK02', '34232-S1800', 'D13', 'ASKI', 'NT-0991', 'ADM 16-6', 60, 10, 'D13/D14', 'D13/D14'),
(7, 'EMBEDDING', '004246', 'SUB ASSY BASE STAY RHD LH 34231-S1700', 'Left', 'JI4MRR-GSAB14BK01', '34231-S1700', 'D14', 'ASKI', 'NT-0992', 'ADM 16-7', 60, 10, 'D13/D14', 'D13/D14'),
(8, 'EMBEDDING', '004245', 'SUB ASSY BASE STAY RHD RH 34232-S1600', 'Right', 'JI4MRR-GSAB14BK02', '34232-S1600', 'D14', 'ASKI', 'NT-0993', 'ADM 16-8', 60, 10, 'D13/D14', 'D13/D14');

-- --------------------------------------------------------

--
-- Table structure for table `master_rejection`
--

CREATE TABLE `master_rejection` (
  `id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_rejection`
--

INSERT INTO `master_rejection` (`id`, `category`) VALUES
(9, 'Bending'),
(14, 'Blackspot'),
(7, 'Buble'),
(11, 'Burn Mark'),
(20, 'Burry'),
(21, 'Check Of'),
(22, 'Colour (Visual)'),
(1, 'Crack'),
(2, 'Dimensi'),
(3, 'Ejector Mark'),
(8, 'Flow Mark'),
(15, 'Gloss'),
(18, 'Jetting'),
(6, 'Kontaminasi'),
(17, 'Minyak'),
(16, 'Mutih'),
(19, 'Over Cut'),
(12, 'Scratch'),
(23, 'Setting'),
(4, 'Short Shoot'),
(13, 'Silver'),
(10, 'Sink Mark'),
(5, 'Wide Line');

-- --------------------------------------------------------

--
-- Table structure for table `master_shift`
--

CREATE TABLE `master_shift` (
  `id` int(11) NOT NULL,
  `shift_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_shift`
--

INSERT INTO `master_shift` (`id`, `shift_name`, `description`, `start_time`, `end_time`, `status`) VALUES
(1, 'Shift 1', 'Normal', '06:00:00', '17:59:59', 'Active'),
(2, 'Shift 3', 'Normal', '18:00:00', '05:59:59', 'Active'),
(3, 'Shift 1', 'Puasa', '06:00:00', '17:59:59', 'Inactive'),
(4, 'Shift 3', 'Puasa', '18:00:00', '05:59:59', 'Inactive');

-- --------------------------------------------------------

--
-- Table structure for table `master_user`
--

CREATE TABLE `master_user` (
  `id` int(11) NOT NULL,
  `nik` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rfid_tag` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `nospace_name` varchar(255) NOT NULL,
  `usergroup` varchar(255) NOT NULL,
  `op_skill` int(11) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_user`
--

INSERT INTO `master_user` (`id`, `nik`, `username`, `password`, `rfid_tag`, `name`, `full_name`, `nospace_name`, `usergroup`, `op_skill`, `last_login`, `status`, `created_at`, `updated_at`) VALUES
(1, '0268', '0268_Ropik_Nur_Faizal', 'ropik0268', '01175192153', 'Ropik', 'Ropik Nur Faizal', 'Ropik_Nur_Faizal', 'Leader', 0, '2021-05-21 10:07:33', 'Active', '2021-02-28 06:11:51', NULL),
(2, 'M091', 'M091_Alan_Martiansyah', 'alan220302', '4914878178', 'Alan', 'Alan Martiansyah', 'Alan_Martiansyah', 'Operator', 80, '2021-04-27 09:20:43', 'Active', '2021-02-28 06:11:34', NULL),
(3, '0042', '0042_Heru_Nuryadi', 'heru0042', '', 'Heru', 'Heru Nuryadi', 'Heru_Nuryadi', 'Operator', 70, '2021-04-14 13:19:20', 'Active', '2021-02-28 06:12:06', NULL),
(4, 'M218', 'M218_Ibnu_Nugraha', 'ibnu2222', '21129193153', 'Ibnu', 'Ibnu Nugraha', 'Ibnu_Nugraha', 'Operator', 80, NULL, 'Active', '2021-04-07 11:10:04', NULL),
(5, 'M180', 'M180_Kirwan', '98', '3178192153', 'Kirwan', 'Kirwan', 'Kirwan', 'Operator', 80, NULL, 'Active', '2021-04-07 11:10:04', NULL),
(6, 'M079', 'M079_Fajar_Setiaji_Achmari', 'M079_Fajar_Setiaji_Achmari', '322200153', 'Fajar', 'Fajar Setiaji Achmari', 'Fajar_Setiaji_Achmari', 'Operator', 80, '2021-05-03 07:32:10', 'Active', '2021-04-07 13:04:13', NULL),
(7, '0011', '0011_Agustinus_Progo_Sutrisno', 'progo0011', '53123205153', 'Progo', 'Agustinus Progo Sutrisno', 'Agustinus_Progo_Sutrisno', 'Manager', 0, '2021-04-23 07:50:40', 'Active', '2021-04-11 20:44:39', NULL),
(8, '0054', '0054_Castim_Bin_Datim', 'Castim_Bin_Datim_0054', '4982152152', 'Castim', 'Castim Bin Datim', 'Castim_Bin_Datim', 'Leader', 0, '2021-05-21 07:42:04', 'Active', '2021-05-20 13:01:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `part_production`
--

CREATE TABLE `part_production` (
  `id` bigint(20) NOT NULL,
  `part_name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `op_name` varchar(255) NOT NULL,
  `seq1_status` varchar(255) DEFAULT NULL,
  `seq2_status` varchar(255) DEFAULT NULL,
  `seq3_status` varchar(255) DEFAULT NULL,
  `seq4_status` varchar(255) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  `qrcode` varchar(255) DEFAULT NULL,
  `hasil_scanning` varchar(255) DEFAULT NULL,
  `datapart` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `part_production`
--

INSERT INTO `part_production` (`id`, `part_name`, `position`, `op_name`, `seq1_status`, `seq2_status`, `seq3_status`, `seq4_status`, `date_time`, `qrcode`, `hasil_scanning`, `datapart`, `status`) VALUES
(1, 'BASE RH 441-D64G-30-001-110 SC', 'Right', 'Fajar Setiaji Achmari', 'OK', 'OK', 'OK', 'OK', '2021-05-20 07:23:54', '210500043_30-001-110 SC_API_10_M079_200521_07.23.54', '210500043_30-001-110 SC_API_10_M079_200521_07.23.54', '21050001_30-001-110 SC_API_10_004242_M079_200521_07.33.58', 'complete'),
(2, 'BASE RH 441-D64G-30-001-110 SC', 'Right', 'Fajar Setiaji Achmari', 'OK', 'OK', 'OK', 'OK', '2021-05-20 07:23:55', '210500044_30-001-110 SC_API_10_M079_200521_07.23.55', '210500044_30-001-110 SC_API_10_M079_200521_07.23.55', '21050001_30-001-110 SC_API_10_004242_M079_200521_07.33.58', 'complete'),
(3, 'BASE RH 441-D64G-30-001-110 SC', 'Right', 'Fajar Setiaji Achmari', 'OK', 'OK', 'OK', 'OK', '2021-05-20 07:23:58', '210500045_30-001-110 SC_API_10_M079_200521_07.23.58', '210500045_30-001-110 SC_API_10_M079_200521_07.23.58', '21050001_30-001-110 SC_API_10_004242_M079_200521_07.33.58', 'complete'),
(4, 'BASE RH 441-D64G-30-001-110 SC', 'Right', 'Fajar Setiaji Achmari', 'OK', 'OK', 'OK', 'OK', '2021-05-20 07:23:59', '210500046_30-001-110 SC_API_10_M079_200521_07.23.59', '210500046_30-001-110 SC_API_10_M079_200521_07.23.59', '21050001_30-001-110 SC_API_10_004242_M079_200521_07.33.58', 'complete'),
(5, 'BASE RH 441-D64G-30-001-110 SC', 'Right', 'Fajar Setiaji Achmari', 'OK', 'OK', 'OK', 'OK', '2021-05-20 07:24:00', '210500047_30-001-110 SC_API_10_M079_200521_07.24.00', '210500047_30-001-110 SC_API_10_M079_200521_07.24.00', '21050001_30-001-110 SC_API_10_004242_M079_200521_07.33.58', 'complete'),
(6, 'BASE RH 441-D64G-30-001-110 SC', 'Right', 'Fajar Setiaji Achmari', 'OK', 'OK', 'OK', 'OK', '2021-05-20 07:24:02', '210500048_30-001-110 SC_API_10_M079_200521_07.24.02', '210500048_30-001-110 SC_API_10_M079_200521_07.24.02', '21050001_30-001-110 SC_API_10_004242_M079_200521_07.33.58', 'complete'),
(7, 'BASE RH 441-D64G-30-001-110 SC', 'Right', 'Fajar Setiaji Achmari', 'OK', 'OK', 'OK', 'OK', '2021-05-20 07:24:03', '210500049_30-001-110 SC_API_10_M079_200521_07.24.03', '210500049_30-001-110 SC_API_10_M079_200521_07.24.03', '21050001_30-001-110 SC_API_10_004242_M079_200521_07.33.58', 'complete'),
(8, 'BASE RH 441-D64G-30-001-110 SC', 'Right', 'Fajar Setiaji Achmari', 'OK', 'OK', 'OK', 'OK', '2021-05-20 07:24:05', '210500050_30-001-110 SC_API_10_M079_200521_07.24.05', '210500050_30-001-110 SC_API_10_M079_200521_07.24.05', '21050001_30-001-110 SC_API_10_004242_M079_200521_07.33.58', 'complete'),
(9, 'BASE RH 441-D64G-30-001-110 SC', 'Right', 'Fajar Setiaji Achmari', 'OK', 'OK', 'OK', 'OK', '2021-05-20 07:24:06', '210500051_30-001-110 SC_API_10_M079_200521_07.24.06', '210500051_30-001-110 SC_API_10_M079_200521_07.24.06', '21050001_30-001-110 SC_API_10_004242_M079_200521_07.33.58', 'complete'),
(10, 'BASE RH 441-D64G-30-001-110 SC', 'Right', 'Fajar Setiaji Achmari', 'OK', 'OK', 'OK', 'OK', '2021-05-20 07:24:07', '210500052_30-001-110 SC_API_10_M079_200521_07.24.07', '210500052_30-001-110 SC_API_10_M079_200521_07.24.07', '21050001_30-001-110 SC_API_10_004242_M079_200521_07.33.58', 'complete'),
(19, 'BASE LH 441-D64G-30-001-111 SC', 'Left', 'Fajar Setiaji Achmari', 'OK', 'OK', 'OK', 'NG', '2021-05-20 07:34:44', '210500061_30-001-111 SC_API_10_M079_200521_07.34.44', NULL, NULL, 'reject'),
(20, 'BASE LH 441-D64G-30-001-111 SC', 'Left', 'Fajar Setiaji Achmari', 'OK', 'OK', 'OK', 'NG', '2021-05-20 07:34:45', '210500062_30-001-111 SC_API_10_M079_200521_07.34.45', NULL, NULL, 'reject'),
(26, 'BASE RH 441-D01N-30-004-110', 'Right', 'Alan Martiansyah', 'OK', 'OK', 'OK', 'NG', '2021-05-21 10:54:06', '210500068_30-004-110_API_10_M091_210521_10.54.06', NULL, NULL, 'reject'),
(27, 'BASE RH 441-D01N-30-004-110', 'Right', 'Alan Martiansyah', 'OK', 'OK', 'OK', 'NG', '2021-05-21 10:54:12', '210500069_30-004-110_API_10_M091_210521_10.54.12', NULL, NULL, 'reject'),
(28, 'BASE RH 441-D01N-30-004-110', 'Right', 'Alan Martiansyah', 'OK', 'OK', 'OK', 'NG', '2021-05-21 10:54:14', '210500070_30-004-110_API_10_M091_210521_10.54.14', NULL, NULL, 'reject'),
(29, 'BASE RH 441-D01N-30-004-110', 'Right', 'Alan Martiansyah', 'OK', 'OK', 'OK', 'NG', '2021-05-21 10:54:15', '210500071_30-004-110_API_10_M091_210521_10.54.15', NULL, NULL, 'reject'),
(30, 'BASE RH 441-D01N-30-004-110', 'Right', 'Alan Martiansyah', 'OK', 'OK', 'OK', 'NG', '2021-05-21 10:54:16', '210500072_30-004-110_API_10_M091_210521_10.54.16', NULL, NULL, 'reject');

-- --------------------------------------------------------

--
-- Table structure for table `recapitulation`
--

CREATE TABLE `recapitulation` (
  `id` int(11) NOT NULL,
  `part_name` varchar(255) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `target` int(11) NOT NULL,
  `cum_target` int(11) DEFAULT 0,
  `cum_actual` int(11) DEFAULT 0,
  `availability` int(11) DEFAULT 0,
  `performance` int(11) DEFAULT 0,
  `efficiency` int(11) DEFAULT 0,
  `oee` int(11) DEFAULT 0,
  `rejection` int(11) DEFAULT 0,
  `dandory` int(11) DEFAULT 0,
  `downtime` int(11) DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'On Process',
  `date_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `recapitulation`
--

INSERT INTO `recapitulation` (`id`, `part_name`, `start_time`, `end_time`, `target`, `cum_target`, `cum_actual`, `availability`, `performance`, `efficiency`, `oee`, `rejection`, `dandory`, `downtime`, `status`, `date_time`) VALUES
(1, 'BASE LH 441-D64G-30-001-111 SC', '2021-05-20 06:00:00', '2021-05-20 18:00:00', 500, 500, 0, 100, 86, 0, 1, 2, 30, 3995, 'Finish', '2021-05-20 07:21:06'),
(2, 'BASE RH 441-D64G-30-001-110 SC', '2021-05-20 06:00:00', '2021-05-20 18:00:00', 500, 500, 10, 100, 86, 2, 1, 0, 30, 3995, 'Finish', '2021-05-20 07:21:20'),
(3, 'SUB ASSY BASE STAY LHD LH 34231-S1900', '2021-05-21 06:00:00', '2021-05-21 16:00:00', 300, 130, 0, 100, 100, 0, 0, 0, 0, 0, 'Finish', '2021-05-21 07:42:43'),
(4, 'SUB ASSY BASE STAY LHD RH 34232-S1800', '2021-05-21 06:00:00', '2021-05-21 16:00:00', 300, 130, 0, 100, 100, 0, 0, 0, 0, 0, 'Finish', '2021-05-21 07:42:58'),
(5, 'BASE LH 441-D01N-30-004-111', '2021-05-21 08:00:00', '2021-05-21 12:00:00', 250, 216, 0, 100, 94, 0, 0, 0, 0, 2418, 'Finish', '2021-05-21 08:13:34'),
(6, 'BASE RH 441-D01N-30-004-110', '2021-05-21 08:00:00', '2021-05-21 12:00:00', 250, 216, 0, 100, 94, 0, 0, 5, 0, 2418, 'Finish', '2021-05-21 08:13:50'),
(7, 'SUB ASSY BASE STAY RHD LH 34231-S1700', '2021-05-21 13:00:00', '2021-05-21 16:30:00', 300, 62, 0, 100, 95, 0, 0, 0, 0, 2418, 'On Process', '2021-05-21 12:59:33'),
(8, 'SUB ASSY BASE STAY RHD RH 34232-S1600', '2021-05-21 13:00:00', '2021-05-21 16:30:00', 300, 62, 0, 100, 95, 0, 0, 0, 0, 2418, 'On Process', '2021-05-21 12:59:58');

-- --------------------------------------------------------

--
-- Table structure for table `rejection`
--

CREATE TABLE `rejection` (
  `id` int(11) NOT NULL,
  `part_name` varchar(255) NOT NULL,
  `qrcode` varchar(255) NOT NULL,
  `crack` varchar(5) NOT NULL DEFAULT 'No',
  `dimensi` varchar(5) NOT NULL DEFAULT 'No',
  `ejector_mark` varchar(5) NOT NULL DEFAULT 'No',
  `short_shoot` varchar(5) NOT NULL DEFAULT 'No',
  `wide_line` varchar(5) NOT NULL DEFAULT 'No',
  `kontaminasi` varchar(5) NOT NULL DEFAULT 'No',
  `buble` varchar(5) NOT NULL DEFAULT 'No',
  `flow_mark` varchar(5) NOT NULL DEFAULT 'No',
  `bending` varchar(5) NOT NULL DEFAULT 'No',
  `sink_mark` varchar(5) NOT NULL DEFAULT 'No',
  `burn_mark` varchar(5) NOT NULL DEFAULT 'No',
  `scratch` varchar(5) NOT NULL DEFAULT 'No',
  `silver` varchar(5) NOT NULL DEFAULT 'No',
  `blackspot` varchar(5) NOT NULL DEFAULT 'No',
  `gloss` varchar(5) NOT NULL DEFAULT 'No',
  `mutih` varchar(5) NOT NULL DEFAULT 'No',
  `minyak` varchar(5) NOT NULL DEFAULT 'No',
  `jetting` varchar(5) NOT NULL DEFAULT 'No',
  `over_cut` varchar(5) NOT NULL DEFAULT 'No',
  `burry` varchar(5) NOT NULL DEFAULT 'No',
  `check_of` varchar(5) NOT NULL DEFAULT 'No',
  `colour` varchar(5) NOT NULL DEFAULT 'No',
  `setting` varchar(5) NOT NULL DEFAULT 'No',
  `lain_lain` varchar(255) DEFAULT NULL,
  `date_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rejection`
--

INSERT INTO `rejection` (`id`, `part_name`, `qrcode`, `crack`, `dimensi`, `ejector_mark`, `short_shoot`, `wide_line`, `kontaminasi`, `buble`, `flow_mark`, `bending`, `sink_mark`, `burn_mark`, `scratch`, `silver`, `blackspot`, `gloss`, `mutih`, `minyak`, `jetting`, `over_cut`, `burry`, `check_of`, `colour`, `setting`, `lain_lain`, `date_time`) VALUES
(1, 'BASE LH 441-D64G-30-001-111 SC', '210500062_30-001-111 SC_API_10_M079_200521_07.34.45', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'Yes', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'Yes', NULL, '2021-05-20 10:11:15'),
(2, 'BASE LH 441-D64G-30-001-111 SC', '210500061_30-001-111 SC_API_10_M079_200521_07.34.44', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'Lain-lain', '2021-05-20 11:25:18'),
(3, 'BASE RH 441-D01N-30-004-110', '210500072_30-004-110_API_10_M091_210521_10.54.16', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'Lain-lain', '2021-05-21 10:54:27'),
(4, 'BASE RH 441-D01N-30-004-110', '210500071_30-004-110_API_10_M091_210521_10.54.15', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', NULL, '2021-05-21 10:54:40'),
(5, 'BASE RH 441-D01N-30-004-110', '210500070_30-004-110_API_10_M091_210521_10.54.14', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', NULL, '2021-05-21 10:54:45'),
(6, 'BASE RH 441-D01N-30-004-110', '210500069_30-004-110_API_10_M091_210521_10.54.12', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'Yes', NULL, '2021-05-21 10:54:50'),
(7, 'BASE RH 441-D01N-30-004-110', '210500068_30-004-110_API_10_M091_210521_10.54.06', 'No', 'No', 'No', 'No', 'Yes', 'No', 'Yes', 'No', 'Yes', 'No', 'No', 'Yes', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', NULL, '2021-05-21 10:54:59');

-- --------------------------------------------------------

--
-- Table structure for table `remaining_part`
--

CREATE TABLE `remaining_part` (
  `id` int(11) NOT NULL,
  `part_name` varchar(255) NOT NULL,
  `pn_api` varchar(255) NOT NULL,
  `pn_cust` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `date_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `repair_qrcode`
--

CREATE TABLE `repair_qrcode` (
  `id` int(11) NOT NULL,
  `datapart` varchar(255) NOT NULL,
  `qrcode` varchar(255) NOT NULL,
  `cek_qrcode` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `scanner_mode`
--

CREATE TABLE `scanner_mode` (
  `id` int(11) NOT NULL,
  `mode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `scanner_mode`
--

INSERT INTO `scanner_mode` (`id`, `mode`) VALUES
(1, 'Normal');

-- --------------------------------------------------------

--
-- Table structure for table `setup_production`
--

CREATE TABLE `setup_production` (
  `id` bigint(20) NOT NULL,
  `part_name` varchar(255) NOT NULL,
  `target` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Off Process',
  `date_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setup_production`
--

INSERT INTO `setup_production` (`id`, `part_name`, `target`, `start_time`, `end_time`, `status`, `date_time`) VALUES
(1, 'BASE LH 441-D64G-30-001-111 SC', 500, '2021-05-20 06:00:00', '2021-05-20 18:00:00', 'Finish', '2021-05-20 07:21:06'),
(2, 'BASE RH 441-D64G-30-001-110 SC', 500, '2021-05-20 06:00:00', '2021-05-20 18:00:00', 'Finish', '2021-05-20 07:21:20'),
(3, 'SUB ASSY BASE STAY LHD LH 34231-S1900', 300, '2021-05-21 06:00:00', '2021-05-21 16:00:00', 'Finish', '2021-05-21 07:42:43'),
(4, 'SUB ASSY BASE STAY LHD RH 34232-S1800', 300, '2021-05-21 06:00:00', '2021-05-21 16:00:00', 'Finish', '2021-05-21 07:42:58'),
(5, 'BASE LH 441-D01N-30-004-111', 250, '2021-05-21 08:00:00', '2021-05-21 12:00:00', 'Finish', '2021-05-21 08:13:34'),
(6, 'BASE RH 441-D01N-30-004-110', 250, '2021-05-21 08:00:00', '2021-05-21 12:00:00', 'Finish', '2021-05-21 08:13:50'),
(7, 'SUB ASSY BASE STAY RHD LH 34231-S1700', 300, '2021-05-21 13:00:00', '2021-05-21 16:30:00', 'On Process', '2021-05-21 12:59:33'),
(8, 'SUB ASSY BASE STAY RHD RH 34232-S1600', 300, '2021-05-21 13:00:00', '2021-05-21 16:30:00', 'On Process', '2021-05-21 12:59:58');

-- --------------------------------------------------------

--
-- Table structure for table `temp_counting_seq4`
--

CREATE TABLE `temp_counting_seq4` (
  `id` int(11) NOT NULL,
  `counting_R` int(11) NOT NULL DEFAULT 0,
  `counting_L` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `temp_counting_seq4`
--

INSERT INTO `temp_counting_seq4` (`id`, `counting_R`, `counting_L`) VALUES
(1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `temp_datapart`
--

CREATE TABLE `temp_datapart` (
  `id` int(11) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `uniq_number` varchar(255) NOT NULL,
  `nik` varchar(255) NOT NULL,
  `op_name` varchar(255) NOT NULL,
  `part_name` varchar(255) NOT NULL,
  `pn_api` varchar(255) NOT NULL,
  `pn_cust` varchar(255) NOT NULL,
  `job_no` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `sku_maris` varchar(255) NOT NULL,
  `packaging` int(11) NOT NULL,
  `date` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `date_time` varchar(255) NOT NULL,
  `date_time2` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `temp_datapart_wip`
--

CREATE TABLE `temp_datapart_wip` (
  `id` int(11) NOT NULL,
  `part_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `temp_production`
--

CREATE TABLE `temp_production` (
  `id` int(11) NOT NULL,
  `part_name` varchar(255) NOT NULL,
  `nik` varchar(255) NOT NULL,
  `packaging` int(11) NOT NULL,
  `position` varchar(255) DEFAULT NULL,
  `seq_status` varchar(255) NOT NULL DEFAULT 'Active',
  `date_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `temp_production`
--

INSERT INTO `temp_production` (`id`, `part_name`, `nik`, `packaging`, `position`, `seq_status`, `date_time`) VALUES
(1, 'SUB ASSY BASE STAY RHD RH 34232-S1600', 'M079', 10, 'Right', 'Active', '2021-05-21 13:00:59'),
(2, 'SUB ASSY BASE STAY RHD LH 34231-S1700', 'M079', 10, 'Left', 'Active', '2021-05-21 13:00:59');

-- --------------------------------------------------------

--
-- Table structure for table `temp_rfid_data`
--

CREATE TABLE `temp_rfid_data` (
  `id` int(11) NOT NULL,
  `nik` varchar(255) NOT NULL,
  `op_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uniq_code`
--

CREATE TABLE `uniq_code` (
  `id` int(11) NOT NULL,
  `cycle` int(11) NOT NULL DEFAULT 1,
  `date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `uniq_code`
--

INSERT INTO `uniq_code` (`id`, `cycle`, `date`) VALUES
(1, 2, '2021-05-03');

-- --------------------------------------------------------

--
-- Table structure for table `uniq_code_qr`
--

CREATE TABLE `uniq_code_qr` (
  `id` int(11) NOT NULL,
  `cycle` int(11) NOT NULL DEFAULT 1,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `uniq_code_qr`
--

INSERT INTO `uniq_code_qr` (`id`, `cycle`, `date`) VALUES
(1, 73, '2021-05-03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dandory`
--
ALTER TABLE `dandory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `datapart`
--
ALTER TABLE `datapart`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `downtime`
--
ALTER TABLE `downtime`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `start_downtime` (`start_downtime`,`end_downtime`);

--
-- Indexes for table `jig_and_nut`
--
ALTER TABLE `jig_and_nut`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `machine_status`
--
ALTER TABLE `machine_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_breaktime`
--
ALTER TABLE `master_breaktime`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_downtime`
--
ALTER TABLE `master_downtime`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category` (`category`);

--
-- Indexes for table `master_product`
--
ALTER TABLE `master_product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `part_name` (`part_name`,`pn_api`,`pn_cust`) USING BTREE;

--
-- Indexes for table `master_rejection`
--
ALTER TABLE `master_rejection`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `description` (`category`);

--
-- Indexes for table `master_shift`
--
ALTER TABLE `master_shift`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_user`
--
ALTER TABLE `master_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nik` (`nik`,`username`,`password`,`rfid_tag`);

--
-- Indexes for table `part_production`
--
ALTER TABLE `part_production`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `qrcode` (`qrcode`,`hasil_scanning`);

--
-- Indexes for table `recapitulation`
--
ALTER TABLE `recapitulation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rejection`
--
ALTER TABLE `rejection`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `remaining_part`
--
ALTER TABLE `remaining_part`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `repair_qrcode`
--
ALTER TABLE `repair_qrcode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scanner_mode`
--
ALTER TABLE `scanner_mode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setup_production`
--
ALTER TABLE `setup_production`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_counting_seq4`
--
ALTER TABLE `temp_counting_seq4`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_datapart`
--
ALTER TABLE `temp_datapart`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `temp_datapart_wip`
--
ALTER TABLE `temp_datapart_wip`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_production`
--
ALTER TABLE `temp_production`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `part_name` (`part_name`) USING BTREE;

--
-- Indexes for table `temp_rfid_data`
--
ALTER TABLE `temp_rfid_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uniq_code`
--
ALTER TABLE `uniq_code`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uniq_code_qr`
--
ALTER TABLE `uniq_code_qr`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dandory`
--
ALTER TABLE `dandory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `datapart`
--
ALTER TABLE `datapart`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `downtime`
--
ALTER TABLE `downtime`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `jig_and_nut`
--
ALTER TABLE `jig_and_nut`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `machine_status`
--
ALTER TABLE `machine_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `master_breaktime`
--
ALTER TABLE `master_breaktime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `master_downtime`
--
ALTER TABLE `master_downtime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `master_product`
--
ALTER TABLE `master_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `master_rejection`
--
ALTER TABLE `master_rejection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `master_shift`
--
ALTER TABLE `master_shift`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `master_user`
--
ALTER TABLE `master_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `part_production`
--
ALTER TABLE `part_production`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `recapitulation`
--
ALTER TABLE `recapitulation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `rejection`
--
ALTER TABLE `rejection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `remaining_part`
--
ALTER TABLE `remaining_part`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `repair_qrcode`
--
ALTER TABLE `repair_qrcode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `scanner_mode`
--
ALTER TABLE `scanner_mode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `setup_production`
--
ALTER TABLE `setup_production`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `temp_counting_seq4`
--
ALTER TABLE `temp_counting_seq4`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `temp_datapart`
--
ALTER TABLE `temp_datapart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=341;

--
-- AUTO_INCREMENT for table `temp_datapart_wip`
--
ALTER TABLE `temp_datapart_wip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `temp_production`
--
ALTER TABLE `temp_production`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `temp_rfid_data`
--
ALTER TABLE `temp_rfid_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=317;

--
-- AUTO_INCREMENT for table `uniq_code`
--
ALTER TABLE `uniq_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `uniq_code_qr`
--
ALTER TABLE `uniq_code_qr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
