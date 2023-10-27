-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 21 jan. 2022 à 16:14
-- Version du serveur :  10.4.11-MariaDB
-- Version de PHP : 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_presence`
--

-- --------------------------------------------------------

--
-- Structure de la table `apprenant`
--

CREATE TABLE `apprenant` (
  `id_apprenant` int(11) NOT NULL,
  `nom_apprenant` varchar(50) DEFAULT NULL,
  `prenom_apprenant` varchar(250) DEFAULT NULL,
  `nom_utilisateur` varchar(100) DEFAULT NULL,
  `mot_de_passe` varchar(50) DEFAULT NULL,
  `adresse` varchar(50) DEFAULT NULL,
  `id_formation` int(11) NOT NULL,
  `photo1` varchar(25) NOT NULL,
  `photo2` varchar(25) NOT NULL,
  `photo3` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `apprenant`
--

INSERT INTO `apprenant` (`id_apprenant`, `nom_apprenant`, `prenom_apprenant`, `nom_utilisateur`, `mot_de_passe`, `adresse`, `id_formation`, `photo1`, `photo2`, `photo3`) VALUES
(22, 'KOUAKOU', 'Ulrich Emmanuel', 'ulrich', 'emmanuel', '02 BP 1547', 1, '1.jpg', '2.jpg', '3.jpg'),
(23, 'KONE', 'Mamadou', 'mamadou', 'mamadou', '03 BP 154', 1, '1.jpg', '2.jpg', '3.jpg'),
(43, 'KONATE', 'BAKARY LASS', 'bakary', 'bakary', '02 BP 125', 1, '1.jpg', '2.jpg', '3.jpg');

--
-- Déclencheurs `apprenant`
--
DELIMITER $$
CREATE TRIGGER `delete_users` AFTER DELETE ON `apprenant` FOR EACH ROW DELETE FROM users WHERE id_apprenant =old.id_apprenant
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_users` AFTER INSERT ON `apprenant` FOR EACH ROW INSERT INTO users (id_apprenant, role, nom_utilisateur, mot_de_passe) VALUES(new.id_apprenant, 'apprenant', new.nom_utilisateur, new.mot_de_passe)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_users` AFTER UPDATE ON `apprenant` FOR EACH ROW UPDATE users SET nom_utilisateur=new.nom_utilisateur, mot_de_passe=new.mot_de_passe WHERE id_apprenant=old.id_apprenant
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `bloc_competences`
--

CREATE TABLE `bloc_competences` (
  `id_blc` int(11) NOT NULL,
  `libelle_blc` varchar(50) NOT NULL,
  `id_referentiel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `competences`
--

