-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: March 14, 2022 at 02:35 AM
-- Server version: 10.3.15-MariaDB
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onlinecourse`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `creationDate` timestamp NULL DEFAULT current_timestamp(),
  `updationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`, `creationDate`, `updationDate`) VALUES
(1, 'admin', 'admin@gmail.com', 'f925916e2754e5e03f75dd58a5733251', '2022-01-31 16:21:18', '2022-01-31 16:21:18');

-- --------------------------------------------------------
--
-- Table structure for table `apply`
--

CREATE TABLE `apply` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `parentname` varchar(255) NOT NULL,
  `parentnumber` varchar(255) NOT NULL,
  `schoolname` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `cgpa` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `applydate` date NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `apply`
--

INSERT INTO `apply` (`id`, `firstname`, `lastname`, `email`, `gender`, `address`, `parentname`, `parentnumber`, `schoolname`, `photo`, `cgpa`, `department`, `applydate`, `status`) VALUES
(1, 'Rito',  'Chabalala', 'ritochabalala@gmail.com',  'Male',  'Madeira Isle',  'Thomas',  '0123456789', 'Nkwangulatilo Education Centre', 'NSC Certificate 2017.pdf', '8.5', 'BSc Hons', '2020-04-09', 1);


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(333) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'Rito Chabalala', 'ritochabalala@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `courseCode` varchar(255) DEFAULT NULL,
  `courseName` varchar(255) DEFAULT NULL,
  `noofSeats` int(11) DEFAULT NULL,
  `creationDate` timestamp NULL DEFAULT current_timestamp(),
  `updationDate` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `courseCode`, `courseName`, `noofSeats`, `creationDate`, `updationDate`) VALUES
(1, 'Ana01', 'Anatomy', 10, '2022-02-10 17:23:28', '11-02-2022 05:10:26 AM'),
(2, 'Maths02', 'Mathematics', 25, '2022-02-11 00:52:46', '11-02-2022 06:23:06 AM'),
(3, 'Eng03', 'English', 18, '2022-02-10 17:23:28', '11-02-2022 06:55:12 AM'),
(4, 'Bio04', 'Biochemistry', 23, '2022-02-10 17:23:28', '11-02-2022 07:18:39 AM'),
(5, 'PhP05', 'PHP and MySQL', 14, '2022-02-10 17:23:28', '11-02-2022 07:59:46 AM'),
(6, 'Py06', 'Python', 8, '2022-02-10 17:23:28', '11-02-2022 08:20:57 AM'),
(7, 'Phy07', 'Physiology', 15, '2022-02-10 17:23:28', '11-02-2022 08:20:57 AM'),
(8, 'Stats08', 'Statistics', 17, '2022-02-10 17:23:28', '11-02-2022 08:20:57 AM'),
(9, 'Chem09', 'Chemistry', 21, '2022-02-10 17:23:28', '11-02-2022 08:20:57 AM'),
(10, 'AppMat10', 'Applied Mathematics', 7, '2022-02-10 17:23:28', '11-02-2022 08:20:57 AM'),
(11, 'ComScie11', 'Computer Science', 20, '2022-02-10 17:23:28', '11-02-2022 08:20:57 AM');

-- --------------------------------------------------------

--
-- Table structure for table `courseenrolls`
--

CREATE TABLE `courseenrolls` (
  `id` int(11) NOT NULL,
  `studentRegno` varchar(9) DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `session` int(11) DEFAULT NULL,
  `department` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `course` int(11) DEFAULT NULL,
  `enrollDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courseenrolls`
--

-- INSERT INTO `courseenrolls` (`id`, `studentRegno`, `pincode`, `session`, `department`, `level`, `semester`, `course`, `enrollDate`) VALUES
-- (1, '201806940', '856292', 13, 16, 10, 10, 7, '2022-02-25 02:16:14 2022-02-11');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `department` varchar(255) DEFAULT NULL,
  `creationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `department`, `creationDate`) VALUES
