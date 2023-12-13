-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 25, 2023 at 04:05 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proj_im2`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `addAssignment` (IN `_assignment` INT, IN `_student` INT, IN `_deadline_date` DATE, IN `_student_score` INT, OUT `ret` INT)   BEGIN
	DECLARE isExists int;
	set isExists = 0;
	
	select count(*) into isExists from tblassignment where student=_student and assignment=_assignment;
	
	set ret = isExists;
	if isExists = 0 then 
		insert into tblassignment(assignment,student, deadline_date, student_score) values(_assignment,_student, _deadline_date, _student_score);
	END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `addAssignmentList` (IN `_ass_title` VARCHAR(250), IN `_total_score` VARCHAR(50), IN `_subject` INT, OUT `ret` INT)   BEGIN
	DECLARE isExists int;
	set isExists = 0;
	
	select count(*) into isExists from tblassignmentlist where ass_title=_ass_title;
	
	set ret = isExists;
	if isExists = 0 then 
		insert into tblassignmentlist(ass_title,total_score,subject) values(_ass_title,_total_score,_subject);
	END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `addStudent` (IN `_fname` VARCHAR(50), IN `_lname` VARCHAR(50), IN `_gender` VARCHAR(10), IN `_age` INT, IN `_bdate` DATE, IN `_address` VARCHAR(100), OUT `ret` INT)   BEGIN
	DECLARE isExists int;
	set isExists = 0;
	
	select count(*) into isExists from tblstudent where fname=_fname and lname=_lname;
	
	set ret = isExists;
	if isExists = 0 then 
		insert into tblstudent(fname,lname,gender,age,bdate,address) values(_fname,_lname,_gender,_age,_bdate,_address);
	END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `addSubject` (IN `_subject` VARCHAR(250), IN `_teacher` VARCHAR(50), OUT `ret` INT)   BEGIN
	DECLARE isExists int;
	set isExists = 0;
	
	select count(*) into isExists from tblsubject where subject_title=_subject;
	
	set ret = isExists;
	if isExists = 0 then 
		insert into tblsubject(subject_title,teacher) values(_subject,_teacher);
	END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `createAssignment` ()   BEGIN
	create table tblAssignment(
		ass_id int primary key AUTO_INCREMENT,
		assignment INT,
		student INT,
		deadline_date date,
		FOREIGN KEY (assignment) REFERENCES tblassignmentlist(ass_no),
		FOREIGN KEY (student) REFERENCES tblstudent(stud_id)
	)
	ENGINE = INNODB
	AUTO_INCREMENT = 1
	CHARACTER SET utf8mb4
	COLLATE utf8mb4_general_ci
	ROW_FORMAT = DYNAMIC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `createAssignmentList` ()   BEGIN
	create table tblAssignmentList(
		ass_no int primary key AUTO_INCREMENT,
		ass_title varchar(250) NOT NULL,
		total_score INT NOT NULL
	)
	ENGINE = INNODB
	AUTO_INCREMENT = 1
	CHARACTER SET utf8mb4
	COLLATE utf8mb4_general_ci
	ROW_FORMAT = DYNAMIC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `createtblStudent` ()   BEGIN
	create table tblStudent(
		stud_id int primary key AUTO_INCREMENT,
		fname varchar(50) NOT NULL,
		lname varchar(50) NOT NULL,
		gender varchar(10) NOT NULL,
		age INT NOT NULL
	)
	ENGINE = INNODB
	AUTO_INCREMENT = 1
	CHARACTER SET utf8mb4
	COLLATE utf8mb4_general_ci
	ROW_FORMAT = DYNAMIC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteAssignment` (IN `_ass_id` INT)   BEGIN
	delete from tblassignment where ass_id=_ass_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteAssignmentList` (IN `_ass_no` INT)   BEGIN
	delete from tblassignmentlist where ass_no = _ass_no;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteStudent` (IN `_stud_id` INT)   BEGIN
	delete from tblstudent where stud_id = _stud_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteSubject` (IN `_subjectId` INT)   BEGIN
	delete from tblsubject where subjectId=_subjectId;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `selectAssignment` (IN `search` VARCHAR(50))   BEGIN
	SELECT * FROM tblassignment left join tblassignmentlist on tblassignment.assignment = tblassignmentlist.ass_no 
                                left join tblstudent on tblassignment.student=tblstudent.stud_id left join tblsubject on tblassignmentlist.subject=tblsubject.subjectId 
                                where fname like search or lname like search or ass_title like search or subject_title like search or deadline_date like search order by lname asc, ass_title asc;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `selectAssignmentList` (IN `search` VARCHAR(50))   BEGIN
	SELECT * FROM tblassignmentlist left join tblsubject on tblassignmentlist.subject = tblsubject.subjectId 
                                where ass_title like search or total_score like search or subject_title like search order by ass_title asc;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `selectStudents` (IN `search` VARCHAR(50))   BEGIN 
SELECT * FROM tblStudent where fname like search or lname like search 
                                or gender like search or age like search order by lname asc;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `selectSubject` (IN `search` VARCHAR(50))   BEGIN 
SELECT * FROM tblsubject where subject_title like search order by subject_title asc;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateAssignment` (IN `_assignment` INT, IN `_student` INT, IN `_deadline_date` DATE, IN `_student_score` INT, IN `_ass_id` INT)   BEGIN
	update tblassignment set assignment=_assignment, student = _student, deadline_date=_deadline_date, student_score=_student_score where ass_id=_ass_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateAssignmentList` (IN `_ass_title` VARCHAR(250), IN `_total_score` VARCHAR(50), IN `_subjectId` INT, IN `_ass_no` INT)   BEGIN
	update tblassignmentlist set ass_title=_ass_title,total_score=_total_score,`subject`=_subjectId where ass_no = _ass_no;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateStudent` (IN `_fname` VARCHAR(50), IN `_lname` VARCHAR(50), IN `_gender` VARCHAR(10), IN `_age` INT, IN `_bdate` DATE, IN `_address` VARCHAR(100), IN `_stud_id` INT)   BEGIN
		update tblstudent set fname=_fname,lname=_lname,gender=_gender,age=_age,bdate=_bdate,address=_address where stud_id = _stud_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateSubject` (IN `_subject` VARCHAR(250), IN `_teacher` VARCHAR(50), IN `_subjectId` INT)   BEGIN
		update tblSubject set subject_title=_subject,teacher=_teacher where subjectId = _subjectId;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tblassignment`
