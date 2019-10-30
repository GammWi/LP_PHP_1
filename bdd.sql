-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 16 oct. 2019 à 16:46
-- Version du serveur :  10.1.26-MariaDB
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
-- Base de données :  `dawa`
--

DROP TABLE IF EXISTS `pictures`;
CREATE TABLE IF NOT EXISTS `pictures` (
  `id_picture` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8_bin NOT NULL,
  `path` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id_picture`),
  UNIQUE KEY `id_picture` (`id_picture`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


-- --------------------------------------------------------

--
-- Structure de la table `character`
--
DROP TABLE IF EXISTS `character`;
DROP TABLE IF EXISTS `element`;
DROP TABLE IF EXISTS `fight`;
DROP TABLE IF EXISTS `hero`;
DROP TABLE IF EXISTS `isstrongerelem`;
DROP TABLE IF EXISTS `monster`;
DROP TABLE IF EXISTS `race`;
DROP TABLE IF EXISTS `statscarac`;
DROP TABLE IF EXISTS `statsfight`;
DROP TABLE IF EXISTS `user`;


CREATE TABLE `character` (
  `id_character` bigint(20) UNSIGNED NOT NULL,
  `id_character_race` int(11) NOT NULL,
  `id_character_elem` int(11) NOT NULL,
  `name` varchar(55) COLLATE utf8_bin NOT NULL,
  `picture` varchar(155) COLLATE utf8_bin DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


-- --------------------------------------------------------

--
-- Structure de la table `element`
--

CREATE TABLE `element` (
  `id_element` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(55) COLLATE utf8_bin NOT NULL,
  `description` varchar(255) COLLATE utf8_bin DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


-- --------------------------------------------------------

--
-- Structure de la table `fight`
--

CREATE TABLE `fight` (
  `id_fight` bigint(20) UNSIGNED NOT NULL,
  `id_hero` int(11) NOT NULL,
  `id_monster` int(11) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `update_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `hero`
--

CREATE TABLE `hero` (
  `id_hero` bigint(20) UNSIGNED NOT NULL,
  `id_character` int(11) NOT NULL,
  `firstname` varchar(55) COLLATE utf8_bin DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `isstrongerelem`
--

CREATE TABLE `isstrongerelem` (
  `id_isStronger` bigint(20) UNSIGNED NOT NULL,
  `id_elem_stronger` int(11) NOT NULL,
  `id_elem_weaker` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


-- --------------------------------------------------------

--
-- Structure de la table `monster`
--

CREATE TABLE `monster` (
  `id_monster` bigint(20) UNSIGNED NOT NULL,
  `id_character` int(11) NOT NULL
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
  `attack` float DEFAULT NULL,
  `defense` float DEFAULT NULL,
  `agility` float DEFAULT NULL,
  `hp` float DEFAULT NULL,
  `id_picture` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_race`),
  UNIQUE KEY `id_race` (`id_race`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


-- --------------------------------------------------------

--
-- Structure de la table `statscarac`
--

CREATE TABLE `statscharac` (
  `id_statscharac` bigint(20) UNSIGNED NOT NULL,
  `id_charac` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(30) COLLATE utf8_bin NOT NULL,
  `nbWin` bigint(20) UNSIGNED DEFAULT '0',
  `nbLoose` bigint(20) UNSIGNED DEFAULT '0',
  `nbTotal` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `statsfight`
--

CREATE TABLE `statsfight` (
  `id_stats` bigint(20) UNSIGNED NOT NULL,
  `id_fight` int(11) NOT NULL,
  `id_character` int(11) NOT NULL,
  `isWinner` tinyint(1) NOT NULL,
  `dmgInfliges` float NOT NULL,
  `dmgRecus` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(55) COLLATE utf8_bin DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_bin DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `character`
--
ALTER TABLE `character`
  ADD PRIMARY KEY (`id_character`),
  ADD UNIQUE KEY `id_character` (`id_character`),
  ADD KEY `id_character_elem` (`id_character_elem`),
  ADD KEY `id_character_race` (`id_character_race`);

--
-- Index pour la table `element`
--
ALTER TABLE `element`
  ADD PRIMARY KEY (`id_element`),
  ADD UNIQUE KEY `id_element` (`id_element`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `fight`
--
ALTER TABLE `fight`
  ADD PRIMARY KEY (`id_fight`),
  ADD UNIQUE KEY `id_fight` (`id_fight`),
  ADD KEY `id_hero` (`id_hero`),
  ADD KEY `id_monster` (`id_monster`);

--
-- Index pour la table `hero`
--
ALTER TABLE `hero`
  ADD PRIMARY KEY (`id_hero`),
  ADD UNIQUE KEY `id_hero` (`id_hero`),
  ADD UNIQUE KEY `id_character` (`id_character`);

--
-- Index pour la table `isstrongerelem`
--
ALTER TABLE `isstrongerelem`
  ADD PRIMARY KEY (`id_isStronger`),
  ADD UNIQUE KEY `id_isStronger` (`id_isStronger`),
  ADD KEY `id_elem_stronger` (`id_elem_stronger`),
  ADD KEY `id_elem_weaker` (`id_elem_weaker`);

--
-- Index pour la table `monster`
--
ALTER TABLE `monster`
  ADD PRIMARY KEY (`id_monster`),
  ADD UNIQUE KEY `id_monster` (`id_monster`),
  ADD UNIQUE KEY `id_character` (`id_character`);


--
-- Index pour la table `statscarac`
--
ALTER TABLE `statscharac`
  ADD PRIMARY KEY (`id_statscharac`),
  ADD UNIQUE KEY `id_statscarac` (`id_statscharac`),
  ADD KEY `id_carac` (`id_charac`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `id_user` (`id_user`);

--
-- Index pour la table `statsfight`
--
ALTER TABLE `statsfight`
  ADD PRIMARY KEY (`id_stats`),
  ADD UNIQUE KEY `id_stats` (`id_stats`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `character`
--
ALTER TABLE `character`
  MODIFY `id_character` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT pour la table `element`
--
ALTER TABLE `element`
  MODIFY `id_element` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT pour la table `fight`
--
ALTER TABLE `fight`
  MODIFY `id_fight` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `hero`
--
ALTER TABLE `hero`
  MODIFY `id_hero` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT pour la table `isstrongerelem`
--
ALTER TABLE `isstrongerelem`
  MODIFY `id_isStronger` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT pour la table `monster`
--
ALTER TABLE `monster`
  MODIFY `id_monster` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;



--
-- AUTO_INCREMENT pour la table `statscarac`
--
ALTER TABLE `statscharac`
  MODIFY `id_statscharac` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `statsfight`
--
ALTER TABLE `statsfight`
  MODIFY `id_stats` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
