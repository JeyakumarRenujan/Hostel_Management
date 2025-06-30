-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2025 at 09:59 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hostel_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `complaint`
--

CREATE TABLE `complaint` (
  `Complaint_ID` int(11) NOT NULL,
  `Student_ID` int(11) DEFAULT NULL,
  `Complaint_Text` text DEFAULT NULL,
  `Complaint_Date` date DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaint`
--

INSERT INTO `complaint` (`Complaint_ID`, `Student_ID`, `Complaint_Text`, `Complaint_Date`, `Status`) VALUES
(2001, 1, 'Room heater is not working', '2025-06-06', 'Resolved'),
(2002, 3, 'Room light flickers', '2025-06-17', 'Resolved');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `Payment_ID` int(11) NOT NULL,
  `Student_ID` int(11) DEFAULT NULL,
  `Amount` decimal(10,2) DEFAULT NULL,
  `Payment_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`Payment_ID`, `Student_ID`, `Amount`, `Payment_Date`) VALUES
(1001, 1, 500.00, '2025-06-16'),
(1002, 2, 600.00, '2025-06-24');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `Room_No` int(11) NOT NULL,
  `Room_Type` varchar(50) DEFAULT NULL,
  `No_of_Beds` int(11) DEFAULT NULL,
  `Furniture_Details` varchar(255) DEFAULT NULL,
  `AC_Status` enum('AC','Non-AC') NOT NULL,
  `Warden_ID` int(11) DEFAULT NULL,
  `Occupied_Count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`Room_No`, `Room_Type`, `No_of_Beds`, `Furniture_Details`, `AC_Status`, `Warden_ID`, `Occupied_Count`) VALUES
(101, 'Single', 1, 'Bed, Chair, Table', 'AC', 1, 1),
(102, 'Double', 2, '2 Beds, 2 Chairs, 2 Tables', 'Non-AC', 1, 1),
(103, 'Double', 2, '2 Beds, 2 Chairs,', 'AC', 2, 2),
(104, 'Single', 1, 'Bed, Chair, Table', 'Non-AC', 2, 0),
(105, 'Double', 2, '2 Beds, 2Tables', 'AC', 3, 0),
(106, 'Single', 1, '1 Bed, 1 Table, 1 Chair', 'Non-AC', 3, 0),
(107, 'Double', 2, '2 Beds, 2 Chairs, 2 Tables', 'AC', 4, 1),
(108, 'Single', 1, '1 Bed, 1 Table, 1 Chair', 'Non-AC', 4, 1),
(109, 'Double', 2, '2 Beds, 2 Chairs, 2 Tables', 'Non-AC', 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `Student_ID` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Gender` varchar(10) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `Contact` varchar(15) DEFAULT NULL,
  `Room_No` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`Student_ID`, `Name`, `Gender`, `DOB`, `Contact`, `Room_No`) VALUES
(1, 'Renujan', 'Male', '2002-03-03', '0741305450', 101),
(2, 'Piradshaka', 'Female', '2003-01-02', '0771234567', 107),
(3, 'Kilshan', 'Male', '2002-04-06', '0710987654', 102),
(4, 'Gowtham', 'Male', '2002-04-08', '0710387654', 103),
(5, 'Anojinth', 'Male', '2002-12-12', '0772437286', 103),
(6, 'Varnaja', 'Female', '2002-03-09', '0761230985', 108);

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `User_ID` int(11) NOT NULL,
  `Username` varchar(50) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Role` enum('student','staff') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_login`
--

INSERT INTO `user_login` (`User_ID`, `Username`, `Password`, `Role`) VALUES
(1, 'student1', 'student123', 'student'),
(2, 'staff1', 'staff123', 'staff');

-- --------------------------------------------------------

--
-- Table structure for table `visitor`
--

CREATE TABLE `visitor` (
  `Visitor_ID` int(11) NOT NULL,
  `Student_ID` int(11) DEFAULT NULL,
  `Visitor_Name` varchar(100) DEFAULT NULL,
  `Visit_Date` date DEFAULT NULL,
  `Purpose` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visitor`
--

INSERT INTO `visitor` (`Visitor_ID`, `Student_ID`, `Visitor_Name`, `Visit_Date`, `Purpose`) VALUES
(6001, 1, 'Jeyalatha', '2025-06-13', 'Give the home food');

-- --------------------------------------------------------

--
-- Table structure for table `warden`
--

CREATE TABLE `warden` (
  `Warden_ID` int(11) NOT NULL,
  `Warden_Name` varchar(100) DEFAULT NULL,
  `Phone_No` varchar(15) DEFAULT NULL,
  `Gender` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `warden`
--

INSERT INTO `warden` (`Warden_ID`, `Warden_Name`, `Phone_No`, `Gender`) VALUES
(1, 'Mr. Suresh Kumar', '0771234567', 'Male'),
(2, 'Ms. Nirosha Fernando', '0789876543', 'Female'),
(3, 'Mr. Ranjan Silva', '0761122334', 'Male'),
(4, 'Ms. Thushari Perera', '0754455667', 'Female');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `complaint`
--
ALTER TABLE `complaint`
  ADD PRIMARY KEY (`Complaint_ID`),
  ADD KEY `fk_complaint_student` (`Student_ID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`Payment_ID`),
  ADD KEY `fk_payment_student` (`Student_ID`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`Room_No`),
  ADD KEY `fk_room_warden` (`Warden_ID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`Student_ID`),
  ADD KEY `fk_student_room` (`Room_No`);

--
-- Indexes for table `user_login`
--
ALTER TABLE `user_login`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- Indexes for table `visitor`
--
ALTER TABLE `visitor`
  ADD PRIMARY KEY (`Visitor_ID`),
  ADD KEY `fk_visitor_student` (`Student_ID`);

--
-- Indexes for table `warden`
--
ALTER TABLE `warden`
  ADD PRIMARY KEY (`Warden_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_login`
--
ALTER TABLE `user_login`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `complaint`
--
ALTER TABLE `complaint`
  ADD CONSTRAINT `fk_complaint_student` FOREIGN KEY (`Student_ID`) REFERENCES `student` (`Student_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `fk_payment_student` FOREIGN KEY (`Student_ID`) REFERENCES `student` (`Student_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `fk_room_warden` FOREIGN KEY (`Warden_ID`) REFERENCES `warden` (`Warden_ID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `fk_student_room` FOREIGN KEY (`Room_No`) REFERENCES `room` (`Room_No`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `visitor`
--
ALTER TABLE `visitor`
  ADD CONSTRAINT `fk_visitor_student` FOREIGN KEY (`Student_ID`) REFERENCES `student` (`Student_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