--

CREATE TABLE `tblassignment` (
  `ass_id` int(11) NOT NULL,
  `assignment` int(11) DEFAULT NULL,
  `student` int(11) DEFAULT NULL,
  `deadline_date` date DEFAULT NULL,
  `student_score` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tblassignment`
--

INSERT INTO `tblassignment` (`ass_id`, `assignment`, `student`, `deadline_date`, `student_score`) VALUES
(22, 13, 20, '2023-10-25', 100),
(24, 13, 26, '2023-10-31', 20),
(25, 13, 23, '2023-10-19', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblassignmentlist`
--

CREATE TABLE `tblassignmentlist` (
  `ass_no` int(11) NOT NULL,
  `ass_title` varchar(250) NOT NULL,
  `total_score` int(11) NOT NULL,
  `subject` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tblassignmentlist`
--

INSERT INTO `tblassignmentlist` (`ass_no`, `ass_title`, `total_score`, `subject`) VALUES
(13, 'if else', 100, 14);

-- --------------------------------------------------------

--
-- Table structure for table `tblstudent`
--

CREATE TABLE `tblstudent` (
  `stud_id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `age` int(11) NOT NULL,
  `bdate` date DEFAULT NULL,
  `address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tblstudent`
--

INSERT INTO `tblstudent` (`stud_id`, `fname`, `lname`, `gender`, `age`, `bdate`, `address`) VALUES
(20, 'Jann Marie', 'Alibong', 'Female', 21, '2001-01-29', 'Day-as'),
(23, 'Myla', 'Vistal', 'Female', 20, '2002-11-25', 'Poblacion, Cordova'),
(26, 'Marienel', 'Retutas', 'Female', 11, '2023-10-10', 'Gabi');

-- --------------------------------------------------------

--
-- Table structure for table `tblsubject`
--

CREATE TABLE `tblsubject` (
  `subjectId` int(11) NOT NULL,
  `subject_title` varchar(255) DEFAULT NULL,
  `teacher` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tblsubject`
--

INSERT INTO `tblsubject` (`subjectId`, `subject_title`, `teacher`) VALUES
(14, 'Programming', 'Nick Amoin'),
(19, 'IM 2', 'Danny Obidas');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblassignment`
--
ALTER TABLE `tblassignment`
  ADD PRIMARY KEY (`ass_id`) USING BTREE,
  ADD KEY `assignment` (`assignment`) USING BTREE,
  ADD KEY `student` (`student`) USING BTREE;

--
-- Indexes for table `tblassignmentlist`
--
ALTER TABLE `tblassignmentlist`
  ADD PRIMARY KEY (`ass_no`) USING BTREE;

--
-- Indexes for table `tblstudent`
--
ALTER TABLE `tblstudent`
  ADD PRIMARY KEY (`stud_id`) USING BTREE;

--
-- Indexes for table `tblsubject`
--
ALTER TABLE `tblsubject`
  ADD PRIMARY KEY (`subjectId`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblassignment`
--
ALTER TABLE `tblassignment`
  MODIFY `ass_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tblassignmentlist`
--
ALTER TABLE `tblassignmentlist`
  MODIFY `ass_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tblstudent`
--
ALTER TABLE `tblstudent`
  MODIFY `stud_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tblsubject`
--
ALTER TABLE `tblsubject`
  MODIFY `subjectId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblassignment`
--
ALTER TABLE `tblassignment`
  ADD CONSTRAINT `tblassignment_ibfk_1` FOREIGN KEY (`assignment`) REFERENCES `tblassignmentlist` (`ass_no`),
  ADD CONSTRAINT `tblassignment_ibfk_2` FOREIGN KEY (`student`) REFERENCES `tblstudent` (`stud_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
