-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 26, 2024 at 11:39 AM
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
-- Database: `student_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `firstName` varchar(20) NOT NULL,
  `lastName` varchar(20) NOT NULL,
  `emailAddress` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `firstName`, `lastName`, `emailAddress`, `password`) VALUES
(1, 'Fahmid', 'Ahmed', 'admin@gmail.com', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `certificate`
--

CREATE TABLE `certificate` (
  `id` int(11) NOT NULL,
  `studentId` varchar(20) NOT NULL,
  `semesterName` varchar(50) NOT NULL,
  `fileUrl` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `certificate`
--

INSERT INTO `certificate` (`id`, `studentId`, `semesterName`, `fileUrl`) VALUES
(7, '11223344', 'Spring-2023', '../Admin/uploads/676d2ef7c16794.26527178.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `convocation`
--

CREATE TABLE `convocation` (
  `id` int(11) NOT NULL,
  `studentId` varchar(20) NOT NULL,
  `studentName` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `fatherName` varchar(50) NOT NULL,
  `motherName` varchar(50) NOT NULL,
  `department` varchar(100) NOT NULL,
  `programName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `courseCode` varchar(30) NOT NULL,
  `courseTitle` varchar(100) NOT NULL,
  `credit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `courseCode`, `courseTitle`, `credit`) VALUES
(17, 'CIS313', 'Network Security', 3),
(18, 'CIS313L', 'Network Security Lab', 1),
(19, 'ECO314', 'Economics', 3),
(20, 'CIS311', 'System Analysis & Design', 3),
(21, 'CIS311L', 'System Analysis & Design Lab', 1),
(22, 'CIS312', 'Computer Architecture and Organization', 3),
(23, 'CSE411', 'Software development', 3),
(24, 'CSE412', 'Software Development Lab', 2),
(25, 'CSE413', 'Java Development', 3),
(26, 'CSE414', 'Java Development Lab', 1);

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE `education` (
  `id` int(11) NOT NULL,
  `degree` varchar(30) NOT NULL,
  `degreeName` varchar(30) NOT NULL,
  `institution` varchar(50) NOT NULL,
  `universityBoard` varchar(100) NOT NULL,
  `passingYear` varchar(20) NOT NULL,
  `gradeClassDivision` varchar(10) NOT NULL,
  `marksCGPA` varchar(10) NOT NULL,
  `remarks` varchar(50) NOT NULL,
  `studentId` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `education`
--

INSERT INTO `education` (`id`, `degree`, `degreeName`, `institution`, `universityBoard`, `passingYear`, `gradeClassDivision`, `marksCGPA`, `remarks`, `studentId`) VALUES
(4, 'HSC', 'Commerce', 'Dhaka Commerce College', 'Dhaka', '2018', 'B', '3.42', 'None', '11223344'),
(5, 'SSC', 'Science', 'Model Academy', 'Dhaka', '2016', 'A', '4.62', 'Good', '11223344');

-- --------------------------------------------------------

--
-- Table structure for table `forgot_password`
--

CREATE TABLE `forgot_password` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `applicationDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `transactionDate` date NOT NULL,
  `collectedBy` varchar(20) NOT NULL,
  `feeType` varchar(100) NOT NULL,
  `amountTotal` int(11) NOT NULL,
  `amountPaying` int(11) NOT NULL,
  `amountWillPay` int(11) NOT NULL,
  `studentId` varchar(20) NOT NULL,
  `semesterName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `transactionDate`, `collectedBy`, `feeType`, `amountTotal`, `amountPaying`, `amountWillPay`, `studentId`, `semesterName`) VALUES
(1, '2024-12-19', 'Bkash', 'Admission Fee', 5000, 3000, 2000, '11223344', 'Spring-2023'),
(2, '2024-12-23', 'Bkash', 'Admission Fee', 6000, 3000, 3000, '11223344', 'Spring-2023'),
(3, '2024-12-25', 'Bkash', 'Campus Development Fee', 8000, 4000, 4000, '11223344', 'Spring-2023'),
(4, '2024-12-30', 'Bkash', 'Extra Curriculam Fee', 15000, 10000, 5000, '11223344', 'Spring-2023'),
(5, '2025-01-05', 'UCB', 'Extra Curriculam Fee', 10000, 7000, 3000, '11223344', 'Spring-2023'),
(6, '2024-12-10', 'Bkash', 'Lab Fee', 8000, 7000, 1000, '11223344', 'Spring-2023'),
(7, '2024-12-15', 'Bank Asia', 'Library Fee', 5000, 3000, 2000, '11223344', 'Spring-2023'),
(8, '2024-12-20', 'Bkash', 'Rover Scout & BNCC Fee', 20000, 15000, 5000, '11223344', 'Spring-2023'),
(9, '2024-12-25', 'UCB', 'Semester Fee', 20000, 18000, 2000, '11223344', 'Spring-2023'),
(10, '2024-12-30', 'Sonali Bank', 'Student Life Insurance', 7000, 4000, 3000, '11223344', 'Spring-2023'),
(11, '2025-01-05', 'Rupali Bank', 'Smart Card', 15000, 5000, 10000, '11223344', 'Spring-2023'),
(12, '2025-01-10', 'Bkash', 'Tuition Fee', 20000, 15000, 5000, '11223344', 'Spring-2023');

-- --------------------------------------------------------

--
-- Table structure for table `semester_course`
--

CREATE TABLE `semester_course` (
  `id` int(11) NOT NULL,
  `regClearence` varchar(50) NOT NULL,
  `roomNo` varchar(10) NOT NULL,
  `noOfDays` int(11) NOT NULL,
  `timeSlot` varchar(20) NOT NULL,
  `teacher` varchar(50) NOT NULL,
  `gradePoint` float NOT NULL,
  `grade` varchar(10) NOT NULL,
  `advised` varchar(50) NOT NULL,
  `section` varchar(10) NOT NULL,
  `batch` varchar(10) NOT NULL,
  `department` varchar(50) NOT NULL,
  `programName` varchar(100) NOT NULL,
  `semesterName` varchar(50) NOT NULL,
  `courseId` int(11) NOT NULL,
  `studentId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `semester_course`
