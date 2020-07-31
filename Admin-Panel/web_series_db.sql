-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 17, 2020 at 03:48 PM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_series_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `actor_list`
--

DROP TABLE IF EXISTS `actor_list`;
CREATE TABLE IF NOT EXISTS `actor_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `birth_name` varchar(20) DEFAULT NULL,
  `actor_img` varchar(255) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `about` longtext,
  `status` int(11) DEFAULT NULL,
  `cip` varchar(21) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `actor_list`
--

INSERT INTO `actor_list` (`id`, `name`, `birth_name`, `actor_img`, `gender`, `DOB`, `about`, `status`, `cip`, `cdate`) VALUES
(1, 'Jitendra Kumar', 'Jitendra Kumar', 'images/actor_dp/actor_img_1.jpg', '1', '1990-09-01', 'Jitendra Kumar (born 1 September 1990) is an Indian actor, mostly known for his work in web series. He is famous for his roles in comedy sketches of The Viral Fever. He is widely known for his characters Jeetu Bhaiya, Munna Jazbaati, Gittu and Arjun Kejriwal, (a parody version of Arvind Kejriwal, Indian politician & Delhi Chief Minister). He is also known for his role of Jeetu Bhaiya in Kota Factory , Aman Tripathi in Shubh Mangal Zyada Saavdhan with Ayushmann Khurrana and Abhishek Tripathi in Panchayat Amazon prime web series.', 1, '::1', '2020-06-17 03:47:09'),
(2, 'Maanvi Gagroo', 'Maanvi Gagroo', 'images/actor_dp/actor_img_2.jpg', '2', '1970-01-01', 'Maanvi Gagroo is an Indian film actress who has also worked in various web series. She began her career with the Disney Channel\'s television show Dhoom Machaao Dhoom in 2007. She is known for her work in web series like TVF Tripling, Made in Heaven and Four More Shots Please!', 1, '::1', '2020-06-17 03:47:17'),
(3, 'Naveen Kasturia', 'Naveen Kasturia', 'images/actor_dp/actor_img_3.jpg', '1', '1970-01-01', 'Naveen Kasturia is an Indian actor known for his work in TVF drama series - Pitchers. He started his career working as an assistant director on the film Jashnn and then assisted Dibakar Banerjee on Love Sex Aur Dhokha and Shanghai. He also appeared as the lead actor in the critically acclaimed film Sulemani Keeda.', 1, '::1', '2020-06-17 03:47:25'),
(4, 'Jaideep Ahlawat', '', 'images/actor_dp/actor_img_4.png', '1', '1970-01-01', 'Jaideep Ahlawat is an Indian film actor. He appeared in the Bollywood film Khatta Meetha, produced by Akshay Kumar; however, he is most noted for the role of Shahid Khan in Anurag Kashyap\'s Gangs of Wasseypur and as AK 74 in the movie Commando.', 1, '::1', '2020-06-17 03:47:35'),
(5, 'Vineet Kumar Singh', 'Vineet Kumar', 'images/actor_dp/actor_img_5.jpg', '1', '1980-01-15', 'Vineet Kumar is an Indian film actor and writer. After few series of performances in his early career including the 2010 film City of Gold, he got noticed for his role in films like Bombay Talkies and Gangs of Wasseypur.', 1, '::1', '2020-06-17 03:47:44');

-- --------------------------------------------------------

--
-- Table structure for table `actor_social_account`
--

DROP TABLE IF EXISTS `actor_social_account`;
CREATE TABLE IF NOT EXISTS `actor_social_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actor_id` int(11) DEFAULT NULL,
  `insta_link` varchar(255) DEFAULT NULL,
  `fb_link` varchar(255) DEFAULT NULL,
  `snapchat_link` varchar(255) DEFAULT NULL,
  `tiktok_link` varchar(255) DEFAULT NULL,
  `youtube_link` varchar(255) DEFAULT NULL,
  `twitter_link` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `cip` varchar(21) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `actor_social_account`
--

INSERT INTO `actor_social_account` (`id`, `actor_id`, `insta_link`, `fb_link`, `snapchat_link`, `tiktok_link`, `youtube_link`, `twitter_link`, `status`, `cip`, `cdate`) VALUES
(1, 1, ';upou', '', '', '', '', '', 1, '::1', '2020-06-01 04:56:33');

-- --------------------------------------------------------

--
-- Table structure for table `admin_table`
--

DROP TABLE IF EXISTS `admin_table`;
CREATE TABLE IF NOT EXISTS `admin_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `master_admin` int(1) NOT NULL DEFAULT '0',
  `name` varchar(100) DEFAULT NULL,
  `email_id` varchar(50) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `admin_img` varchar(255) DEFAULT NULL,
  `gender` int(1) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `address` longtext,
  `status` int(1) DEFAULT NULL,
  `cip` varchar(21) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_table`
--

INSERT INTO `admin_table` (`id`, `master_admin`, `name`, `email_id`, `phone`, `password`, `admin_img`, `gender`, `DOB`, `address`, `status`, `cip`, `cdate`) VALUES
(1, 1, 'Amrit', 'amr@gmail.com', '7887789755', '202cb962ac59075b964b07152d234b70', 'images/admin_dp/admin_img_1.png', 1, '1995-01-11', 'somewhere bruh..  ', 1, '::1', '2020-06-17 03:16:43'),
(2, 0, 'Admin 2', 'admin@gmail.com', '7000000001', '202cb962ac59075b964b07152d234b70', 'images/admin_dp/admin_img_2.jpg', 1, '1990-10-28', '', 1, '::1', '2020-06-17 03:17:14');

-- --------------------------------------------------------

--
-- Table structure for table `director_list`
--

DROP TABLE IF EXISTS `director_list`;
CREATE TABLE IF NOT EXISTS `director_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `real_name` varchar(20) DEFAULT NULL,
  `director_img` varchar(255) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `about` longtext,
  `status` int(11) DEFAULT NULL,
  `cip` varchar(21) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `director_list`
