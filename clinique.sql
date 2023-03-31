-- phpMyAdmin SQL Dump
-- version 5.0.4deb2+deb11u1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : ven. 31 mars 2023 à 14:52
-- Version du serveur :  10.5.15-MariaDB-0+deb11u1
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `clinique`
--

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE `contact` (
  `Nom` varchar(50) DEFAULT NULL,
  `Prenom` varchar(50) DEFAULT NULL,
  `Téléphone` bigint(20) DEFAULT NULL,
  `Adresse` varchar(50) DEFAULT NULL,
  `code_contact` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`Nom`, `Prenom`, `Téléphone`, `Adresse`, `code_contact`) VALUES
('Bourst', 'Arthur', 744158966, '3 avenue De Gaulle', 11),
('Courtin', 'Theo', 758033325, '12 rue des cafetiers', 12);

-- --------------------------------------------------------

--
-- Structure de la table `hospitalisation`
--

CREATE TABLE `hospitalisation` (
  `Date_hospitalisation` date NOT NULL,
  `Pre_admission` varchar(50) DEFAULT NULL,
  `Heure_intervention` varchar(18) DEFAULT NULL,
  `code_personnel` int(11) DEFAULT NULL,
  `Num_secu` bigint(20) DEFAULT NULL,
  `id` bigint(20) NOT NULL,
  `statut` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `hospitalisation`
--

INSERT INTO `hospitalisation` (`Date_hospitalisation`, `Pre_admission`, `Heure_intervention`, `code_personnel`, `Num_secu`, `id`, `statut`) VALUES
('2023-04-08', 'Hospitalisation', '04:23', 9, 185087666666666, 14, 'A faire'),
('2023-04-08', 'Ambulatoire', '19:05', 7, 112121212121212, 15, 'A faire');

-- --------------------------------------------------------

--
-- Structure de la table `patient`
--

CREATE TABLE `patient` (
  `Num_secu` bigint(20) NOT NULL,
  `Civilité` varchar(50) DEFAULT NULL,
  `Nom_Naissance` varchar(50) DEFAULT NULL,
  `Nom_Epouse` varchar(50) DEFAULT NULL,
  `Prenom` varchar(50) DEFAULT NULL,
  `Date_naissance` varchar(19) DEFAULT NULL,
  `Adresse` varchar(50) DEFAULT NULL,
  `Code_postal` int(11) DEFAULT NULL,
  `Téléphone` bigint(20) DEFAULT NULL,
  `Ville` varchar(50) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Mineur` tinyint(1) DEFAULT NULL,
  `code_prevenir` bigint(20) DEFAULT NULL,
  `code_confiance` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `patient`
--

INSERT INTO `patient` (`Num_secu`, `Civilité`, `Nom_Naissance`, `Nom_Epouse`, `Prenom`, `Date_naissance`, `Adresse`, `Code_postal`, `Téléphone`, `Ville`, `Email`, `Mineur`, `code_prevenir`, `code_confiance`) VALUES
(112121212121212, 'Homme', 'Catteeuw', '', 'Amaury', '2003-09-30', '5 rue des cocotiers', 59860, 644100522, 'Solesmes', 'amaury@gmail.fr', 0, 12, 12),
(185087666666666, 'Homme', 'Boufflers', '', 'Alexandre', '2003-09-14', '26 rue des Potiers', 59000, 613569254, 'Neuville', 'boubou@gmail.com', 0, 11, 11);

-- --------------------------------------------------------

--
-- Structure de la table `personnel`
--

CREATE TABLE `personnel` (
  `Code_personnel` int(11) NOT NULL,
  `Nom` varchar(50) DEFAULT NULL,
  `Prenom` varchar(50) DEFAULT NULL,
  `Identifiant` varchar(100) DEFAULT NULL,
  `Mot_de_passe` varchar(100) DEFAULT NULL,
  `Service` int(11) DEFAULT NULL,
  `role` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `personnel`
--

INSERT INTO `personnel` (`Code_personnel`, `Nom`, `Prenom`, `Identifiant`, `Mot_de_passe`, `Service`, `role`) VALUES
(7, 'Faure', 'Hugues', 'h.faure', '$argon2id$v=19$m=65536,t=4,p=1$ZFFkOGpROGQ5SnJWOWFTNg$xPJU0AmQAe+91UvYzTb85PXWN1fOQ/EGzoXaJVSPEjI', 6, 'Médecin'),
(8, 'Marquis', 'Françoise', 'f.marquis', '$argon2id$v=19$m=65536,t=4,p=1$Q2QyUzE4aG5WSzlrdjl1WA$vD3p+0mihgbrPzRIWLGUJfoAloSBdbE4tRxMUmVSCCE', 7, 'Médecin'),
(9, 'Covillon', 'Alexandre', 'a.covillon', '$argon2id$v=19$m=65536,t=4,p=1$Y0ZrV29DbHJPM3ZsUFBVZw$HIRBx446K8ny9exY1XGJVyoQNPaW/8x+Vxdec0aI9dM', 5, 'Médecin'),
(10, 'Huppe', 'Victor', 'v.huppe', '$argon2id$v=19$m=65536,t=4,p=1$R0dadFgyOFVNaU82WWFjZg$qF4mmkoY3ySWWBuuC4vgZONBLe166LGPCxDIgn/UZ40', 5, 'Administrateur'),
(11, 'Pouchon', 'Sylvie', 's.pouchon', '$argon2id$v=19$m=65536,t=4,p=1$LzM1cE5sMkxsWlBkd3Y5eQ$emzfvt1oey2ue307lT1AsPowFBRQEmm8n6u3kncm4iQ', 5, 'Secrétaire');

-- --------------------------------------------------------

--
-- Structure de la table `piece_jointe`
--

CREATE TABLE `piece_jointe` (
  `Carte_identité` varchar(50) DEFAULT NULL,
  `Carte_vitale` varchar(50) DEFAULT NULL,
  `Carte_mutuelle` varchar(50) DEFAULT NULL,
  `Livret_de_famille` varchar(50) DEFAULT NULL,
  `Num_secu` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `preadmission`
--

CREATE TABLE `preadmission` (
  `choix` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `preadmission`
--

INSERT INTO `preadmission` (`choix`) VALUES
('Ambulatoire'),
('Hospitalisation');

-- --------------------------------------------------------

--
-- Structure de la table `secu`
--

CREATE TABLE `secu` (
  `Num_secu` bigint(20) NOT NULL,
  `organisme` varchar(50) DEFAULT NULL,
  `assure` varchar(3) DEFAULT NULL,
  `Ald` varchar(3) DEFAULT NULL,
  `Nom_mutuelle` varchar(50) DEFAULT NULL,
  `num_adherent` int(11) NOT NULL,
  `chambre_particuliere` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `secu`
--

INSERT INTO `secu` (`Num_secu`, `organisme`, `assure`, `Ald`, `Nom_mutuelle`, `num_adherent`, `chambre_particuliere`) VALUES
(185087666666666, 'AXA', 'Oui', 'Non', 'MMA', 1, '1'),
(112121212121212, 'AXA', 'Oui', 'Oui', 'MMA', 2, '2');

-- --------------------------------------------------------

--
-- Structure de la table `service`
--

CREATE TABLE `service` (
  `id` int(11) NOT NULL,
  `libelle` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `service`
--

INSERT INTO `service` (`id`, `libelle`) VALUES
(5, 'Chirurgie'),
(6, 'Neurologie'),
(7, 'Radiologie'),
(8, 'pneumologie'),
(9, 'cardiologie'),
(10, 'rhumatologie'),
(11, 'ophtalmologie');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`code_contact`);

--
-- Index pour la table `hospitalisation`
--
ALTER TABLE `hospitalisation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Hospitalisation_FK` (`Num_secu`),
  ADD KEY `Hospitalisation_FK_1` (`code_personnel`);

--
-- Index pour la table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`Num_secu`),
  ADD KEY `Patient_FK` (`code_prevenir`),
  ADD KEY `Patient_FK_1` (`code_confiance`);

--
-- Index pour la table `personnel`
--
ALTER TABLE `personnel`
  ADD PRIMARY KEY (`Code_personnel`),
  ADD KEY `personnel_FK` (`Service`);

--
-- Index pour la table `piece_jointe`
--
ALTER TABLE `piece_jointe`
  ADD PRIMARY KEY (`Num_secu`),
  ADD KEY `Piece_jointe_FK` (`Num_secu`);

--
-- Index pour la table `secu`
--
ALTER TABLE `secu`
  ADD KEY `Renseignements_FK` (`Num_secu`);

--
-- Index pour la table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `contact`
--
ALTER TABLE `contact`
  MODIFY `code_contact` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `hospitalisation`
--
ALTER TABLE `hospitalisation`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `personnel`
--
ALTER TABLE `personnel`
  MODIFY `Code_personnel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `service`
--
ALTER TABLE `service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `hospitalisation`
--
ALTER TABLE `hospitalisation`
  ADD CONSTRAINT `Hospitalisation_FK` FOREIGN KEY (`Num_secu`) REFERENCES `patient` (`Num_secu`),
  ADD CONSTRAINT `hospitalisation_FK_1` FOREIGN KEY (`code_personnel`) REFERENCES `personnel` (`Code_personnel`);

--
-- Contraintes pour la table `patient`
--
ALTER TABLE `patient`
  ADD CONSTRAINT `Patient_FK` FOREIGN KEY (`code_prevenir`) REFERENCES `contact` (`code_contact`),
  ADD CONSTRAINT `Patient_FK_1` FOREIGN KEY (`code_confiance`) REFERENCES `contact` (`code_contact`);

--
-- Contraintes pour la table `personnel`
--
ALTER TABLE `personnel`
  ADD CONSTRAINT `personnel_FK` FOREIGN KEY (`Service`) REFERENCES `service` (`id`);

--
-- Contraintes pour la table `piece_jointe`
--
ALTER TABLE `piece_jointe`
  ADD CONSTRAINT `Piece_jointe_FK` FOREIGN KEY (`Num_secu`) REFERENCES `patient` (`Num_secu`);

--
-- Contraintes pour la table `secu`
--
ALTER TABLE `secu`
  ADD CONSTRAINT `Renseignements_FK` FOREIGN KEY (`Num_secu`) REFERENCES `patient` (`Num_secu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
