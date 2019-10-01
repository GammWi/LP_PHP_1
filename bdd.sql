-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 24 sep. 2019 à 09:03
-- Version du serveur :  5.7.19
-- Version de PHP :  7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `lp_projet_php`
--

-- --------------------------------------------------------

--
-- Structure de la table `element`
--

DROP TABLE IF EXISTS `element`;
CREATE TABLE IF NOT EXISTS `element` (
  `id_element` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8_bin NOT NULL,
  `description` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id_element`),
  UNIQUE KEY `id_element` (`id_element`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `hero`
--

DROP TABLE IF EXISTS `hero`;
CREATE TABLE IF NOT EXISTS `hero` (
  `id_hero` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_character` int(11) NOT NULL,
  `firstname` varchar(55) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id_hero`),
  UNIQUE KEY `id_hero` (`id_hero`),
  UNIQUE KEY `id_character` (`id_character`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `isstrongerelem`
--

DROP TABLE IF EXISTS `isstrongerelem`;
CREATE TABLE IF NOT EXISTS `isstrongerelem` (
  `id_isStronger` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_elem_stronger` int(11) NOT NULL,
  `id_elem_weaker` int(11) NOT NULL,
  PRIMARY KEY (`id_isStronger`),
  UNIQUE KEY `id_isStronger` (`id_isStronger`),
  KEY `id_elem_stronger` (`id_elem_stronger`),
  KEY `id_elem_weaker` (`id_elem_weaker`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `monster`
--

DROP TABLE IF EXISTS `monster`;
CREATE TABLE IF NOT EXISTS `monster` (
  `id_monster` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_character` int(11) NOT NULL,
  `firstname` varchar(55) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id_monster`),
  UNIQUE KEY `id_monster` (`id_monster`),
  UNIQUE KEY `id_character` (`id_character`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `characterController`
--

DROP TABLE IF EXISTS `character`;
CREATE TABLE IF NOT EXISTS `character` (
  `id_character` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_character_race` int(11) NOT NULL,
  `name` varchar(55) COLLATE utf8_bin NOT NULL,
  `picture` varchar(155) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id_character`),
  UNIQUE KEY `id_character` (`id_character`),
  KEY `id_character_race` (`id_character_race`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `race`
--

DROP TABLE IF EXISTS `race`;
CREATE TABLE IF NOT EXISTS `race` (
  `id_race` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8_bin DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `boostAttack` float DEFAULT NULL,
  `boostDefense` float DEFAULT NULL,
  `boostAgility` float DEFAULT NULL,
  `boostHp` float DEFAULT NULL,
  PRIMARY KEY (`id_race`),
  UNIQUE KEY `id_race` (`id_race`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(55) COLLATE utf8_bin DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `id_user` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