--

INSERT INTO `director_list` (`id`, `name`, `real_name`, `director_img`, `gender`, `DOB`, `about`, `status`, `cip`, `cdate`) VALUES
(1, 'Amit Golani', 'Amit Golani', 'images/director_dp/director_img_1.jpg', '1', '2020-12-20', 'Amit Golani is a writer and director, known for Humorously Yours (2016), Cubicles (2019) and Barely Speaking with Arnub (2014).', 1, '::1', '2020-06-17 12:29:03'),
(2, 'Rajesh Krishnan', 'Rajesh Krishnan', 'images/director_dp/director_img_2.jpg', '1', '1970-01-01', 'Rajesh Krishnan is an Indian melody playback singer and film actor. Although he is popularly known for his works in Kannada films, he has sung 5000 songs in Kannada, 500 in Telugu and more than 250 songs in Tamil, Hindi and other languages. Making his mainstream debut in the film Gauri Ganesha (1991), he has sung for many feature films, devotional albums, theme albums and commercials in a career spanning over almost two decades.', 1, '::1', '2020-06-17 12:29:14'),
(3, 'Neeraj Pandey', 'Neeraj Pandey', 'images/director_dp/director_img_3.jpg', '1', '1970-01-01', 'Neeraj Pandey is an Indian film director, producer and screenwriter. Pandey made his directoral debut in A Wednesday!, which was largely praised by audiences as well as critics and which later became a recipient of many accolades', 1, '::1', '2020-06-17 12:29:22'),
(6, 'Chaitanya Kumbhakonum', '', 'images/director_dp/director_img_6.png', '1', '1970-01-01', 'Directed series like Girls Hostel and Cubicles.', 1, '::1', '2020-06-17 12:29:30'),
(7, 'Patrick Graham', '', NULL, '1', '1979-01-24', 'Patrick Graham is an actor and writer, known for Ghoul (2018), Leila (2019) and Betaal (2020).', 1, '::1', '2020-06-08 03:28:27');

