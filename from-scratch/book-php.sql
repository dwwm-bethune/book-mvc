-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : jeu. 15 juin 2023 à 14:16
-- Version du serveur : 11.0.2-MariaDB
-- Version de PHP : 8.1.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `book-php`
--

-- --------------------------------------------------------

--
-- Structure de la table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `discount` int(11) DEFAULT NULL,
  `isbn` varchar(13) NOT NULL,
  `author` varchar(255) NOT NULL,
  `published_at` date NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `books`
--

INSERT INTO `books` (`id`, `title`, `price`, `discount`, `isbn`, `author`, `published_at`, `image`) VALUES
(1, 'Quae dolor itaque natus reiciendis ad quae.', 38, 19, '8248827583739', 'Denise-Sabine Bernard', '2014-08-18', 'uploads/06.jpg'),
(2, 'In in facilis quam vitae.', 26, 0, '3680780915', 'Nicolas de la Courtois', '1987-10-22', 'uploads/05.jpg'),
(3, 'Dolorum sit veritatis atque rerum cum quaerat.', 78, 20, '0432990694820', 'Aimé Martineau', '2008-08-07', 'uploads/02.jpg'),
(4, 'Illo deleniti commodi ex.', 29, 18, '7445094667310', 'Arthur Allard', '1991-07-23', 'uploads/01.jpg'),
(5, 'Et modi sit dolorum.', 45, 18, '0857622132295', 'Alphonse Gros', '1981-10-04', 'uploads/02.jpg'),
(6, 'Quam iusto natus eos.', 62, 11, '9478341825490', 'Théodore Francois', '2013-02-09', 'uploads/03.jpg'),
(7, 'Natus possimus modi sint hic ut tempore.', 68, 10, '0873356029069', 'René Joly', '1996-01-30', 'uploads/06.jpg'),
(8, 'Maxime vel ut similique.', 25, 10, '0593548548504', 'Henriette Gomes', '1975-08-20', 'uploads/05.jpg'),
(9, 'Quia officia dignissimos et natus a.', 50, 11, '1309708700366', 'Guillaume Leleu', '2021-09-29', 'uploads/05.jpg'),
(10, 'Enim et omnis aliquid.', 60, 14, '1223719243691', 'Louise Guyon', '1994-04-24', 'uploads/05.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `token`) VALUES
(1, 'matthieu@boxydev.com', '$2y$10$JatyI8wu7gKpvlarkFFbhuXg4j9OTJS5UM.J9X6NOeLMGQ.NByC76', '9949187e58e34d8a61616b81f56a2c5f4d75d1603455418e96fd207757d0a6a5bec735425e28272cdc075114a1cbb6a42600b088b91a4933070ac35673b06092'),
(2, 'fiorella@boxydev.com', '$2y$10$cryk3U27Qj1pHzJ5otPO2.sU5LoIvjASzveg9t870e/h.5XVa5BEe', NULL),
(3, 'mathieu@boxydev.com', '$2y$10$x6XS3hgQUVPT3ZBW8zqiX.aao07REPYQf26imsF3VGiHOs9EH3lLW', '79674d30a14cbf11768fc607477aba7b68be14b081142e499bb59485b5d630fc8218c81e5d44d8ceb6801736fb05b4447ee60c262ad267fe00e9ef980c1fb5e5');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