--

INSERT INTO `semester_course` (`id`, `regClearence`, `roomNo`, `noOfDays`, `timeSlot`, `teacher`, `gradePoint`, `grade`, `advised`, `section`, `batch`, `department`, `programName`, `semesterName`, `courseId`, `studentId`) VALUES
(4, 'Yes', '101', 4, '9AM-14PM', 'Azmain Kabir', 4, 'A+', 'Good', 'A', '23', 'Computer Science and Engineering', 'B.Sc', 'Spring-2023', 17, 11223344),
(5, 'Yes', '101', 4, '9AM-14PM', 'Azmain Kabir', 3.75, 'A', 'Good', 'A', '24', 'Computer Science and Engineering', 'B.Sc', 'Spring-2023', 18, 11223344),
(6, 'Yes', '102', 4, '9AM-14PM', 'Md. Jalal', 3.75, 'A', 'Best', 'B', '25', 'Computer Science and Engineering', 'B.Sc', 'Spring-2023', 19, 11223344),
(7, 'Yes', '104', 4, '9AM-14PM', 'Azim Uddin', 2.5, 'C+', 'Better', 'C', '30', 'Computer Science and Engineering', 'B.Sc', 'Spring-2023', 20, 11223344),
(8, 'Yes', '103', 4, '9AM-14PM', 'Zahiruddin', 2.5, 'C+', 'Best', 'D', '32', 'Computer Science and Engineering', 'B.Sc', 'Spring-2023', 21, 11223344),
(9, 'Yes', '105', 4, '9AM-14PM', 'Sahib', 3.5, 'A-', 'Good', 'A', '24', 'Computer Science and Engineering', 'B.Sc', 'Spring-2023', 22, 11223344),
(10, 'Yes', '201', 4, '9AM-14PM', 'Azmain Kabir', 2, 'D', 'Good', 'A', '25', 'Computer Science and Engineering', 'B.Sc', 'Summer-2023', 23, 11223344),
(11, 'Yes', '202', 4, '9AM-14PM', 'Azmain Kabir', 3, 'B', 'Best', 'B', '34', 'Computer Science and Engineering', 'B.Sc', 'Summer-2023', 24, 11223344),
(12, 'Yes', '205', 4, '9AM-14PM', 'Azmain Kabir', 3.74, 'A', 'Good', 'A', '34', 'Computer Science and Engineering', 'B.Sc', 'Summer-2023', 25, 11223344),
(13, 'Yes', '205', 5, '9AM-14PM', 'Azmain Kabir', 2.75, 'B-', 'Better', '25', '54', 'Computer Science and Engineering', 'B.Sc', 'Summer-2023', 26, 11223344);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `studentId` varchar(50) NOT NULL,
  `studentPassword` varchar(50) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `middleName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `nickName` varchar(50) NOT NULL,
  `dob` varchar(50) NOT NULL,
  `birthPlace` varchar(100) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `maritalStatus` varchar(20) NOT NULL,
  `bloodGroup` varchar(10) NOT NULL,
  `religion` varchar(50) NOT NULL,
  `nationality` varchar(30) NOT NULL,
  `nationalId` varchar(50) NOT NULL,
  `passportNo` varchar(50) NOT NULL,
  `socialNetworkId` varchar(50) NOT NULL,
  `IM` varchar(50) NOT NULL,
  `aboutStudent` text NOT NULL,
  `mobileNo` varchar(20) NOT NULL,
  `presentMobile` varchar(20) NOT NULL,
  `permanentMobile` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `alternativeEmail` varchar(50) NOT NULL,
  `imageUrl` varchar(100) NOT NULL,
  `presentAddress` varchar(100) NOT NULL,
  `presentPostOffice` varchar(30) NOT NULL,
  `presentPoliceStation` varchar(30) NOT NULL,
  `presentDistrictCity` varchar(30) NOT NULL,
  `presentDivisionState` varchar(30) NOT NULL,
  `presentCountry` varchar(30) NOT NULL,
  `presentZipCode` varchar(30) NOT NULL,
  `permanentAddress` varchar(100) NOT NULL,
  `permanentPostOffice` varchar(30) NOT NULL,
  `permanentPoliceStation` varchar(30) NOT NULL,
  `permanentDistrictCity` varchar(30) NOT NULL,
  `permanentDivisionState` varchar(30) NOT NULL,
  `permanentCountry` varchar(30) NOT NULL,
  `permanentZipCode` varchar(30) NOT NULL,
  `hostelAddress` varchar(100) NOT NULL,
  `messAddress` varchar(100) NOT NULL,
  `otherAddress` varchar(100) NOT NULL,
  `fatherName` varchar(50) NOT NULL,
  `fatherContactNo` varchar(20) NOT NULL,
  `fatherOccupation` varchar(50) NOT NULL,
  `fatherDesignation` varchar(30) NOT NULL,
  `fatherEmployerName` varchar(50) NOT NULL,
  `fatherAnnualIncome` varchar(10) NOT NULL,
  `motherName` varchar(50) NOT NULL,
  `motherContactNo` varchar(20) NOT NULL,
  `motherOccupation` varchar(50) NOT NULL,
  `motherDesignation` varchar(30) NOT NULL,
  `motherEmployerName` varchar(50) NOT NULL,
  `motherAnnualIncome` varchar(10) NOT NULL,
  `parentAddress` varchar(100) NOT NULL,
  `localGuardianName` varchar(50) NOT NULL,
  `localGuardianContactNo` varchar(20) NOT NULL,
  `relationWithLocalGuardian` varchar(30) NOT NULL,
  `localGuardianAddress` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `studentId`, `studentPassword`, `firstName`, `middleName`, `lastName`, `nickName`, `dob`, `birthPlace`, `gender`, `maritalStatus`, `bloodGroup`, `religion`, `nationality`, `nationalId`, `passportNo`, `socialNetworkId`, `IM`, `aboutStudent`, `mobileNo`, `presentMobile`, `permanentMobile`, `email`, `alternativeEmail`, `imageUrl`, `presentAddress`, `presentPostOffice`, `presentPoliceStation`, `presentDistrictCity`, `presentDivisionState`, `presentCountry`, `presentZipCode`, `permanentAddress`, `permanentPostOffice`, `permanentPoliceStation`, `permanentDistrictCity`, `permanentDivisionState`, `permanentCountry`, `permanentZipCode`, `hostelAddress`, `messAddress`, `otherAddress`, `fatherName`, `fatherContactNo`, `fatherOccupation`, `fatherDesignation`, `fatherEmployerName`, `fatherAnnualIncome`, `motherName`, `motherContactNo`, `motherOccupation`, `motherDesignation`, `motherEmployerName`, `motherAnnualIncome`, `parentAddress`, `localGuardianName`, `localGuardianContactNo`, `relationWithLocalGuardian`, `localGuardianAddress`) VALUES
(42, '11223344', 'cd73502828457d15655bbd7a63fb0bc8', 'Fahmid', 'Fahmid', 'Fahmid', 'Fahmid', '2005-10-26', 'Dhaka', 'Male', 'Single', 'A-', 'Islam', 'Bangladeshi', '111', '222', '333', '444', 'I am a student of CSE of NPIUB', '01923453434', '01923453435', '01923453438', 'student@gmail.com', 'student1@gmail.com', '../Admin/uploads/676d2eaeb73946.44740682.jpg', 'Dhaka', 'Dhaka', 'Dhaka', 'Dhaka', 'Dhaka', 'BD', '123', 'Chittagong', 'Chittagong', 'Chittagong', 'Chittagong', 'Chittagong', 'BD', '123', 'Chittagong', 'Chittagong', 'Chittagong', 'Daniel', '01945342342', 'Daniel', 'Daniel', 'Daniel', '1234', 'Elma', '01823989898', 'Elma', 'Elma', 'Elma', '456', 'Chittagong', 'Eba', '01934787678', 'Sis', 'Chittagong');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `certificate`
--
ALTER TABLE `certificate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `convocation`
--
ALTER TABLE `convocation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forgot_password`
--
ALTER TABLE `forgot_password`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `semester_course`
--
ALTER TABLE `semester_course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `certificate`
--
ALTER TABLE `certificate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `convocation`
--
ALTER TABLE `convocation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `education`
--
ALTER TABLE `education`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `forgot_password`
--
ALTER TABLE `forgot_password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `semester_course`
--
ALTER TABLE `semester_course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