-- --------------------------------------------------------

--
-- Table structure for table `director_social_account`
--

DROP TABLE IF EXISTS `director_social_account`;
CREATE TABLE IF NOT EXISTS `director_social_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `director_id` int(11) DEFAULT NULL,
  `insta_link` varchar(255) DEFAULT NULL,
  `fb_link` varchar(255) DEFAULT NULL,
  `snapchat_link` varchar(255) DEFAULT NULL,
  `tiktok_link` varchar(255) DEFAULT NULL,
  `youtube_link` varchar(255) DEFAULT NULL,
  `twitter_link` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `cip` varchar(21) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `director_social_account`
--

INSERT INTO `director_social_account` (`id`, `director_id`, `insta_link`, `fb_link`, `snapchat_link`, `tiktok_link`, `youtube_link`, `twitter_link`, `status`, `cip`, `cdate`) VALUES
(1, 2, '@rajesh', '@rajesh', '@rajesh', '@rajesh', '@rajesh', '@rajesh', 1, '::1', '2020-05-29 01:22:15');

-- --------------------------------------------------------

--
-- Table structure for table `episode_list`
--

DROP TABLE IF EXISTS `episode_list`;
CREATE TABLE IF NOT EXISTS `episode_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `series_id` int(11) DEFAULT NULL,
  `season_id` int(11) DEFAULT NULL,
  `episode_no` varchar(25) DEFAULT NULL,
  `episode_name` varchar(255) DEFAULT NULL,
  `description` longtext,
  `episode_trailer_url` varchar(255) DEFAULT NULL,
  `episode_poster_img` varchar(255) DEFAULT NULL,
  `episode_duration` varchar(21) DEFAULT NULL,
  `actor_id` varchar(100) DEFAULT NULL,
  `director_id` varchar(100) DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `cip` varchar(21) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `episode_list`
--

INSERT INTO `episode_list` (`id`, `series_id`, `season_id`, `episode_no`, `episode_name`, `description`, `episode_trailer_url`, `episode_poster_img`, `episode_duration`, `actor_id`, `director_id`, `release_date`, `status`, `cip`, `cdate`) VALUES
(1, 1, 1, '1', 'Tu Beer Hai', 'Episode 1 Episode 1  Episode 1  Episode 1 Episode 1 Episode 1 Episode 1 Episode 1 Episode 1 Episode 1 Episode 1 Episode 1 ', '', 'images/episode_poster/666004674.jpg', '38:19', NULL, NULL, '2020-01-02', 1, '::1', '2020-06-09 05:03:02'),
(2, 1, 1, '2', 'And Then There Were Four', 'While the startup is the idea of the three friends â€“ Naveen, Jitu and Yogi â€“ Naveen\'s roommate and IIM graduate Saurabh Mandal wants to join, and needs to convince the trio that they need him.', '', NULL, '', NULL, NULL, NULL, 1, '::1', '2020-06-09 05:03:00'),
(3, 7, 5, '1', 'Dog Chase, Rat Race', 'Episode 1', '', NULL, '', NULL, NULL, '2019-05-24', 1, '::1', '2020-06-08 01:58:37'),
(4, 1, 1, '3', 'The Jury Room', 'Episode 3', '', 'images/episode_poster/episode_img_4.jpg', '43  mins 42 secs', NULL, NULL, '1970-01-01', 1, '::1', '2020-06-17 12:20:29');

-- --------------------------------------------------------

--
-- Table structure for table `platform`
--

DROP TABLE IF EXISTS `platform`;
CREATE TABLE IF NOT EXISTS `platform` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `about` longtext,
  `status` int(11) DEFAULT NULL,
  `cip` varchar(21) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `platform`
--

