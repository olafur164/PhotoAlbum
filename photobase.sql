-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2015 at 10:22 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `photobase`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `CategoryList`()
begin
	select categoryID, categoryName from Categories order by categoryName;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CheckUser`(IN `user_name` VARCHAR(15), IN `user_id` INT)
    NO SQL
begin
	select * from users
    where userName = user_name OR
    userID = user_id;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `DeleteCategory`(category_id int)
begin
	if not exists(select categoryID from Images where categoryID = category_id) then
		delete from categories where categoryID = category_id;
	end if;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `DeleteImage`(image_id int)
begin
	delete from Images where imageID = image_id;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `DeleteUser`(user_id int)
begin
	update Users set activity = 0 where userId = user_id;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetCategory`(category_id int)
begin
	declare numberOfImages int;
    
    select count(categoryID) into numberOfImages from Images where categoryID = category_id;
	select categoryID,categoryName,numberOfImages from Categories where categoryID = category_id;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetImage`(IN `image_id` INT, IN `user_id` INT)
begin
	select *
    from Images I
    where I.imageID = image_id
    and I.userID = user_id;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetUser`(IN `user_name` VARCHAR(15))
begin
	select userID,firstName,lastName,userEmail,userName,userPassword,accessLevel
    from Users
    where userName = user_name and activity = 1;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetUserId`(IN `user_id` INT)
    NO SQL
begin
	select userID,firstName,lastName,userEmail,userName,accessLevel
    from Users
    where userID = user_id and activity = 1;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetUserImages`(IN `user_id` INT)
    NO SQL
begin
	select *
    from Images I
    WHERE I.userID = user_id
    order by I.ImageID desc;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ImageList`()
begin
	select I.imageID,I.imageName, I.imagePath, I.imageText, C.categoryName
    from Images I
    inner join Categories C on I.categoryID = C.categoryID;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `NewCategory`(category_name varchar(45))
begin
	insert into Categories(categoryName)values(category_name); 
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `NewImage`(IN `image_name` VARCHAR(45), IN `image_file` VARCHAR(255), IN `image_text` VARCHAR(155), IN `category_id` INT, IN `user_id` INT)
begin
	insert into Images(imageName,imageFile,imageText,categoryID,userID)
    values(image_name,image_file,image_text,category_id,user_id);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `NewUser`(IN `first_name` VARCHAR(55), IN `last_name` VARCHAR(55), IN `user_email` VARCHAR(125), IN `user_name` VARCHAR(15), IN `user_password` VARCHAR(255))
begin
	insert into Users(firstName,lastName,userEmail,userName,userPassword)
	values(first_name,last_name,user_email,user_name,user_password);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ResetUser`(user_id int)
begin
	update Users set activity = 1 where userId = user_id;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateCategory`(category_name varchar(45), category_id int)
begin
	update Categories set categoryName = category_name 
	where categoryID = category_id;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateImage`(IN `image_id` INT, IN `image_name` VARCHAR(155))
begin
	update Images set imageText = image_name
    where imageID = image_id;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateUser`(IN `user_id` INT, IN `first_name` VARCHAR(55), IN `last_name` VARCHAR(55), IN `user_email` VARCHAR(125), IN `user_name` VARCHAR(15), IN `user_password` VARCHAR(255))
begin
	update Users 
    set firstName = first_name,lastName = last_name,userEmail = user_email,userName = user_name,userPassword = user_password
	where userId = user_id and activity = 1;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UserList`()
begin
	select userID,firstName,lastName,userName
    from Users where activity = 1;
end$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `SetAccessLevel`(access_level tinyint,user_id int,admin_id int) RETURNS int(11)
begin
	if(select accessLevel from Users where userID = admin_id) = 3 then
		update Users set accessLevel = access_level where userID = user_id and activity = 1;
        return access_level;
	else
		return(select accessLevel from Users where userID = user_id and activity = 1);
	end if;
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `ValidateUser`(`user_name` VARCHAR(15), `user_pass` VARCHAR(255)) RETURNS int(11)
begin
	if exists(select userID from Users where userName = user_name and userPassword = user_pass and activity = 1) then
		return 1;
	else
		return 0;
	end if;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
`categoryID` int(11) NOT NULL,
  `categoryName` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categoryID`, `categoryName`) VALUES
(1, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
`imageID` int(11) NOT NULL,
  `imageName` varchar(155) CHARACTER SET utf8 COLLATE utf8_icelandic_ci DEFAULT NULL,
  `imageFile` varchar(255) CHARACTER SET utf8 COLLATE utf8_icelandic_ci DEFAULT NULL,
  `imageText` varchar(155) DEFAULT NULL,
  `categoryID` int(11) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  `imageSize` varchar(25) DEFAULT NULL,
  `imageType` varchar(15) DEFAULT NULL,
  `imageDate` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`userID` int(11) NOT NULL,
  `firstName` varchar(55) NOT NULL,
  `lastName` varchar(55) NOT NULL,
  `userEmail` varchar(125) NOT NULL,
  `userName` varchar(15) NOT NULL,
  `userPassword` varchar(255) NOT NULL,
  `accessLevel` tinyint(4) DEFAULT '1',
  `activity` bit(1) DEFAULT b'1'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `firstName`, `lastName`, `userEmail`, `userName`, `userPassword`, `accessLevel`, `activity`) VALUES
(1, 'Ólafur Hólm', 'Eyþórsson', 'olafurholm17@gmail.com', 'olafur164', '$2y$10$velJpV9ucHmsXxFaYMGKVed1taJk01tPThzACDqi/t2DC4gibJIkK', 1, b'1'),
(2, 'kennari', 'kennari2', 'kennari@kennari.is', 'kennari', '$2y$10$0xv7llizh2xV1uEACRiFBORzhHgyvVVshxByy.gviPelKGH5jUu7m', 1, b'1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
 ADD PRIMARY KEY (`categoryID`), ADD UNIQUE KEY `categoryname_NQ` (`categoryName`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
 ADD PRIMARY KEY (`imageID`), ADD KEY `image_category_FK` (`categoryID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`userID`), ADD UNIQUE KEY `username_NQ` (`userName`), ADD UNIQUE KEY `useremail_NQ` (`userEmail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
MODIFY `categoryID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
MODIFY `imageID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `images`
--
ALTER TABLE `images`
ADD CONSTRAINT `image_category_FK` FOREIGN KEY (`categoryID`) REFERENCES `categories` (`categoryID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
