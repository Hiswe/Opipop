-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 19, 2010 at 03:44 PM
-- Server version: 5.1.47
-- PHP Version: 5.3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `opipop`
--

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE IF NOT EXISTS `answer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `answer`
--

INSERT INTO `answer` (`id`, `label`) VALUES
(1, 'oui'),
(2, 'non'),
(3, 'avec'),
(4, 'sans'),
(5, 'pour'),
(6, 'contre'),
(7, 'ski'),
(8, 'plage'),
(9, 'action'),
(10, 'romantique'),
(11, 'dessus'),
(12, 'dessous'),
(13, 'tuer une personne'),
(14, 'ne pas travailler'),
(15, '');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `position` int(10) unsigned NOT NULL DEFAULT '0',
  `label` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `guid` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `status`, `position`, `label`, `guid`) VALUES
(1, 1, 1, 'Common', 'common'),
(2, 1, 2, 'Sexy', 'sexy');

-- --------------------------------------------------------

--
-- Table structure for table `feeling`
--

CREATE TABLE IF NOT EXISTS `feeling` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `feeling`
--

INSERT INTO `feeling` (`id`, `label`) VALUES
(1, 'none'),
(2, 'personality'),
(3, 'surroundings'),
(4, 'knowledge'),
(5, 'experience'),
(6, 'thoughts'),
(7, 'Sensibilité');

-- --------------------------------------------------------

--
-- Table structure for table `friend`
--

CREATE TABLE IF NOT EXISTS `friend` (
  `user_id_1` int(10) unsigned NOT NULL,
  `user_id_2` int(10) unsigned NOT NULL,
  `valided` tinyint(1) NOT NULL DEFAULT '0',
  `date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id_1`,`user_id_2`),
  KEY `user_id_2` (`user_id_2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `friend`
--

