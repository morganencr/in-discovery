-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : mar. 27 août 2024 à 12:53
-- Version du serveur : 8.0.37
-- Version de PHP : 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `indiscovery`
--

-- --------------------------------------------------------

--
-- Structure de la table `artistes`
--

CREATE TABLE `artistes` (
  `id_artiste` int NOT NULL,
  `nom` varchar(255) NOT NULL,
  `id_genre` int NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `photo` varchar(255) NOT NULL,
  `reseaux_sociaux` text NOT NULL,
  `decouverte` tinyint(1) NOT NULL,
  `cdc` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `artistes`
--

INSERT INTO `artistes` (`id_artiste`, `nom`, `id_genre`, `location`, `description`, `photo`, `reseaux_sociaux`, `decouverte`, `cdc`) VALUES
(1, 'First Draft', 1, 'Clermont-Ferrand', 'blablabla', 'images/punk-rock/first_draft/first_draft1.jpeg', '@firstdraft', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `artiste_concert`
--

CREATE TABLE `artiste_concert` (
  `id_artiste` int NOT NULL,
  `id_concert` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `concerts`
--

CREATE TABLE `concerts` (
  `id_concert` int NOT NULL,
  `groupe` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `lieux` text NOT NULL,
  `prix` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `genres`
--

CREATE TABLE `genres` (
  `id_genre` int NOT NULL,
  `categorie` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `genres`
--

INSERT INTO `genres` (`id_genre`, `categorie`, `genre`) VALUES
(1, 'punk/rock', 'post-punk'),
(2, 'punk/rock', 'punk-rock');

-- --------------------------------------------------------

--
-- Structure de la table `suggestions`
--

CREATE TABLE `suggestions` (
  `id_suggestion` int NOT NULL,
  `nom_artiste` varchar(255) NOT NULL,
  `lien_titre` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date_suggestion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `artistes`
--
ALTER TABLE `artistes`
  ADD PRIMARY KEY (`id_artiste`);

--
-- Index pour la table `artiste_concert`
--
ALTER TABLE `artiste_concert`
  ADD PRIMARY KEY (`id_artiste`);

--
-- Index pour la table `concerts`
--
ALTER TABLE `concerts`
  ADD PRIMARY KEY (`id_concert`);

--
-- Index pour la table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id_genre`);

--
-- Index pour la table `suggestions`
--
ALTER TABLE `suggestions`
  ADD PRIMARY KEY (`id_suggestion`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `artistes`
--
ALTER TABLE `artistes`
  MODIFY `id_artiste` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `concerts`
--
ALTER TABLE `concerts`
  MODIFY `id_concert` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `genres`
--
ALTER TABLE `genres`
  MODIFY `id_genre` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `suggestions`
--
ALTER TABLE `suggestions`
  MODIFY `id_suggestion` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
