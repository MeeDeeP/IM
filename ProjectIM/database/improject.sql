-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 26, 2023 at 03:30 AM
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
-- Database: `improject`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `addStudent` (IN `_fname` VARCHAR(50), IN `_lname` VARCHAR(50), IN `_gender` VARCHAR(10), IN `_age` INT(11), IN `_address` VARCHAR(100), IN `_section` VARCHAR(10), OUT `ret` INT)   BEGIN
	DECLARE isExists int;
	set isExists = 0;
	
	select count(*) into isExists from tblstudent where fname=_fname and lname=_lname;
	
	set ret = isExists;
	if isExists = 0 then 
		insert into tblstudent(fname,lname,gender,age,address,section) values(_fname,_lname,_gender,_age,_address,_section);
	END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `createtblStudent` ()   BEGIN
	create table tblStudent(
		stud_id int primary key AUTO_INCREMENT,
		fname varchar(50) NOT NULL,
		lname varchar(50) NOT NULL,
		gender varchar(10) NOT NULL,
    address varchar(100) NOT NULL,
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateStudent` (IN `_fname` VARCHAR(50), IN `_lname` VARCHAR(50), IN `_gender` VARCHAR(10), IN `_age` INT(11), IN `_address` VARCHAR(100), IN `_section` VARCHAR(10), IN `_stud_id` INT)   BEGIN
		update tblstudent set fname=_fname,lname=_lname,gender=_gender,age=_age,address=_address,section=_section where stud_id = _stud_id;
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
  `age` int(11) NOT NULL,
  `address` varchar(100) NOT NULL,
  `section` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblstudent`
--

INSERT INTO `tblstudent` (`stud_id`, `fname`, `lname`, `gender`, `age`, `address`, `section`) VALUES
(1, 'Marienel', 'Retuas', 'Female', 21, 'Gabi, Cordova, Cebu', 'BSIT'),
(2, 'Rovic', 'Paradiang', 'Male', 21, 'Day-as, Cordova, Cebu', 'BSIT'),
(3, 'Daniella', 'Pelejotes', 'Female', 21, 'Poblacion, Cordova, Cebu', 'BSIT'),
(5, 'Nhovy Jasfer', 'Nacar', 'Male', 21, 'Catarman, Cordova, Cebu', 'BSIT'),
(6, 'Ejie', 'Otcheja', 'Male', 21, 'Bang-Bang Cordova Cebu', 'BSIT'),
(8, 'Enalin', 'Alabastro', 'Female', 21, 'Lapu, Lapu, City', 'BSIT');

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
(15, 'Marienel', 'Retutas', 'Maye', '0320116b2af221a6f673f93925b3fc62', 'Day-as, Cordova, Cebu', 'Marienel@gmail.com', '1', '2023-12-21 18:05:48', 1, 0),
(16, 'admin', '123', 'admin', '0192023a7bbd73250516f069df18b500', 'Poblacion, Cordova, Cebu', 'admin123@gmail.com', '2', '2023-12-21 18:09:36', 1, 0),
(17, 'Daniella', 'Pelejotes', 'Daniella', '6ad14ba9986e3615423dfca256d04e3f', 'Poblacion, Cordova, Cebu', 'daniella@gmail.com', '1', '2023-12-22 09:22:48', 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblstudent`
--
ALTER TABLE `tblstudent`
  ADD PRIMARY KEY (`stud_id`);

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
  MODIFY `stud_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