INSERT INTO `platform` (`id`, `name`, `url`, `logo`, `about`, `status`, `cip`, `cdate`) VALUES
(1, 'YouTube', 'https://www.youtube.com/', 'images/platform_logo/platform_img_1.png', 'A video hosting website by Google.', 1, '::1', '2020-06-17 12:46:43'),
(2, 'Netflix', 'https://www.netflix.com/', 'images/platform_logo/platform_img_2.png', 'Netflix, Inc. is an American media-services provider and production company headquartered in Los Gatos, California, founded in 1997 by Reed Hastings and Marc Randolph in Scotts Valley, California. ', 1, '::1', '2020-06-17 12:47:13'),
(3, 'Amazon Prime Video', 'https://www.primevideo.com/', 'images/platform_logo/platform_img_3.png', 'Prime Video, also marketed as Amazon Prime Video, is an American Internet video on demand service that is developed, owned, and operated by Amazon.', 1, '::1', '2020-06-17 12:47:23'),
(4, 'Hotstar', 'https://www.hotstar.com/', 'images/platform_logo/platform_img_4.jpg', 'Hotstar is an Indian over-the-top streaming service owned by Novi Digital Entertainment, a subsidiary of Star India.', 1, '::1', '2020-06-17 12:47:40'),
(5, 'Sony Liv', 'https://www.sonyliv.com/', 'images/platform_logo/platform_img_5.jpg', 'Sony Liv is an Indian general entertainment, video on demand service that is owned by Sony Pictures Networks India Pvt. Ltd., based in Mumbai, Maharashtra, India.', 1, '::1', '2020-06-17 12:48:57'),
(6, 'MX Player', 'https://www.mxplayer.in/', 'images/platform_logo/platform_img_6.png', 'MX Player is an Indian mobile video player app and an Indian over-the-top media streaming service, created by J2 Interactive now know as MX Media & Entertainment and owned by Times Internet, the digital media division of Times Group.', 1, '::1', '2020-06-17 12:49:25'),
(7, 'TVF Play', 'https://tvfplay.com/', 'images/platform_logo/platform_img_7.jpg', 'The Viral Fever is an online YouTube channel started by TVF Media Labs in 2010, and currently owned and operated by Contagious Online Media Network Private Limited.', 1, '::1', '2020-06-17 12:49:33'),
(8, 'Zee5', 'https://www.zee5.com/', 'images/platform_logo/platform_img_8.png', 'ZEE5 is an Indian video on demand service run by Essel Group via its subsidiary Zee Media Corporation Limited.', 1, '::1', '2020-06-17 12:49:45');

-- --------------------------------------------------------

--
-- Table structure for table `platform_social_account`
--

DROP TABLE IF EXISTS `platform_social_account`;
CREATE TABLE IF NOT EXISTS `platform_social_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `platform_id` int(11) DEFAULT NULL,
  `insta_link` varchar(255) DEFAULT NULL,
  `fb_link` varchar(255) DEFAULT NULL,
  `snapchat_link` varchar(255) DEFAULT NULL,
  `tiktok_link` varchar(255) DEFAULT NULL,
  `youtube_link` varchar(255) DEFAULT NULL,
  `twitter_link` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `cip` varchar(21) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `producer_list`
--

DROP TABLE IF EXISTS `producer_list`;
CREATE TABLE IF NOT EXISTS `producer_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `producer_img` varchar(255) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `about` longtext,
  `status` int(11) DEFAULT NULL,
  `cip` varchar(21) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `producer_list`
--

