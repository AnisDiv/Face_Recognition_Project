-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2024 at 12:04 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_tracking`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_id`
--

CREATE TABLE `admin_id` (
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_id`
--

INSERT INTO `admin_id` (`username`, `password`) VALUES
('Admin', 'Admin123');

-- --------------------------------------------------------

--
-- Table structure for table `face_detection_logs`
--

CREATE TABLE `face_detection_logs` (
  `log_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `face_detection_logs`
--

INSERT INTO `face_detection_logs` (`log_id`, `student_id`, `image_path`, `timestamp`) VALUES
(114, 406565011, 'captured_faces/ซูไฮมี เนือเรง_2024-10-13_16-59-11.jpg', '2024-10-13 16:59:11'),
(115, 406565017, 'captured_faces/นูรไอมี บือราเฮง_2024-10-13_16-59-28.jpg', '2024-10-13 16:59:28');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `major` varchar(100) DEFAULT NULL,
  `faculty` varchar(100) DEFAULT NULL,
  `university` varchar(100) DEFAULT NULL,
  `face_image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `first_name`, `last_name`, `major`, `faculty`, `university`, `face_image_path`) VALUES
(406565002, 'อาซียะห์', 'สามะ', 'เทคโนโลยีสารสนเทศ', 'วิทยาศาสตร์เทคโนโลยีและการเกษตร', 'ราชภัฏยะลา', 'D:/images/siyah.jpg'),
(406565003, 'อาลามี', 'ยามา', 'เทคโนโลยีสารสนเทศ', 'วิทยาศาสตร์เทคโนโลยีและการเกษตร', 'ราชภัฏยะลา', 'D:/images/alamee.jpg'),
(406565004, 'อนีส', 'ยายอ', 'เทคโนโลยีสารสนเทศ', 'วิทยาศาสตร์เทคโนโลยีและการเกษตร', 'ราชภัฏยะลา', 'D:/images/anis.jpg'),
(406565009, 'อุสมาน', 'อาแว', 'เทคโนโลยีสารสนเทศ', 'วิทยาศาสตร์เทคโนโลยีและการเกษตร', 'ราชภัฏยะลา', 'D:/images/usman.jpg'),
(406565010, 'มูฮำหมัดซาดัม', 'มิง', 'เทคโนโลยีสารสนเทศ', 'วิทยาศาสตร์เทคโนโลยีและการเกษตร', 'ราชภัฏยะลา', 'D:/images/sadam.jpg'),
(406565011, 'ซูไฮมี', 'เนือเรง', 'เทคโนโลยีสารสนเทศ', 'วิทยาศาสตร์เทคโนโลยีและการเกษตร', 'ราชภัฏยะลา', 'D:/images/suhaimee.jpg'),
(406565012, 'กิจการ', 'จงกลพืล', 'เทคโนโลยีสารสนเทศ', 'วิทยาศาสตร์เทคโนโลยีและการเกษตร', 'ราชภัฏยะลา', 'D:/images/warm.jpg'),
(406565013, 'มัรยัม', 'เต๊ะหวัง', 'เทคโนโลยีสารสนเทศ', 'วิทยาศาสตร์เทคโนโลยีและการเกษตร', 'ราชภัฏยะลา', 'D:/images/maryam.jpg'),
(406565014, 'ฟิรดาวน์', 'กะจิเจ๊ะแย', 'เทคโนโลยีสารสนเทศ', 'วิทยาศาสตร์เทคโนโลยีและการเกษตร', 'ราชภัฏยะลา', 'D:/images/firdao.jpg'),
(406565015, 'แวมูฮำหมัดวากี', 'จะปากียา', 'เทคโนโลยีสารสนเทศ', 'วิทยาศาสตร์เทคโนโลยีและการเกษตร', 'ราชภัฏยะลา', 'D:/images/waki.jpg'),
(406565017, 'นูรไอมี', 'บือราเฮง', 'เทคโนโลยีสารสนเทศ', 'วิทยาศาสตร์เทคโนโลยีและการเกษตร', 'ราชภัฏยะลา', 'D:/images/aimee.jpg'),
(406565018, 'อาลาฟิต', 'ตาเยะ', 'เทคโนโลยีสารสนเทศ', 'วิทยาศาสตร์เทคโนโลยีและการเกษตร', 'ราชภัฏยะลา', 'D:/images/alafit.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_id`
--
ALTER TABLE `admin_id`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `face_detection_logs`
--
ALTER TABLE `face_detection_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `face_detection_logs`
--
ALTER TABLE `face_detection_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=406565019;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `face_detection_logs`
--
ALTER TABLE `face_detection_logs`
  ADD CONSTRAINT `face_detection_logs_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
