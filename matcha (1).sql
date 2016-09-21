-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Sam 17 Septembre 2016 à 13:45
-- Version du serveur :  5.7.11
-- Version de PHP :  7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `matcha`
--

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `gender` varchar(1) DEFAULT NULL,
  `orientation` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `created_at` varchar(255) NOT NULL,
  `updated_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `mail`, `nickname`, `name`, `lastname`, `passwd`, `gender`, `orientation`, `age`, `created_at`, `updated_at`) VALUES
(6, 'tauvray@student.42.fr', 'Frosties', 'thibault', 'auvray', '4925da7da7a56260baf1c37925a8fa24e46ad8b107dcd21f44e39e4751bae1304fc70de7acb847ffa96126bb372de005f5320f1ede6f9df07c7d53f9c160f022', 'm', NULL, 28, '14/09/2016 16:15:50', '17/09/2016 13:02:10'),
(7, 'ta@ta.fr', 'Frosties', 'thibault', 'auvray', '4925da7da7a56260baf1c37925a8fa24e46ad8b107dcd21f44e39e4751bae1304fc70de7acb847ffa96126bb372de005f5320f1ede6f9df07c7d53f9c160f022', 'm', 'hetero', 25, '16/09/2016 12:55:17', '17/09/2016 13:03:07');

-- --------------------------------------------------------

--
-- Structure de la table `usersImage`
--

CREATE TABLE `usersImage` (
  `id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `isprofil` tinyint(4) NOT NULL,
  `id_users` int(11) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `updated_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `usersImage`
--

INSERT INTO `usersImage` (`id`, `url`, `isprofil`, `id_users`, `created_at`, `updated_at`) VALUES
(1, '57d93e46dea1c.png', 1, 5, '', ''),
(2, '57d93e518a160.png', 1, 5, '', ''),
(3, '57d93e518b768.jpeg', 0, 5, '', '');

-- --------------------------------------------------------

--
-- Structure de la table `usersInterest`
--

CREATE TABLE `usersInterest` (
  `id` int(11) NOT NULL,
  `interest` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `updated_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `usersInterest`
--

INSERT INTO `usersInterest` (`id`, `interest`, `created_at`, `updated_at`) VALUES
(42, 'poil', '17/09/2016 12:55:08', '17/09/2016 12:55:08'),
(43, 'carotte', '17/09/2016 12:55:08', '17/09/2016 12:55:08'),
(44, '', '17/09/2016 12:56:52', '17/09/2016 12:56:52'),
(45, 'tracteur', '17/09/2016 13:02:00', '17/09/2016 13:02:00'),
(46, 'jul', '17/09/2016 13:03:07', '17/09/2016 13:03:07');

-- --------------------------------------------------------

--
-- Structure de la table `usersLocation`
--

CREATE TABLE `usersLocation` (
  `id` int(11) NOT NULL,
  `longitude` float NOT NULL,
  `latitude` float NOT NULL,
  `zipCode` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `id_users` int(11) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `updated_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `usersLocation`
--

INSERT INTO `usersLocation` (`id`, `longitude`, `latitude`, `zipCode`, `city`, `id_users`, `created_at`, `updated_at`) VALUES
(4, 2.2667, 48.8833, '92200', 'Neuilly-sur-Seine', 6, '14/09/2016 16:15:51', '17/09/2016 13:34:41');

-- --------------------------------------------------------

--
-- Structure de la table `users_usersInterest`
--

CREATE TABLE `users_usersInterest` (
  `id` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `id_interest` int(11) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `updated_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `users_usersInterest`
--

INSERT INTO `users_usersInterest` (`id`, `id_users`, `id_interest`, `created_at`, `updated_at`) VALUES
(100, 6, 42, '17/09/2016 13:02:10', '17/09/2016 13:02:10'),
(101, 6, 43, '17/09/2016 13:02:10', '17/09/2016 13:02:10'),
(102, 6, 45, '17/09/2016 13:02:10', '17/09/2016 13:02:10'),
(103, 7, 42, '17/09/2016 13:03:07', '17/09/2016 13:03:07'),
(104, 7, 43, '17/09/2016 13:03:07', '17/09/2016 13:03:07'),
(105, 7, 45, '17/09/2016 13:03:07', '17/09/2016 13:03:07'),
(106, 7, 46, '17/09/2016 13:03:07', '17/09/2016 13:03:07');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mail` (`mail`);

--
-- Index pour la table `usersImage`
--
ALTER TABLE `usersImage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_users` (`id_users`);

--
-- Index pour la table `usersInterest`
--
ALTER TABLE `usersInterest`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `usersLocation`
--
ALTER TABLE `usersLocation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_users` (`id_users`);

--
-- Index pour la table `users_usersInterest`
--
ALTER TABLE `users_usersInterest`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_interest` (`id_interest`),
  ADD KEY `id_users` (`id_users`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `usersImage`
--
ALTER TABLE `usersImage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `usersInterest`
--
ALTER TABLE `usersInterest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT pour la table `usersLocation`
--
ALTER TABLE `usersLocation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `users_usersInterest`
--
ALTER TABLE `users_usersInterest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `usersImage`
--
ALTER TABLE `usersImage`
  ADD CONSTRAINT `users-usersimage` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `usersLocation`
--
ALTER TABLE `usersLocation`
  ADD CONSTRAINT `userS_location` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `users_usersInterest`
--
ALTER TABLE `users_usersInterest`
  ADD CONSTRAINT `userS_usersinterest` FOREIGN KEY (`id_interest`) REFERENCES `usersInterest` (`id`),
  ADD CONSTRAINT `users_users` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