INSERT INTO `producer_list` (`id`, `name`, `producer_img`, `gender`, `DOB`, `about`, `status`, `cip`, `cdate`) VALUES
(1, 'Amrit', 'images/producer_dp/producer_img_1.jpg', '1', '1970-01-01', '', 1, '::1', '2020-06-17 12:41:09'),
(2, 'ALUMAN', 'images/producer_dp/producer_img_2.jpg', '1', '1995-01-11', 'ALUMANasdas', 1, '::1', '2020-06-17 12:41:33'),
(3, 'Gauri Khan', 'images/producer_dp/producer_img_3.jpg', '2', '1980-10-08', 'Gauri Khan, is an Indian film producer and designer who designed spaces for high-profile individuals such as Mukesh Ambani, Roberto Cavalli and Ralph Lauren, as well as Bollywood celebrities such as Karan Johar, Jacqueline Fernandez and Sidharth Malhotra. She is the co-founder and co-chairperson of the film production company Red Chillies Entertainment and its subsidiaries. In 2018, she was named as one of the Fortune magazine\'s 50 Most Powerful Women.', 1, '::1', '2020-06-17 12:41:25'),
(4, 'Vidhu Vinod Chopra', NULL, '1', '1952-09-05', 'Vidhu Vinod Chopra is an Indian film director, screenwriter and producer.[1] His better known films include Parinda, 1942: A Love Story , Munna Bhai film series (Munna Bhai M.B.B.S. and Lage Raho Munna Bhai), 3 Idiots, PK, Sanju and Ek Ladki Ko Dekha Toh Aisa Laga. He is the founder of Vinod Chopra Films and Vinod Chopra Productions.', 1, '::1', '2020-06-08 03:40:54');

-- --------------------------------------------------------

--
-- Table structure for table `producer_social_account`
--

DROP TABLE IF EXISTS `producer_social_account`;
CREATE TABLE IF NOT EXISTS `producer_social_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `producer_id` int(11) DEFAULT NULL,
  `insta_link` varchar(255) DEFAULT NULL,
  `fb_link` varchar(255) DEFAULT NULL,
  `snapchat_link` varchar(255) DEFAULT NULL,
  `tiktok_link` varchar(255) DEFAULT NULL,
  `youtube_link` varchar(255) DEFAULT NULL,
  `twitter_link` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `cip` varchar(21) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `season_list`
--

DROP TABLE IF EXISTS `season_list`;
CREATE TABLE IF NOT EXISTS `season_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `series_id` int(11) DEFAULT NULL,
  `season_name` varchar(50) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `season_trailer_url` varchar(255) DEFAULT NULL,
  `season_poster_img` varchar(255) DEFAULT NULL,
  `episode_count` int(11) DEFAULT NULL,
  `actor_id` varchar(100) DEFAULT NULL,
  `director_id` varchar(100) DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `cip` varchar(21) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `season_list`
--

INSERT INTO `season_list` (`id`, `series_id`, `season_name`, `description`, `season_trailer_url`, `season_poster_img`, `episode_count`, `actor_id`, `director_id`, `release_date`, `status`, `cip`, `cdate`) VALUES
(1, 1, 'Season 1', 'Season 1 of TVF PITCHERS', 'https://www.youtube.com/watch?v=hIU2CN34AXQ', 'images/season_poster/1049280907.jpg', NULL, '1|2|3', '1', '2015-01-11', 1, '::1', '2020-06-17 10:53:07'),
(2, 2, 'Season 1', 'Season 1 of TVF TRIPPLING', '', NULL, NULL, '2', '3', '2016-10-10', 1, '::1', '2020-06-08 01:57:41'),
(3, 2, 'Season 2', 'Season 2 of TVF Trippling', '', NULL, NULL, '2', '3', NULL, 1, '::1', '2020-06-08 01:57:35'),
(4, 5, 'Season 1', 'Season 1 of TVF KOTA FACTORY', '', NULL, NULL, '1', '', NULL, 1, '::1', '2020-06-08 01:34:29'),
(5, 7, 'Season 1', 'season 1 of Web Series Thinkistan', 'https://www.youtube.com/watch?v=NdeRMtHxpBE', NULL, NULL, '', '', '2019-05-21', 1, '::1', '2020-06-05 03:49:45'),
(6, 9, 'Season 1', '', '', 'images/season_poster/season_img_6.jpeg', NULL, '', '', '2016-11-05', 1, '::1', '2020-06-17 11:44:25');

-- --------------------------------------------------------

--
-- Table structure for table `series_list`
--

