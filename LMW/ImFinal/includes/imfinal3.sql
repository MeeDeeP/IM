-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2023 at 03:54 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `imfinal3`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `addStudent` (IN `_fname` VARCHAR(50), IN `_lname` VARCHAR(50), IN `_gender` VARCHAR(10), IN `_section` VARCHAR(10), OUT `ret` INT)   BEGIN
	DECLARE isExists int;
	set isExists = 0;
	
	select count(*) into isExists from tblstudent where fname=_fname and lname=_lname;
	
	set ret = isExists;
	if isExists = 0 then 
		insert into tblstudent(fname,lname,gender,section) values(_fname,_lname,_gender,_section);
	END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `createtblStudent` ()   BEGIN
	create table tblStudent(
		stud_id int primary key AUTO_INCREMENT,
		fname varchar(50) NOT NULL,
		lname varchar(50) NOT NULL,
		gender varchar(10) NOT NULL,
		section varchar(10) NOT NULL,
		age INT NOT NULL  
	)
	ENGINE = INNODB
	AUTO_INCREMENT = 1
	CHARACTER SET utf8mb4
	COLLATE utf8mb4_general_ci
	ROW_FORMAT = DYNAMIC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteStudent` (IN `_stud_id` INT)   BEGIN
	delete from tblstudent where stud_id = _stud_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `selectStudents` (IN `search` VARCHAR(50))   BEGIN 
SELECT * FROM tblStudent where fname like search or lname like search 
                                or gender like search  order by lname asc;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getUser` (IN `p_user_id` INT)   SELECT * from tbl_users where userid = p_user_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_login` (IN `spusername` TEXT, IN `sppassword` TEXT)   BEGIN

  SELECT
    *
  FROM users
  WHERE username = spusername AND password = sppassword;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_reg` (IN `p_userid` INT, IN `p_firstname` TEXT, IN `p_lastname` TEXT, IN `p_username` TEXT, IN `p_password` TEXT, IN `p_address` TEXT, IN `p_email` TEXT, IN `p_user_role` TEXT)   BEGIN

  if p_userid = 0 THEN
  insert into users(firstname,lastname,username,password,address,email,user_role,date_created,status)
  values(p_firstname,p_lastname,p_username,p_password,p_address,p_email,p_user_role,now(),1);

  else
    update users set firstname = p_firstname, lastname = p_lastname, username = p_username, address = p_address, email = p_email, user_role = p_user_role where userid = p_userid;
  end if;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update` (IN `sp_userid` TEXT, IN `sp_firstname` TEXT, IN `sp_lastname` TEXT, IN `sp_username` TEXT, IN `sp_address` TEXT, IN `sp_email` TEXT, IN `sp_user_role` TEXT, IN `sp_counterlock` INT)   BEGIN

  update users set firstname = sp_firstname, lastname = sp_lastname, username = sp_username, address = sp_address, email = sp_email, user_role = sp_user_role, counterlock = sp_counterlock where userid = sp_userid;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateStudent` (IN `_fname` VARCHAR(50), IN `_lname` VARCHAR(50), IN `_gender` VARCHAR(10), IN `_section` VARCHAR(10), IN `_stud_id` INT)   BEGIN
		update tblstudent set fname=_fname,lname=_lname,gender=_gender,section=_section where stud_id = _stud_id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tblstudent`
--

CREATE TABLE `tblstudent` (
  `stud_id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `section` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tblstudent`
--

INSERT INTO `tblstudent` (`stud_id`, `fname`, `lname`, `gender`, `section`) VALUES
(32, 'welmark', 'Sevellita', 'Male', 'BEED');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `address` text NOT NULL,
  `email` text NOT NULL,
  `user_role` text NOT NULL,
  `date_created` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `counterlock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `firstname`, `lastname`, `username`, `password`, `address`, `email`, `user_role`, `date_created`, `status`, `counterlock`) VALUES
(6, 'Mark', 'Degamo', 'markdegamo', '912ec803b2ce49e4a541068d495ab570', 'Gabi Cordova Cebu', 'markdegamo@gmail.com', '1', '2023-12-14 01:13:04', 2, 0),
(7, 'Levi', 'Berdin', 'leviberdin', '912ec803b2ce49e4a541068d495ab570', 'Babag I', 'leviberdin@gmail.com', '1', '2023-12-14 01:13:36', 1, 0),
(8, 'Welmark', 'Sevilleta', 'welmarksevilleta', '912ec803b2ce49e4a541068d495ab570', 'Babag II', 'welmark@gmail.com', '2', '2023-12-14 01:29:38', 1, 0),
(10, 'Laren', 'Inoc', 'lareninoc', '912ec803b2ce49e4a541068d495ab570', 'Kasadya', 'laren@gmail.com', '1', '2023-12-14 03:02:10', 1, 0),
(11, 'Joseph', 'Vilonta', 'josephvilonta', '912ec803b2ce49e4a541068d495ab570', 'Bangbang', 'joseph@gmail.com', '1', '2023-12-14 03:26:42', 1, 0),
(12, 'Ferlen', 'Respuesto', 'ferlenrespuesto', '912ec803b2ce49e4a541068d495ab570', 'Day-as', 'ferlen@gmail.com', '1', '2023-12-14 16:25:03', 1, 0),
(13, 'Welmark', 'Sevellita', 'miggy', 'ffed1b5b1d266cb62813121b5c57021e', 'Babag2', 'welmarksevellita@gmail.com', '1', '2023-12-15 12:13:16', 1, 0),
(14, 'Welmark', 'Sevellita', 'miggy', '7815696ecbf1c96e6894b779456d330e', 'Babag2', 'miggysevellita@gmail.com', '1', '2023-12-15 21:25:03', 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblstudent`
--
ALTER TABLE `tblstudent`
  ADD PRIMARY KEY (`stud_id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblstudent`
--
ALTER TABLE `tblstudent`
  MODIFY `stud_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