INSERT INTO `friend` (`user_id_1`, `user_id_2`, `valided`, `date`) VALUES
(1, 2, 1, 1264621283),
(1, 4, 1, 1270913739),
(1, 5, 0, 1276456331),
(3, 1, 1, 1264621446),
(5, 2, 1, 1270913835),
(5, 4, 0, 1270913901),
(6, 1, 0, 1282175396);

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `date` int(10) unsigned NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `didyouknow` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=38 ;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `category_id`, `status`, `date`, `label`, `didyouknow`) VALUES
(1, 1, 1, 1267808975, 'Apréciez vous la musique Punk hardcore ?', 'Le puck hardcore est apprécié par {PERCENT_1}% des gens'),
(2, 1, 1, 1267895375, 'Avez vous un parapluie ?', '{PERCENT_1}% des gens possèdent un parapluie'),
(3, 1, 1, 1267981775, 'Aimez vous bob l''éponge ?', 'Bob l''éponge est une star pour {PERCENT_1}% des gens'),
(4, 1, 1, 1268068175, 'Buvez vous votre thé avec ou sans sucre ?', 'Le thé se boit sans sucre pour {PERCENT_2}% des gens'),
(5, 1, 1, 1268154575, 'Pouriez vous manger un pot entier de nutella ?', '{PERCENT_1}% des gens disent pouvoir manger un port entier de nutella !'),
(14, 1, 1, 1268932175, 'Aimez vous les fessées ?', 'Hummm {PERCENT_1}% des gens aiment les fessées'),
(15, 1, 1, 1269018575, 'Possedez vous des bottes ?', '{PERCENT_1}% des gens sont en possession de botes.'),
(16, 1, 1, 1269104975, 'Mangez vous au moins 5 fruits et légumes par jour ?', 'Au moins 5 fruits et légumes par jour, un régime respecté par {PERCENT_1}% des gens'),
(17, 1, 1, 1269191375, 'Possedez vous un véhicule ?', '{PERCENT_1}% des gens possèdent un véhicule'),
(18, 1, 1, 1269277775, 'Vous baladez vous toujours avec une pièce d''identité ?', '{PERCENT_2}% des gens se balandent sans pièce d''identité'),
(19, 1, 1, 1269364175, 'Ecrivez vous vos emails sans fautes d''hortographe ?', 'Les mails avec fautes d''horographes c''est {PERCENT_1}% des mails'),
(20, 1, 1, 1269450575, 'Avez vous déjà vue un éléphant ?', 'Les elephant ont était vue par {PERCENT_1}% des gens'),
(21, 1, 1, 1269536975, 'Pour ou contre les nains ?', 'Attention les nains : {PERCENT_2}% de gens contre'),
(22, 1, 1, 1269623375, 'Aimez vous les frites ?', 'Les frites on aime a {PERCENT_1}%'),
(23, 1, 1, 1269709775, 'Oui ou non ?', 'Oui a {PERCENT_1}%'),
(24, 1, 1, 1269796175, 'Voulez vous un poney ?', '{PERCENT_2}% des gens s''en foutent d''avoir un poney'),
(25, 1, 1, 1269882575, 'Est ce que vous préférez vos frites avec ou sans ketchup ?', 'Pour {PERCENT_1}% des gens les frites se mangent avec du ketchup !'),
(26, 1, 1, 1269968975, 'Pour ou contre Yannick ?', 'Yannick attention, {PERCENT_2}% sont contre toi !'),
(27, 1, 1, 1270055375, 'Pour ou contre la fin du monde', 'La fin du monde approche, {PERCENT_1}% des gens sont pour !'),
(28, 1, 1, 1270141775, 'Pour on contre les sondages ?', '{PERCENT_1}% des gens sont pour les sondages !'),
(29, 1, 1, 1270228175, 'Aimez vous les fraises tagada ?', '{PERCENT_2}% des gens n''aime pas les fraises tagada !'),
(30, 2, 1, 1270314575, 'Possédez vous au moins un sex toys ?', '{PERCENT_1}% des gens se branlent avec un sex toys'),
(31, 1, 1, 1270400975, 'Aimez vous votre soda frai avec ou sans glaçons ?', 'Le soda ce bois sans glaçon pour {PERCENT_2}% des gens'),
(32, 1, 1, 1270487375, 'Etes vous plutôt vacances au ski ou vacances a la plage ?', 'Vacances au ski ou vacances a la plage ? {PERCENT_2}% des gens preferent la plage'),
(33, 1, 1, 1270573775, 'Que préférez vous : les film d''action ou les commedies romantiques ?', '{PERCENT_1}% des gens preferent les films d''action aux films romantiques'),
(34, 2, 1, 1270660175, 'Avez vous déjà pratiqué la sodomie ?', 'La sodomie n''est plus un secret pour {PERCENT_1}% des gens'),
(35, 2, 1, 1270746575, 'Que préférez vous : être au dessus ou bien au dessous ?', '{PERCENT_1}% des gens préfèrent être au dessus !'),
(36, 1, 1, 1270832975, 'Préfèrez vous avoir le droit de tuer une personne ou celui de ne pas travailler pendant 1 ans ?', '{PERCENT_1}% des gens préférent tuer une personne que de ne pas travailler pendant 1 ans'),
(37, 1, 1, 1276356285, 'Vous croyez vous plus intelligent que la moyenne ?', '{PERCENT_1}% des gens se croient plus intelligent que la moyenne.');

-- --------------------------------------------------------

--
-- Table structure for table `question_answer_feeling`
--