DROP TABLE IF EXISTS `series_list`;
CREATE TABLE IF NOT EXISTS `series_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `description` longtext,
  `trailer_url` varchar(255) DEFAULT NULL,
  `series_poster_img` varchar(255) DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `certificate` int(10) DEFAULT NULL,
  `imdb_rating` varchar(20) DEFAULT NULL,
  `r_tomato_rating` varchar(20) DEFAULT NULL,
  `season_count` varchar(21) DEFAULT NULL,
  `actor_id` varchar(100) DEFAULT NULL,
  `director_id` varchar(100) DEFAULT NULL,
  `platform_id` varchar(100) DEFAULT NULL,
  `genre` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `cip` varchar(21) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `series_list`
--

INSERT INTO `series_list` (`id`, `title`, `description`, `trailer_url`, `series_poster_img`, `release_date`, `certificate`, `imdb_rating`, `r_tomato_rating`, `season_count`, `actor_id`, `director_id`, `platform_id`, `genre`, `status`, `cip`, `cdate`) VALUES
(1, 'TVF Pitchers', 'The rising culture of Startups in India, much like \'The American Dream\', has led to a belief that anyone, irrespective of their family or educational background, can make it BIG. \nTVF Pitchers follows the story of four friends; Naveen, Jitu, Yogi and Mandal who Pitch their idea by day and sit over a Pitcher of beer by night', 'https://www.youtube.com/watch?v=xcUHB9n8Kws&t=8s', 'images/poster/series_img_1.jpg', '2015-01-11', 2, '9.2', NULL, 'undefined', '1|2|3', '1', '1|5|7', '2|5', 1, '::1', '2020-06-17 03:18:46'),
(2, 'TVF Trippling', 'It traces the story of three siblings Chandan, Chanchal & Chitvan. Together they start a hilarious journey, to find themselves and their relations.', 'https://www.youtube.com/watch?v=MfKNEC9xcE8&t=1s', 'images/poster/series_img_2.jpg', '1970-01-01', 2, '8.6', NULL, 'undefined', '', '', '1|5|7', '2|5|7', 1, '::1', '2020-06-17 10:31:25'),
(3, 'Special Ops', 'The action-packed story of the 19-year hunt for India\'s biggest enemy.', 'https://www.youtube.com/watch?v=GF0H5DZAE2g', 'images/poster/series_img_3.jpg', '1970-01-01', 3, '8.7', NULL, 'undefined', '', '', '', '1|3|5|16', 1, '::1', '2020-06-17 10:31:51'),
(5, 'TVF KOTA FACTORY', 'adas', '', 'images/poster/series_img_5.jpg', '1970-01-01', 2, '8.0', NULL, 'undefined', '', '', '', '2', 1, '::1', '2020-06-17 10:36:22'),
(6, 'TVF Cubicles', 'Deals with the life of two techie freshers, Piyush and his roommate in a MNC.', 'https://www.youtube.com/watch?v=y5NutvTDpHQ', 'images/poster/series_img_6.jpg', '1970-01-01', 2, '8.4', NULL, 'undefined', '', '', '1|7', '2|5|17', 1, '::1', '2020-06-17 10:36:56'),
(7, 'Thinkistan', 'Thinkistan is a drama-comedy web show by MX Player and is set in the Mumbai of the 90s. The show focuses on an advertising agency, MTMC agency which goes through a series of conflicts of North VS South, Hindi VS English and much more.', 'https://www.youtube.com/watch?v=NdeRMtHxpBE', 'images/poster/series_img_7.jpg', '2019-05-21', 3, '7.9', NULL, 'undefined', '3', '', '6', '5', 1, '::1', '2020-06-17 10:38:43'),
(8, 'Betaal', 'Hired to displace tribal villagers, highway officials unearth an old curse and an army of British soldier-zombies.', 'https://www.youtube.com/watch?v=YSEVaVc-nOo&t=2s', 'images/poster/series_img_8.jpg', '2020-05-24', 3, '5.4', NULL, 'undefined', '', '', '2', '9', 1, '::1', '2020-06-17 10:41:38'),
(9, 'The Aam Aadmi Family', 'The Aam Aadmi Family is an Indian comedy-drama series directed by Apoorv Singh Karki. The series debuted on a YouTube channel called The Timeliners, which garnered 10 million views. The first series featured Gunjan Malhotra, Chandan Anand, Kamlesh Gill, and Brijendra Kala', 'https://www.youtube.com/watch?v=pWdxttuQ2n4', 'images/poster/series_img_9.jpeg', '2016-11-05', 2, '8.5', NULL, 'undefined', '', '', '', '2', 1, '::1', '2020-06-17 10:28:50');

-- --------------------------------------------------------

--
-- Table structure for table `series_social_account`
--

DROP TABLE IF EXISTS `series_social_account`;
CREATE TABLE IF NOT EXISTS `series_social_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `series_id` int(11) DEFAULT NULL,
  `insta_link` varchar(255) DEFAULT NULL,
  `fb_link` varchar(255) DEFAULT NULL,
  `snapchat_link` varchar(255) DEFAULT NULL,
  `tiktok_link` varchar(255) DEFAULT NULL,
  `youtube_link` varchar(255) DEFAULT NULL,
  `twitter_link` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `cip` varchar(21) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `series_social_account`
