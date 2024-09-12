-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : jeu. 12 sep. 2024 à 07:18
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
  `photo2` varchar(255) NOT NULL,
  `reseaux_sociaux` text NOT NULL,
  `audio_url` varchar(255) NOT NULL,
  `decouverte` tinyint(1) NOT NULL,
  `cdc` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `artistes`
--

INSERT INTO `artistes` (`id_artiste`, `nom`, `id_genre`, `location`, `description`, `photo`, `photo2`, `reseaux_sociaux`, `audio_url`, `decouverte`, `cdc`) VALUES
(11, 'FIRST DRAFT', 1, 'Clermont-Ferrand', 'Les chaussettes de l\'archiduchesse sont-elles sèches archi sèches ? Ca on ne sait pas on ne saura jamais finalement c\'est peut-être aussi ça la complexité de la vie non vous ne pensez pas ? Moi je pense.', 'first_draft1.jpeg', 'first_draft2.jpeg', 'https://www.instagram.com/first_draft_music/', 'https://open.spotify.com/embed/track/09VzZulviyv2cKu9SUNc22', 0, 1),
(12, 'FORGIVE', 5, 'Bourges/Nevers', 'blablabla', 'forgive.jpeg', 'forgive2.jpeg', 'https://www.instagram.com/forgiveband/', 'https://open.spotify.com/embed/track/2GQHd9lOBfXd0JLh3QS5ki', 1, 0),
(13, 'FOXHOLE', 2, 'Clermont-Ferrand', 'blablabla', 'foxhole3.jpeg', 'foxhole..jpeg', 'https://www.instagram.com/foxhole_group/', 'https://open.spotify.com/embed/track/3kMkeGDYv5PuuB5hSzhMPg', 1, 0),
(14, 'LORE', 6, 'Lyon', 'blablabla', 'lore2.jpeg', 'lore3.jpg', 'https://www.instagram.com/here_is_lore/', '', 1, 0),
(15, 'PATHFINDER', 4, 'Bourges/Nevers', 'blablabla', 'pathfinder.jpeg', 'pathfinder2.jpeg', 'https://www.instagram.com/pathfinder.indie/', 'https://open.spotify.com/embed/track/5oF1uIeIupcv3A1evkRXjy', 0, 0),
(16, 'HOMEGROUND', 2, 'Nevers', 'blablabla', 'homeground.jpeg', 'homeground2.jpg', 'https://www.instagram.com/homeground_rock/', 'https://open.spotify.com/embed/track/6QP85uGvnvw5pjwwjEnhSz', 0, 0),
(17, 'GADGET', 3, 'Clermont-Ferrand', 'blablabla', 'gadget.jpg', 'gadget4.jpg', 'https://www.instagram.com/gadget_project_/', 'https://open.spotify.com/embed/track/4ngW0xI6yf1H6XbE0TXAhV', 0, 0),
(18, 'MUSCLE MANNSCHAFT', 2, 'Nevers', 'blablabla', 'muscle2.jpeg', 'muscle3.jpeg', 'https://www.instagram.com/musclemannschaft/', '', 0, 0),
(22, 'I\'VE LEARNED', 7, 'Bourges', 'blablabla', 'ivelearned2.jpeg', 'ivelearned4.jpg', 'https://www.instagram.com/ivelearnedhc/', 'https://open.spotify.com/embed/track/550cXQq5ta4QUulf2MpvNn', 0, 0),
(23, 'CAVALERIE', 8, 'Paris', 'blablabla', 'cavalerie1.jpeg', 'cavalerie2.jpg', 'https://www.instagram.com/cvlr_paris/', 'https://open.spotify.com/embed/track/6UgDLqPsQdIvhXaRcC2bNG', 0, 0);

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
  `photo` varchar(255) NOT NULL,
  `groupe` varchar(255) NOT NULL,
  `lieux` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `concerts`
--

INSERT INTO `concerts` (`id_concert`, `photo`, `groupe`, `lieux`) VALUES
(2, 'gadget.jpg', 'GADGET', 'Raymond Bar (Clermont-Ferrand)'),
(3, 'lore.jpg', 'LORE', 'Viva Mexico (Grenoble)'),
(15, 'forgive.jpg', 'FORGIVE', 'Nantes/Blois/Orléans');

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
(1, 'punk/rock', 'Post-Rock'),
(2, 'punk/rock', 'Punk-Rock'),
(3, 'punk/rock', 'Punk / Hardcore'),
(4, 'punk/rock', 'Indie-Rock'),
(5, 'metal/hardcore', 'Post-Hardcore'),
(6, 'metal/hardcore', 'Modern Hardcore'),
(7, 'metal/hardcore', 'Metal Hardcore'),
(8, 'metal/hardcore', 'Crust Hardcore');

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
-- Déchargement des données de la table `suggestions`
--

INSERT INTO `suggestions` (`id_suggestion`, `nom_artiste`, `lien_titre`, `message`, `date_suggestion`) VALUES
(22, 'First Draft', 'https://open.spotify.com/intl-fr/track/09VzZulviyv2cKu9SUNc22?si=5ca46f7037b34c84', '', '2024-08-29'),
(26, 'First Draft', 'https://open.spotify.com/intl-fr/track/09VzZulviyv2cKu9SUNc22?si=5ca46f7037b34c84', '', '2024-08-29'),
(30, 'I\'VE LEARNED', 'https://open.spotify.com/intl-fr/track/09VzZulviyv2cKu9SUNc22?si=5ca46f7037b34c84', 'c\'est très cool', '2024-09-05');

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
  MODIFY `id_artiste` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `concerts`
--
ALTER TABLE `concerts`
  MODIFY `id_concert` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `genres`
--
ALTER TABLE `genres`
  MODIFY `id_genre` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `suggestions`
--
ALTER TABLE `suggestions`
  MODIFY `id_suggestion` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