CREATE TABLE IF NOT EXISTS `question_answer_feeling` (
  `question_id` int(10) unsigned NOT NULL,
  `answer_id` int(10) unsigned NOT NULL,
  `feeling_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`question_id`,`answer_id`),
  KEY `answer_id` (`answer_id`),
  KEY `feeling_id` (`feeling_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `question_answer_feeling`
--

INSERT INTO `question_answer_feeling` (`question_id`, `answer_id`, `feeling_id`) VALUES
(1, 2, 1),
(2, 1, 1),
(2, 2, 1),
(3, 2, 1),
(4, 3, 1),
(5, 2, 1),
(14, 2, 1),
(15, 2, 1),
(16, 2, 1),
(17, 1, 1),
(18, 1, 1),
(18, 2, 1),
(20, 2, 1),
(21, 5, 1),
(21, 6, 1),
(22, 1, 1),
(22, 2, 1),
(23, 1, 1),
(23, 2, 1),
(24, 2, 1),
(25, 3, 1),
(25, 4, 1),
(26, 5, 1),
(26, 6, 1),
(29, 1, 1),
(29, 2, 1),
(30, 2, 1),
(31, 3, 1),
(34, 2, 1),
(36, 14, 1),
(4, 4, 2),
(15, 1, 2),
(19, 1, 2),
(27, 5, 2),
(28, 6, 2),
(31, 4, 2),
(33, 10, 2),
(35, 11, 2),
(17, 2, 3),
(27, 6, 3),
(32, 8, 3),
(37, 1, 3),
(3, 1, 4),
(19, 2, 4),
(28, 5, 4),
(37, 2, 4),
(1, 1, 5),
(5, 1, 5),
(14, 1, 5),
(20, 1, 5),
(30, 1, 5),
(32, 7, 5),
(33, 9, 5),
(34, 1, 5),
(16, 1, 6),
(24, 1, 6),
(35, 12, 6),
(36, 13, 6);

-- --------------------------------------------------------

--
-- Table structure for table `submition`
--

CREATE TABLE IF NOT EXISTS `submition` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `response1` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `response2` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `submition`
--

INSERT INTO `submition` (`id`, `question`, `response1`, `response2`) VALUES
(1, 'prout', '', ''),
(2, 'caca', '', ''),
(3, 'regr', '', ''),
(4, 'regerg', '', ''),
(5, 'grerg', '', ''),
(6, 'regreg', '', ''),
(7, 'titi', 'toto', 'tata'),
(8, 'efew', 'efew', 'efew');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `valided` binary(1) NOT NULL DEFAULT '0',
  `male` tinyint(1) NOT NULL DEFAULT '1',
  `zip` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `login` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(320) COLLATE utf8_unicode_ci NOT NULL,
  `register_date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `valided`, `male`, `zip`, `login`, `password`, `key`, `email`, `register_date`) VALUES
(1, '1', 1, 12, 'XPac27', '2fb79ab9685ea3b8e82385daca76a390', '34a6494fd049bb358d75c0a72a16ac7e', 'xpac27@gmail.com', 0),
(2, '1', 1, 12, 'Calamouth', '08cfbdda83fcf6e571708329be1d8efc', 'f3d9b2b3f447c046ed99bf1149b889f6', 'calamouth@gmail.com', 1260284126),
(3, '1', 1, 12, 'Hiswe', '2a7447762dd886b4fd61ae9ee6b9552a', 'd6250dff63325821db2829e3d3696d8f', 'hiswehalya@gmail.com', 1260830578),
(4, '1', 1, 12, 'Hugo', '098f6bcd4621d373cade4e832627b4f6', 'c159b961767752f73f2bc5ee7ad35133', 'xpac11@gmail.com', 1261766997),
(5, '1', 0, 12, 'Mathilde', '098f6bcd4621d373cade4e832627b4f6', 'e7b3b88b89c1876fdc034484832aa05c', 'mcogne@gmai.com', 1261947012),
(6, '1', 0, 1, 'Patric', '670b14728ad9902aecba32e22fa4f6bd', 'eace1416cc66da1b92b44b778c82d5f5', 'patric@test.com', 1282174745);

-- --------------------------------------------------------

--
-- Table structure for table `user_guess`
--

CREATE TABLE IF NOT EXISTS `user_guess` (
  `question_id` int(10) unsigned NOT NULL,
  `answer_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`question_id`,`answer_id`,`user_id`),
  KEY `question_id` (`question_id`),
  KEY `answer_id` (`answer_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_guess`
--

INSERT INTO `user_guess` (`question_id`, `answer_id`, `user_id`, `date`) VALUES
(1, 1, 5, 1270914740),
(1, 2, 1, 1270914280),
(1, 2, 2, 1270915000),
(1, 2, 3, 1270915159),
(2, 1, 3, 1270915210),
(2, 2, 1, 1270914343),
(2, 2, 5, 1270914850),
(3, 1, 1, 1270914401),
(3, 1, 2, 1270915086),
(3, 1, 3, 1270915213),
(3, 1, 5, 1270914863),
(4, 3, 2, 1270915099),
(4, 4, 1, 1270914405),
(4, 4, 3, 1270915218),
(4, 4, 5, 1270914870),
(5, 1, 2, 1270915103),
(5, 1, 3, 1270915223),
(5, 2, 1, 1270914410),
(5, 2, 5, 1270914875),
(14, 1, 3, 1270915226),
(14, 1, 5, 1270914882),
(14, 2, 1, 1270914413),
(14, 2, 2, 1270915113),
(15, 1, 1, 1270914419),
(15, 1, 2, 1270915123),
(15, 1, 5, 1270914891),
(15, 2, 3, 1270915232),
(16, 1, 1, 1270914422),
(16, 1, 2, 1270915130),
(16, 2, 3, 1270915239),
(17, 1, 1, 1270914427),
(17, 2, 3, 1270915247),
(18, 1, 3, 1270915253),
(18, 2, 1, 1270914430),
(18, 2, 2, 1270915141),
(19, 2, 1, 1270914434),
(19, 2, 3, 1270915260),
(20, 1, 1, 1270914340),
(20, 1, 5, 1270914841),
(21, 5, 3, 1270915204),
(21, 6, 1, 1270914337),
(21, 6, 5, 1270914837),
(22, 1, 1, 1270914333),
(22, 1, 5, 1270914827),
(22, 2, 2, 1270915082),
(23, 1, 1, 1270914302),
(23, 1, 3, 1270915164),
(23, 2, 2, 1270915007),
(23, 2, 5, 1270914749),
(24, 1, 2, 1270915015),
(24, 2, 1, 1270914305),
(24, 2, 5, 1270914756),
(25, 3, 5, 1270914763),
(25, 4, 1, 1270914308),
(25, 4, 2, 1270915025),
(25, 4, 3, 1270915176),
(26, 5, 3, 1270915180),
(26, 5, 5, 1270914772),
(26, 6, 1, 1270914311),
(27, 5, 1, 1270914314),
(27, 6, 2, 1270915035),
(27, 6, 3, 1270915184),
(27, 6, 5, 1270914780),
(28, 5, 2, 1270915042),
(28, 5, 5, 1270914789),
(28, 6, 1, 1270914318),
(28, 6, 3, 1270915190),
(29, 1, 2, 1270915051),
(29, 1, 5, 1270914798),
(29, 2, 1, 1270914321),
(29, 2, 3, 1270915197),
(31, 3, 2, 1270915058),
(31, 3, 5, 1270914806),
(31, 4, 1, 1270914324),
(32, 7, 1, 1281292367),
(32, 7, 5, 1270914813),
(32, 8, 2, 1270915063),
(33, 9, 1, 1281292574),
(33, 9, 5, 1270914820),
(33, 10, 2, 1270915069),
(36, 13, 1, 1270914438),
(36, 13, 2, 1270915148),
(36, 14, 3, 1270915263),
(37, 2, 1, 1281341078);

-- --------------------------------------------------------

--
-- Table structure for table `user_guess_friend`
--

CREATE TABLE IF NOT EXISTS `user_guess_friend` (
  `question_id` int(10) unsigned NOT NULL,
  `answer_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `friend_id` int(10) unsigned NOT NULL,
  `date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`question_id`,`answer_id`,`user_id`,`friend_id`),
  KEY `answer_id` (`answer_id`),
  KEY `user_id` (`user_id`),
  KEY `friend_id` (`friend_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_guess_friend`
--

INSERT INTO `user_guess_friend` (`question_id`, `answer_id`, `user_id`, `friend_id`, `date`) VALUES
(1, 1, 1, 4, 1270914509),
(1, 1, 1, 5, 1270914509),
(1, 1, 2, 1, 1270915004),
(1, 1, 3, 1, 1270915161),
(1, 1, 5, 1, 1270914743),
(1, 2, 1, 2, 1270914509),
(1, 2, 1, 3, 1270914509),
(1, 2, 2, 5, 1270915004),
(1, 2, 5, 2, 1270914743),
(2, 1, 1, 4, 1270914624),
(2, 1, 5, 1, 1270914854),
(2, 2, 1, 2, 1270914624),
(2, 2, 1, 3, 1270914624),
(2, 2, 1, 5, 1270914624),
(2, 2, 5, 2, 1270914854),
(3, 1, 1, 2, 1270914629),
(3, 1, 1, 4, 1270914629),
(3, 1, 1, 5, 1270914629),
(3, 1, 2, 5, 1270915091),
(3, 1, 5, 1, 1270914863),
(3, 2, 1, 3, 1270914629),
(3, 2, 2, 1, 1270915091),
(3, 2, 5, 2, 1270914863),
(4, 3, 1, 3, 1270914634),
(4, 3, 1, 5, 1270914634),
(4, 3, 2, 1, 1270915094),
(4, 3, 5, 2, 1270914868),
(4, 4, 1, 2, 1270914634),
(4, 4, 1, 4, 1270914634),
(4, 4, 2, 5, 1270915094),
(4, 4, 5, 1, 1270914869),
(5, 1, 1, 2, 1270914638),
(5, 1, 1, 3, 1270914638),
(5, 1, 1, 4, 1270914638),
(5, 1, 1, 5, 1270914638),
(5, 1, 2, 1, 1270915107),
(5, 1, 2, 5, 1270915107),
(5, 1, 3, 1, 1270915221),
(5, 1, 5, 1, 1270914877),
(5, 2, 5, 2, 1270914878),
(14, 1, 1, 2, 1270914644),
(14, 1, 2, 5, 1270915115),
(14, 1, 3, 1, 1270915228),
(14, 1, 5, 1, 1270914885),
(14, 2, 1, 3, 1270914644),
(14, 2, 1, 4, 1270914644),
(14, 2, 1, 5, 1270914644),
(14, 2, 5, 2, 1270914885),
(15, 1, 1, 2, 1270914650),
(15, 1, 1, 5, 1270914650),
(15, 1, 2, 1, 1270915119),
(15, 2, 1, 3, 1270914650),
(15, 2, 1, 4, 1270914650),
(15, 2, 2, 5, 1270915121),
(15, 2, 3, 1, 1270915234),
(16, 1, 2, 1, 1270915128),
(16, 2, 1, 2, 1270914656),
(16, 2, 1, 3, 1270914656),
(16, 2, 1, 4, 1270914656),
(16, 2, 1, 5, 1270914656),
(16, 2, 3, 1, 1270915241),
(17, 1, 1, 4, 1270914662),
(17, 1, 3, 1, 1270915246),
(17, 2, 1, 2, 1270914662),
(17, 2, 1, 3, 1270914662),
(17, 2, 1, 5, 1270914662),
(18, 1, 1, 2, 1270914667),
(18, 1, 1, 4, 1270914667),
(18, 1, 2, 1, 1270915139),
(18, 1, 3, 1, 1270915251),
(18, 1, 5, 1, 1270914899),
(18, 2, 1, 3, 1270914667),
(18, 2, 1, 5, 1270914667),
(18, 2, 2, 5, 1270915139),
(18, 2, 5, 2, 1270914899),
(19, 1, 1, 4, 1270914671),
(19, 1, 3, 1, 1270915257),
(19, 2, 1, 2, 1270914671),
(19, 2, 1, 3, 1270914671),
(19, 2, 1, 5, 1270914671),
(19, 2, 5, 1, 1270914902),
(19, 2, 5, 2, 1270914902),
(20, 1, 5, 1, 1270914845),
(20, 2, 1, 2, 1270914619),
(20, 2, 1, 3, 1270914619),
(20, 2, 1, 4, 1270914619),
(20, 2, 1, 5, 1270914619),
(20, 2, 5, 2, 1270914845),
(21, 5, 5, 1, 1270914833),
(21, 6, 1, 2, 1270914613),
(21, 6, 1, 3, 1270914613),
(21, 6, 1, 4, 1270914613),
(21, 6, 1, 5, 1270914613),
(21, 6, 5, 2, 1270914833),
(22, 1, 1, 2, 1270914607),
(22, 1, 1, 3, 1270914607),
(22, 1, 1, 4, 1270914607),
(22, 1, 1, 5, 1270914607),
(22, 1, 2, 1, 1270915080),
(22, 1, 2, 5, 1270915080),
(22, 1, 5, 1, 1270914830),
(22, 2, 5, 2, 1270914830),
(23, 1, 1, 2, 1270914522),
(23, 1, 1, 3, 1270914522),
(23, 1, 2, 1, 1270915010),
(23, 1, 3, 1, 1270915166),
(23, 1, 5, 2, 1270914751),
(23, 2, 1, 4, 1270914522),
(23, 2, 1, 5, 1270914522),
(23, 2, 2, 5, 1270915010),
(23, 2, 5, 1, 1270914751),
(24, 1, 1, 2, 1270914558),
(24, 1, 1, 5, 1270914558),
(24, 1, 2, 1, 1270915019),
(24, 2, 1, 3, 1270914558),
(24, 2, 1, 4, 1270914558),
(24, 2, 2, 5, 1270915019),
(24, 2, 3, 1, 1270915170),
(24, 2, 5, 1, 1270914759),
(24, 2, 5, 2, 1270914759),
(25, 3, 1, 3, 1270914563),
(25, 3, 1, 4, 1270914563),
(25, 3, 1, 5, 1270914563),
(25, 3, 2, 1, 1270915023),
(25, 3, 3, 1, 1270915174),
(25, 3, 5, 2, 1270914767),
(25, 4, 1, 2, 1270914563),
(25, 4, 5, 1, 1270914767),
(26, 5, 1, 3, 1270914568),
(26, 5, 1, 5, 1270914568),
(26, 5, 2, 5, 1270915031),
(26, 5, 5, 1, 1270914776),
(26, 5, 5, 2, 1270914776),
(26, 6, 1, 2, 1270914568),
(26, 6, 1, 4, 1270914568),
(26, 6, 3, 1, 1270915181),
(27, 5, 1, 2, 1270914571),
(27, 5, 1, 4, 1270914571),
(27, 5, 2, 1, 1270915038),
(27, 5, 3, 1, 1270915186),
(27, 6, 1, 3, 1270914571),
(27, 6, 1, 5, 1270914571),
(27, 6, 2, 5, 1270915038),
(27, 6, 5, 1, 1270914785),
(27, 6, 5, 2, 1270914785),
(28, 5, 1, 2, 1270914577),
(28, 5, 1, 3, 1270914577),
(28, 5, 1, 4, 1270914577),
(28, 5, 1, 5, 1270914577),
(28, 5, 2, 1, 1270915044),
(28, 5, 3, 1, 1270915192),
(28, 5, 5, 1, 1270914793),
(28, 6, 5, 2, 1270914793),
(29, 1, 1, 4, 1270914583),
(29, 1, 2, 1, 1270915049),
(29, 1, 3, 1, 1270915200),
(29, 1, 5, 1, 1270914800),
(29, 2, 1, 2, 1270914583),
(29, 2, 1, 3, 1270914583),
(29, 2, 1, 5, 1270914583),
(29, 2, 2, 5, 1270915049),
(29, 2, 5, 2, 1270914800),
(31, 3, 1, 2, 1270914588),
(31, 3, 1, 3, 1270914588),
(31, 3, 1, 4, 1270914588),
(31, 3, 2, 1, 1270915056),
(31, 3, 2, 5, 1270915056),
(31, 3, 5, 1, 1270914808),
(31, 4, 1, 5, 1270914588),
(31, 4, 5, 2, 1270914809),
(32, 7, 2, 1, 1270915065),
(32, 7, 5, 1, 1270914816),
(32, 7, 5, 2, 1270914816),
(32, 8, 2, 5, 1270915065),
(33, 9, 1, 4, 1270914600),
(33, 9, 2, 1, 1270915072),
(33, 9, 5, 1, 1270914823),
(33, 9, 5, 2, 1270914823),
(33, 10, 1, 2, 1270914600),
(33, 10, 1, 3, 1270914600),
(33, 10, 1, 5, 1281289840),
(33, 10, 2, 5, 1270915072),
(36, 13, 1, 3, 1281290840),
(36, 13, 2, 1, 1270915146),
(36, 13, 3, 1, 1270915266),
(36, 14, 1, 4, 1270914680),
(37, 1, 1, 3, 1281288460),
(37, 1, 1, 5, 1281285916),
(37, 2, 1, 2, 1281289732),
(37, 2, 1, 4, 1281294027);

-- --------------------------------------------------------

--
-- Table structure for table `user_result`
--

CREATE TABLE IF NOT EXISTS `user_result` (
  `question_id` int(10) unsigned NOT NULL,
  `answer_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`question_id`,`answer_id`,`user_id`),
  KEY `question_id` (`question_id`),
  KEY `answer_id` (`answer_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_result`
--

INSERT INTO `user_result` (`question_id`, `answer_id`, `user_id`, `date`) VALUES
(1, 1, 1, 1270914173),
(1, 1, 2, 1270914999),
(1, 1, 3, 1270915157),
(1, 1, 5, 1270914739),
(2, 1, 5, 1270914848),
(2, 2, 1, 1270914342),
(2, 2, 3, 1270915209),
(3, 1, 1, 1270914400),
(3, 1, 3, 1270915212),
(3, 2, 2, 1270915084),
(3, 2, 5, 1270914861),
(4, 3, 1, 1270914403),
(4, 3, 2, 1270915096),
(4, 3, 3, 1270915216),
(4, 3, 5, 1270914866),
(5, 1, 2, 1270915102),
(5, 1, 5, 1270914873),
(5, 2, 1, 1270914408),
(5, 2, 3, 1270915220),
(14, 1, 1, 1270914412),
(14, 1, 2, 1270915111),
(14, 1, 3, 1270915225),
(14, 2, 5, 1270914880),
(15, 2, 1, 1270914417),
(15, 2, 2, 1270915117),
(15, 2, 3, 1270915230),
(15, 2, 5, 1270914889),
(16, 1, 1, 1270914421),
(16, 1, 5, 1270914893),
(16, 2, 2, 1270915125),
(16, 2, 3, 1270915237),
(17, 1, 1, 1270914426),
(17, 1, 3, 1270915244),
(17, 2, 5, 1270914895),
(18, 1, 2, 1270915135),
(18, 2, 1, 1270914429),
(18, 2, 3, 1270915249),
(19, 1, 3, 1270915254),
(19, 2, 1, 1270914433),
(20, 1, 1, 1270914339),
(20, 1, 5, 1270914840),
(20, 2, 3, 1270915207),
(21, 5, 1, 1270914335),
(21, 5, 5, 1270914836),
(21, 6, 3, 1270915202),
(22, 1, 2, 1270915077),
(22, 2, 1, 1270914332),
(22, 2, 5, 1270914825),
(23, 1, 1, 1270914301),
(23, 1, 2, 1270915006),
(23, 2, 3, 1270915162),
(23, 2, 5, 1270914745),
(24, 1, 1, 1270914303),
(24, 1, 2, 1270915013),
(24, 1, 5, 1270914755),
(24, 2, 3, 1270915168),
(25, 3, 2, 1270915021),
(25, 4, 1, 1270914306),
(25, 4, 3, 1270915172),
(25, 4, 5, 1270914762),
(26, 5, 1, 1270914310),
(26, 5, 3, 1270915179),
(26, 6, 2, 1270915029),
(26, 6, 5, 1270914770),
(27, 6, 1, 1270914313),
(27, 6, 2, 1270915034),
(27, 6, 3, 1270915183),
(27, 6, 5, 1270914778),
(28, 5, 3, 1270915188),
(28, 6, 1, 1270914316),
(28, 6, 2, 1270915041),
(28, 6, 5, 1270914788),
(29, 1, 3, 1270915196),
(29, 2, 1, 1270914319),
(29, 2, 2, 1270915047),
(29, 2, 5, 1270914796),
(31, 3, 1, 1270914323),
(31, 4, 2, 1270915056),
(31, 4, 5, 1270914803),
(32, 7, 2, 1270915061),
(32, 8, 1, 1281292365),
(32, 8, 5, 1270914812),
(33, 10, 2, 1270915068),
(33, 10, 5, 1270914818),
(36, 13, 1, 1281292566),
(36, 14, 2, 1270915144),
(36, 14, 3, 1270915262),
(37, 2, 1, 1281341077);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `friend`
--
ALTER TABLE `friend`
  ADD CONSTRAINT `friend_ibfk_1` FOREIGN KEY (`user_id_1`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `friend_ibfk_2` FOREIGN KEY (`user_id_2`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `question_answer_feeling`
--
ALTER TABLE `question_answer_feeling`
  ADD CONSTRAINT `question_answer_feeling_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `question_answer_feeling_ibfk_2` FOREIGN KEY (`answer_id`) REFERENCES `answer` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `question_answer_feeling_ibfk_3` FOREIGN KEY (`feeling_id`) REFERENCES `feeling` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_guess`
--
ALTER TABLE `user_guess`
  ADD CONSTRAINT `user_friend_prognostic_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_friend_prognostic_ibfk_2` FOREIGN KEY (`answer_id`) REFERENCES `answer` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_friend_prognostic_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_guess_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_guess_ibfk_2` FOREIGN KEY (`answer_id`) REFERENCES `answer` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_guess_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_guess_friend`
--
ALTER TABLE `user_guess_friend`
  ADD CONSTRAINT `user_guess_friend_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_guess_friend_ibfk_2` FOREIGN KEY (`answer_id`) REFERENCES `answer` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_guess_friend_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_guess_friend_ibfk_4` FOREIGN KEY (`friend_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_result`
--
ALTER TABLE `user_result`
  ADD CONSTRAINT `user_result_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_result_ibfk_2` FOREIGN KEY (`answer_id`) REFERENCES `answer` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_result_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
