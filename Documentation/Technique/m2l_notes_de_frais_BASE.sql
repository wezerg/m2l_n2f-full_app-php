-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 21 fév. 2020 à 14:03
-- Version du serveur :  5.7.26
-- Version de PHP :  7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `m2l_notes_de_frais`
--

-- --------------------------------------------------------

--
-- Structure de la table `config_utilisateur`
--

DROP TABLE IF EXISTS `config_utilisateur`;
CREATE TABLE IF NOT EXISTS `config_utilisateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int(11) NOT NULL,
  `couleur1` varchar(10) NOT NULL,
  `couleur2` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `config_utilisateur`
--

INSERT INTO `config_utilisateur` (`id`, `id_utilisateur`, `couleur1`, `couleur2`) VALUES
(1, 1, '#071b52', '#008080');

-- --------------------------------------------------------

--
-- Structure de la table `etat_note_de_frais`
--

DROP TABLE IF EXISTS `etat_note_de_frais`;
CREATE TABLE IF NOT EXISTS `etat_note_de_frais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `etat_note_de_frais` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `etat_note_de_frais`
--

INSERT INTO `etat_note_de_frais` (`id`, `etat_note_de_frais`) VALUES
(1, 'En attente'),
(2, 'Acceptée'),
(3, 'Refusée');

-- --------------------------------------------------------

--
-- Structure de la table `groupe_utilisateur`
--

DROP TABLE IF EXISTS `groupe_utilisateur`;
CREATE TABLE IF NOT EXISTS `groupe_utilisateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupe_utilisateur` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `groupe_utilisateur`
--

INSERT INTO `groupe_utilisateur` (`id`, `groupe_utilisateur`) VALUES
(1, 'administrateur'),
(2, 'directeur'),
(3, 'salarie');

-- --------------------------------------------------------

--
-- Structure de la table `ligue`
--

DROP TABLE IF EXISTS `ligue`;
CREATE TABLE IF NOT EXISTS `ligue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `id_utilisateur` int(11) NOT NULL COMMENT 'id du directeur de la ligue',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Structure de la table `note_de_frais`
--

DROP TABLE IF EXISTS `note_de_frais`;
CREATE TABLE IF NOT EXISTS `note_de_frais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) NOT NULL,
  `path_image` varchar(150) NOT NULL,
  `commentaire` varchar(50) NOT NULL,
  `montant` double NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `id_type_note_de_frais` int(11) NOT NULL,
  `id_etat_note_de_frais` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `note_de_frais_utilisateur_FK` (`id_utilisateur`),
  KEY `note_de_frais_type_note_de_frais0_FK` (`id_type_note_de_frais`),
  KEY `note_de_frais_etat_note_de_frais1_FK` (`id_etat_note_de_frais`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Structure de la table `type_note_de_frais`
--

DROP TABLE IF EXISTS `type_note_de_frais`;
CREATE TABLE IF NOT EXISTS `type_note_de_frais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_note_de_frais` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `type_note_de_frais`
--

INSERT INTO `type_note_de_frais` (`id`, `type_note_de_frais`) VALUES
(1, 'ESSENCE'),
(2, 'PEAGE'),
(3, 'RESTAURANT'),
(4, 'TRANSPORTS'),
(5, 'FOURNITURES');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `vacataire` tinyint(4) NOT NULL,
  `date_validite` datetime DEFAULT NULL,
  `id_groupe_utilisateur` int(11) NOT NULL,
  `id_ligue` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `utilisateur_groupe_utilisateur_FK` (`id_groupe_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `nom`, `prenom`, `login`, `password`, `vacataire`, `date_validite`, `id_groupe_utilisateur`, `id_ligue`) VALUES
(1, 'Administrateur', 'Utilisateur', 'admin', 'ec04321e2c7bf2e0b01bac41896796b19f22a244', 0, NULL, 1, 0),

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `note_de_frais`
--
ALTER TABLE `note_de_frais`
  ADD CONSTRAINT `note_de_frais_etat_note_de_frais1_FK` FOREIGN KEY (`id_etat_note_de_frais`) REFERENCES `etat_note_de_frais` (`id`),
  ADD CONSTRAINT `note_de_frais_type_note_de_frais0_FK` FOREIGN KEY (`id_type_note_de_frais`) REFERENCES `type_note_de_frais` (`id`),
  ADD CONSTRAINT `note_de_frais_utilisateur_FK` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `utilisateur_groupe_utilisateur_FK` FOREIGN KEY (`id_groupe_utilisateur`) REFERENCES `groupe_utilisateur` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