--

INSERT INTO `series_social_account` (`id`, `series_id`, `insta_link`, `fb_link`, `snapchat_link`, `tiktok_link`, `youtube_link`, `twitter_link`, `status`, `cip`, `cdate`) VALUES
(1, 1, '', 'https://www.facebook.com/TVFPitchers/', '', '', '', 'https://twitter.com/tvfpitchers', 1, '::1', '2020-06-01 04:55:22'),
(2, 2, 'https://www.instagram.com/tvftripling/', 'https://www.facebook.com/TVFTripling/', '', '', '', 'https://twitter.com/tvftripling', 1, '::1', '2020-06-01 04:58:54');

-- --------------------------------------------------------

--
-- Table structure for table `writer_list`
--

DROP TABLE IF EXISTS `writer_list`;
CREATE TABLE IF NOT EXISTS `writer_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `writer_img` varchar(255) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `about` longtext,
  `status` int(11) DEFAULT NULL,
  `cip` varchar(21) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `writer_list`
--

INSERT INTO `writer_list` (`id`, `name`, `writer_img`, `gender`, `DOB`, `about`, `status`, `cip`, `cdate`) VALUES
(1, 'Some Writer', 'images/writer_dp/writer_img_1.jpg', '2', '1995-10-02', 'asdasd', 1, '::1', '2020-06-17 12:44:11'),
(2, 'Patrick Graham', 'images/writer_dp/writer_img_2.jpg', '1', '1979-01-24', 'Patrick Graham is an actor and writer, known for Ghoul (2018), Leila (2019) and Betaal (2020).', 1, '::1', '2020-06-17 12:44:20'),
(3, 'Suhani Kanwar', NULL, '2', '1980-01-01', 'Suhani Kanwar is an Indian movie assistant director whose is 2017 release includes Alankrita Shrivastavaâ€™s drama Lipstick Under My Burkha, which features Konkona Sen Sharma, Ratna Pathak, Aahana Kumra and Plabita Borthakur in pivotal roles.', 1, '::1', '2020-06-10 01:50:30');

-- --------------------------------------------------------

--
-- Table structure for table `writer_social_account`
--

DROP TABLE IF EXISTS `writer_social_account`;
CREATE TABLE IF NOT EXISTS `writer_social_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `writer_id` int(11) DEFAULT NULL,
  `insta_link` varchar(255) DEFAULT NULL,
  `fb_link` varchar(255) DEFAULT NULL,
  `snapchat_link` varchar(255) DEFAULT NULL,
  `tiktok_link` varchar(255) DEFAULT NULL,
  `youtube_link` varchar(255) DEFAULT NULL,
  `twitter_link` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `cip` varchar(21) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