(1, 'MBChB', '2022-02-25 01:14:57'),
(2, 'B Rad', '2022-02-25 01:14:29'),
(3, 'B Cur', '2022-02-25 01:15:43'),
(4, 'BDS', '2022-02-25 01:15:54'),
(5, 'BDT', '2022-02-25 01:16:10'),
(6, 'BoH', '2022-02-25 01:16:31'),
(7, 'B SLP & A', '2022-04-14 01:16:42'),
(8, 'BSc', '2022-04-14 01:17:18'),
(9, 'BSc Dietetics', '2022-04-14 01:17:34'),
(11, 'BPharm', '2022-04-14 21:01:47'),
(12, 'B Occ Ther', '2022-04-14 21:02:24'),
(13, 'BSc Physio', '2022-04-14 21:01:59'),
(14, 'BSc Hons', '2022-04-14 21:02:11'),
(15, 'MSc', '2022-04-14 21:01:07'),
(16, 'PhD', '2022-04-14 20:58:00');

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id` int(11) NOT NULL,
  `level` varchar(255) DEFAULT NULL,
  `creationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id`, `level`, `creationDate`) VALUES
(1, '1st', '2022-02-25 01:46:36'),
(2, '2nd', '2022-02-25 01:46:50'),
(3, '3rd', '2022-02-25 01:47:53'),
(4, '4th', '2022-02-25 01:48:02'),
(5, '5th', '2022-02-25 01:48:11'),
(6, '6th', '2022-02-25 01:48:26'),
(7, 'ECP', '2022-02-25 01:48:32'),
(8, 'Hons', '2022-02-25 01:48:41'),
(9, 'MSc', '2022-02-25 01:48:51'),
(10, 'PhD', '2022-02-25 01:49:07'),
(11, 'Prof.', '2022-02-25 01:49:17');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `newstitle` varchar(255) DEFAULT NULL,
  `newsDescription` mediumtext DEFAULT NULL,
  `postingDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `newstitle`, `newsDescription`, `postingDate`) VALUES
(1, 'New Course Started PHP', 'This course will benefit a lot of students.', '2022-02-25 01:33:21'),
(2, 'Computer Science and IT New', 'A lot of students should learn as we live in 21 century.', '2022-02-25 01:35:37'),
(3, 'New Program Started ECP', 'This course will benefit a lot of students who do not meet minimum requirements', '2022-02-25 01:42:05'),
(4, 'New Course on the way AI', 'A new course is coming called Artificial Intellegence.', '2022-02-25 01:42:28'),
(5, 'Rito Chabalala', 'He is the developer of this beautiful website.', '2022-02-25 01:43:17');

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `id` int(11) NOT NULL,
  `semester` varchar(255) DEFAULT NULL,
  `creationDate` timestamp NULL DEFAULT current_timestamp(),
  `updationDate` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`id`, `semester`, `creationDate`, `updationDate`) VALUES
(1, 'Semester 1', '2022-02-25 00:58:21', NULL),
(2, 'Semester 2', '2022-02-25 00:58:34', NULL),
(3, 'Part-time', '2022-02-25 00:58:47', NULL),
(4, 'Full-time', '2022-02-25 00:59:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `id` int(11) NOT NULL,
  `session` varchar(255) DEFAULT NULL,
  `creationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`id`, `session`, `creationDate`) VALUES
(1, 'School of Medicine', '2022-02-25 01:04:24'),
(2, 'School of Pharmacy', '2022-02-25 01:09:22'),
(3, 'School of Health Care Sciences', '2022-02-25 01:09:59'),
(4, 'School of Oral Health Sciences', '2022-02-25 01:10:16'),
(5, 'School of Science and Technology', '2022-02-25 01:10:35');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `studentregno` varchar(255) NOT NULL,
  `studentPhoto` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `studentname` varchar(255) DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `session` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `semester` varchar(255) DEFAULT NULL,
  `cgpa` decimal(10,2) DEFAULT NULL,
  `creationdate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `studentregno`, `studentPhoto`, `password`, `studentname`, `pincode`, `session`, `department`, `semester`, `cgpa`, `creationdate`) VALUES
(1, '201806940', 'student.jpg', '12bce374e7be15142e8172f668da00d8', 'Rito Chabalala', '856292', 'School of Science and Technology', 'BSc Hons', 'Full-time', '8.5', '2022-02-25 01:23:20');

-- --------------------------------------------------------

--
-- Table structure for table `userlog`
--

CREATE TABLE `userlog` (
  `id` int(11) NOT NULL,
  `studentRegno` varchar(255) DEFAULT NULL,
  `userip` binary(16) DEFAULT NULL,
  `loginTime` timestamp NULL DEFAULT current_timestamp(),
  `logout` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userlog`
--

-- INSERT INTO `userlog` (`id`, `studentRegno`, `userip`, `loginTime`, `logout`, `status`) VALUES
-- (1, '201806940', 0x3a3a3100000000000000000000000000, '2022-03-12 23:55:00', '13-03-2022 03:33:29 AM', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courseenrolls`
--
ALTER TABLE `courseenrolls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);
  
  --
-- Indexes for table `apply`
--
ALTER TABLE `apply`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userlog`
--
ALTER TABLE `userlog`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `courseenrolls`
--
ALTER TABLE `courseenrolls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
  

--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
  
--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

  --
-- AUTO_INCREMENT for table `apply`
--
ALTER TABLE `apply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
  
  --
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `userlog`
--
ALTER TABLE `userlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