CREATE TABLE `competences` (
  `id_competence` int(11) NOT NULL,
  `niveau_competence` varchar(50) NOT NULL,
  `competence` varchar(255) NOT NULL,
  `id_blc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `encadrer`
--

CREATE TABLE `encadrer` (
  `id_formation` int(11) NOT NULL,
  `id_formateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `financer`
--

CREATE TABLE `financer` (
  `id_partenaire` int(11) NOT NULL,
  `id_formation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `formateur`
--

CREATE TABLE `formateur` (
  `id_formateur` int(11) NOT NULL,
  `nom_formateur` varchar(50) DEFAULT NULL,
  `prenom_formateur` varchar(250) DEFAULT NULL,
  `nom_user_form` varchar(50) DEFAULT NULL,
  `mot_de_passe_form` varchar(50) DEFAULT NULL,
  `adresse` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `formateur`
--

INSERT INTO `formateur` (`id_formateur`, `nom_formateur`, `prenom_formateur`, `nom_user_form`, `mot_de_passe_form`, `adresse`) VALUES
(2, 'N\'takpe', 'Tchimou', 'tchimou', 'tchimou', '03 BP 275'),
(4, 'ZEZE', 'Sylvain', 'sylvain', 'sylvain', '07 BP 255'),
(6, 'OUATTARA', 'Assan Assan', 'assan', 'assan', '03 BP 255');

--
-- Déclencheurs `formateur`
--
DELIMITER $$
CREATE TRIGGER `after_delete_formateur` AFTER DELETE ON `formateur` FOR EACH ROW DELETE FROM users WHERE id_formateur =old.id_formateur
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_insert_formateur` AFTER INSERT ON `formateur` FOR EACH ROW INSERT INTO users (id_formateur, role, nom_utilisateur, mot_de_passe) VALUES(new.id_formateur, 'formateur', new.nom_user_form, new.mot_de_passe_form)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_update_formateur` AFTER UPDATE ON `formateur` FOR EACH ROW UPDATE users SET nom_utilisateur=new.nom_user_form, mot_de_passe=new.mot_de_passe_form WHERE id_formateur=old.id_formateur
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `formation`
--

CREATE TABLE `formation` (
  `id_formation` int(11) NOT NULL,
  `libelle_formation` varchar(50) NOT NULL,
  `duree_formation` int(11) NOT NULL,
  `id_referentiel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `formation`
--

INSERT INTO `formation` (`id_formation`, `libelle_formation`, `duree_formation`, `id_referentiel`) VALUES
(1, 'Développeur.se en intelligence artificielle', 9, 1),
(2, 'Développeur web et mobile', 6, 2);

-- --------------------------------------------------------

--
-- Structure de la table `partenaire`
--

CREATE TABLE `partenaire` (
  `id_partenaire` int(11) NOT NULL,
  `nom_partenaire` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `partenaire`
--

INSERT INTO `partenaire` (`id_partenaire`, `nom_partenaire`) VALUES
(1, 'MTN FONDATION'),
(2, 'AUF'),
(5, 'SGBCI');

-- --------------------------------------------------------

--
-- Structure de la table `presence_apprenant`
--

CREATE TABLE `presence_apprenant` (
  `id_presence` int(11) NOT NULL,
  `date_jour` date DEFAULT NULL,
  `heure_arrivee` varchar(50) DEFAULT NULL,
  `heure_depart` varchar(50) DEFAULT NULL,
  `id_formation` int(11) NOT NULL,
  `id_apprenant` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `presence_apprenant`
--

INSERT INTO `presence_apprenant` (`id_presence`, `date_jour`, `heure_arrivee`, `heure_depart`, `id_formation`, `id_apprenant`) VALUES
(19, '2021-11-30', '21:42:16', NULL, 1, 22),
(20, '2021-12-01', '11:17:04', NULL, 1, 23),
(21, '2021-12-01', '11:17:04', NULL, 1, 23),
(32, '2021-12-02', '21:29:01', NULL, 1, 22),
(36, '2021-12-03', '09:51:23', '09:53:49', 1, 22),
(45, '2021-12-06', '13:17:45', NULL, 1, 22),
(46, '2021-12-07', '08:57:53', NULL, 1, 23),
(47, '2021-12-07', '09:17:20', NULL, 1, 22);

-- --------------------------------------------------------

--
-- Structure de la table `referentiel`
--

CREATE TABLE `referentiel` (
  `id_referentiel` int(11) NOT NULL,
  `libelle_referentiel` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `referentiel`
--

INSERT INTO `referentiel` (`id_referentiel`, `libelle_referentiel`) VALUES
(1, 'Certificat RNCP Développeur.se en IA'),
(2, 'Certificat Développeur web et mobile');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `id_apprenant` int(11) NOT NULL,
  `id_formateur` int(11) NOT NULL,
  `role` varchar(100) NOT NULL,
  `nom_utilisateur` varchar(100) NOT NULL,
  `mot_de_passe` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `id_apprenant`, `id_formateur`, `role`, `nom_utilisateur`, `mot_de_passe`) VALUES
(7, 0, 6, 'formateur', 'assan', 'assan'),
(10, 22, 0, 'apprenant', 'ulrich', 'emmanuel'),
(11, 23, 0, 'apprenant', 'mamadou', 'mamadou'),
(31, 43, 0, 'apprenant', 'bakary', 'bakary');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `apprenant`
--
ALTER TABLE `apprenant`
  ADD PRIMARY KEY (`id_apprenant`),
  ADD KEY `id_formation` (`id_formation`);

--
-- Index pour la table `bloc_competences`
--
ALTER TABLE `bloc_competences`
  ADD PRIMARY KEY (`id_blc`),
  ADD KEY `id_referentiel` (`id_referentiel`);

--
-- Index pour la table `competences`
--
ALTER TABLE `competences`
  ADD PRIMARY KEY (`id_competence`),
  ADD KEY `id_blc` (`id_blc`);

--
-- Index pour la table `encadrer`
--
ALTER TABLE `encadrer`
  ADD PRIMARY KEY (`id_formation`,`id_formateur`),
  ADD KEY `id_formateur` (`id_formateur`);

--
-- Index pour la table `financer`
--
ALTER TABLE `financer`
  ADD PRIMARY KEY (`id_partenaire`,`id_formation`),
  ADD KEY `id_formation` (`id_formation`);

--
-- Index pour la table `formateur`
--
ALTER TABLE `formateur`
  ADD PRIMARY KEY (`id_formateur`);

--
-- Index pour la table `formation`
--
ALTER TABLE `formation`
  ADD PRIMARY KEY (`id_formation`),
  ADD KEY `id_referentiel` (`id_referentiel`);

--
-- Index pour la table `partenaire`
--
ALTER TABLE `partenaire`
  ADD PRIMARY KEY (`id_partenaire`);

--
-- Index pour la table `presence_apprenant`
--
ALTER TABLE `presence_apprenant`
  ADD PRIMARY KEY (`id_presence`),
  ADD KEY `id_formation` (`id_formation`),
  ADD KEY `id_apprenant` (`id_apprenant`);

--
-- Index pour la table `referentiel`
--
ALTER TABLE `referentiel`
  ADD PRIMARY KEY (`id_referentiel`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `apprenant`
--
ALTER TABLE `apprenant`
  MODIFY `id_apprenant` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT pour la table `bloc_competences`
--
ALTER TABLE `bloc_competences`
  MODIFY `id_blc` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `competences`
--
ALTER TABLE `competences`
  MODIFY `id_competence` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `formateur`
--
ALTER TABLE `formateur`
  MODIFY `id_formateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `formation`
--
ALTER TABLE `formation`
  MODIFY `id_formation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `partenaire`
--
ALTER TABLE `partenaire`
  MODIFY `id_partenaire` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `presence_apprenant`
--
ALTER TABLE `presence_apprenant`
  MODIFY `id_presence` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT pour la table `referentiel`
--
ALTER TABLE `referentiel`
  MODIFY `id_referentiel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `apprenant`
--
ALTER TABLE `apprenant`
  ADD CONSTRAINT `apprenant_ibfk_1` FOREIGN KEY (`id_formation`) REFERENCES `formation` (`id_formation`) ON DELETE CASCADE;

--
-- Contraintes pour la table `bloc_competences`
--
ALTER TABLE `bloc_competences`
  ADD CONSTRAINT `bloc_competences_ibfk_1` FOREIGN KEY (`id_referentiel`) REFERENCES `referentiel` (`id_referentiel`);

--
-- Contraintes pour la table `competences`
--
ALTER TABLE `competences`
  ADD CONSTRAINT `competences_ibfk_1` FOREIGN KEY (`id_blc`) REFERENCES `bloc_competences` (`id_blc`);

--
-- Contraintes pour la table `encadrer`
--
ALTER TABLE `encadrer`
  ADD CONSTRAINT `encadrer_ibfk_1` FOREIGN KEY (`id_formation`) REFERENCES `formation` (`id_formation`),
  ADD CONSTRAINT `encadrer_ibfk_2` FOREIGN KEY (`id_formateur`) REFERENCES `formateur` (`id_formateur`);

--
-- Contraintes pour la table `financer`
--
ALTER TABLE `financer`
  ADD CONSTRAINT `financer_ibfk_1` FOREIGN KEY (`id_partenaire`) REFERENCES `partenaire` (`id_partenaire`),
  ADD CONSTRAINT `financer_ibfk_2` FOREIGN KEY (`id_formation`) REFERENCES `formation` (`id_formation`);

--
-- Contraintes pour la table `formation`
--
ALTER TABLE `formation`
  ADD CONSTRAINT `formation_ibfk_1` FOREIGN KEY (`id_referentiel`) REFERENCES `referentiel` (`id_referentiel`);

--
-- Contraintes pour la table `presence_apprenant`
--
ALTER TABLE `presence_apprenant`
  ADD CONSTRAINT `presence_apprenant_ibfk_3` FOREIGN KEY (`id_formation`) REFERENCES `formation` (`id_formation`) ON DELETE CASCADE,
  ADD CONSTRAINT `presence_apprenant_ibfk_4` FOREIGN KEY (`id_apprenant`) REFERENCES `apprenant` (`id_apprenant`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
