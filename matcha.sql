-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 28 Septembre 2016 à 11:22
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
  `popularity` int(11) NOT NULL DEFAULT '0',
  `created_at` varchar(255) NOT NULL,
  `updated_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `mail`, `nickname`, `name`, `lastname`, `passwd`, `gender`, `orientation`, `age`, `popularity`, `created_at`, `updated_at`) VALUES
(6, 'tauvray@student.42.fr', 'Frosties', 'thibault', 'auvray', '4925da7da7a56260baf1c37925a8fa24e46ad8b107dcd21f44e39e4751bae1304fc70de7acb847ffa96126bb372de005f5320f1ede6f9df07c7d53f9c160f022', 'm', NULL, 28, 0, '14/09/2016 16:15:50', '17/09/2016 13:02:10'),
(7, 'ta@ta.fr', 'Frosties', 'thibault', 'auvray', '4925da7da7a56260baf1c37925a8fa24e46ad8b107dcd21f44e39e4751bae1304fc70de7acb847ffa96126bb372de005f5320f1ede6f9df07c7d53f9c160f022', 'm', 'hetero', 25, 0, '16/09/2016 12:55:17', '17/09/2016 13:03:07'),
(8, 'ta@gmail.com', 'test', 'test', 'test', '4925da7da7a56260baf1c37925a8fa24e46ad8b107dcd21f44e39e4751bae1304fc70de7acb847ffa96126bb372de005f5320f1ede6f9df07c7d53f9c160f022', 'f', 'hetero', 24, 0, '', ''),
(9, 'das@le.fr', 'ldkjask', 'kfdhsj', 'jfdhs', '4925da7da7a56260baf1c37925a8fa24e46ad8b107dcd21f44e39e4751bae1304fc70de7acb847ffa96126bb372de005f5320f1ede6f9df07c7d53f9c160f022', 'm', 'homosexuel', 14, 20, '', '28/09/2016 11:17:09'),
(10, 'dbs@le.fr', 'ldkjask', 'kfdhsj', 'jfdhs', '4925da7da7a56260baf1c37925a8fa24e46ad8b107dcd21f44e39e4751bae1304fc70de7acb847ffa96126bb372de005f5320f1ede6f9df07c7d53f9c160f022', 'f', 'bisexuel', 24, 15, '', '28/09/2016 11:18:31'),
(11, 'dcs@le.fr', 'ldkjask', 'kfdhsj', 'jfdhs', '4925da7da7a56260baf1c37925a8fa24e46ad8b107dcd21f44e39e4751bae1304fc70de7acb847ffa96126bb372de005f5320f1ede6f9df07c7d53f9c160f022', 'm', 'hetero', 30, 5, '', '28/09/2016 11:19:33'),
(12, 'dds@le.fr', 'ldkjask', 'kfdhsj', 'jfdhs', '4925da7da7a56260baf1c37925a8fa24e46ad8b107dcd21f44e39e4751bae1304fc70de7acb847ffa96126bb372de005f5320f1ede6f9df07c7d53f9c160f022', 'm', 'homosexuel', 28, 5, '', '28/09/2016 11:20:09'),
(13, 'des@le.fr', 'ldkjask', 'kfdhsj', 'jfdhs', '4925da7da7a56260baf1c37925a8fa24e46ad8b107dcd21f44e39e4751bae1304fc70de7acb847ffa96126bb372de005f5320f1ede6f9df07c7d53f9c160f022', 'f', 'homosexuel', 31, 10, '', '28/09/2016 11:20:49'),
(14, 'dfs@le.fr', 'ldkjask', 'kfdhsj', 'jfdhs', '4925da7da7a56260baf1c37925a8fa24e46ad8b107dcd21f44e39e4751bae1304fc70de7acb847ffa96126bb372de005f5320f1ede6f9df07c7d53f9c160f022', 'm', 'bisexuel', 24, 10, '', '28/09/2016 11:21:37');

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
(46, 'jul', '17/09/2016 13:03:07', '17/09/2016 13:03:07'),
(47, 'chalumeau', '28/09/2016 11:18:31', '28/09/2016 11:18:31'),
(48, 'caroote', '28/09/2016 11:19:33', '28/09/2016 11:19:33'),
(49, 'bidul', '28/09/2016 11:19:33', '28/09/2016 11:19:33'),
(50, 'kacher', '28/09/2016 11:20:09', '28/09/2016 11:20:09'),
(51, 'hamburger', '28/09/2016 11:20:09', '28/09/2016 11:20:09'),
(52, 'jddfjh', '28/09/2016 11:20:49', '28/09/2016 11:20:49'),
(53, 'jfdsh', '28/09/2016 11:20:49', '28/09/2016 11:20:49'),
(54, 'lol', '28/09/2016 11:20:49', '28/09/2016 11:20:49'),
(55, 'kilili', '28/09/2016 11:21:37', '28/09/2016 11:21:37');

-- --------------------------------------------------------

--
-- Structure de la table `usersLocation`
--

CREATE TABLE `usersLocation` (
  `id` int(11) NOT NULL,
  `longitude` float DEFAULT NULL,
  `latitude` float DEFAULT NULL,
  `zipCode` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `id_users` int(11) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `updated_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `usersLocation`
--

INSERT INTO `usersLocation` (`id`, `longitude`, `latitude`, `zipCode`, `city`, `id_users`, `created_at`, `updated_at`) VALUES
(4, 2.2667, 48.8833, '92200', 'Neuilly-sur-Seine', 6, '14/09/2016 16:15:51', '17/09/2016 13:34:41'),
(5, 2.35183, 48.8435, '', 'Paris 5e', 9, '28/09/2016 10:14:06', '28/09/2016 11:12:54'),
(6, 1.18362, 47.3431, NULL, '41400 Montrichard', 10, '28/09/2016 11:18:41', '28/09/2016 11:18:48'),
(7, 2.33105, 48.864, NULL, 'Paris 1e', 11, '28/09/2016 11:19:35', '28/09/2016 11:19:41'),
(8, 2.28537, 48.9142, NULL, '92600 AsniÃ¨res-sur-Seine', 12, '28/09/2016 11:20:10', '28/09/2016 11:20:20'),
(9, 2.26851, 48.8848, NULL, 'Neuilly-sur-Seine', 13, '28/09/2016 11:20:51', '28/09/2016 11:21:00'),
(10, 2.2847, 48.8586, NULL, 'Paris 16', 14, '28/09/2016 11:21:20', '28/09/2016 11:21:24');

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
(106, 7, 46, '17/09/2016 13:03:07', '17/09/2016 13:03:07'),
(107, 9, 42, '28/09/2016 11:17:09', '28/09/2016 11:17:09'),
(108, 9, 43, '28/09/2016 11:17:09', '28/09/2016 11:17:09'),
(109, 10, 47, '28/09/2016 11:18:31', '28/09/2016 11:18:31'),
(110, 10, 42, '28/09/2016 11:18:31', '28/09/2016 11:18:31'),
(111, 10, 45, '28/09/2016 11:18:31', '28/09/2016 11:18:31'),
(112, 11, 48, '28/09/2016 11:19:33', '28/09/2016 11:19:33'),
(113, 11, 45, '28/09/2016 11:19:33', '28/09/2016 11:19:33'),
(114, 11, 49, '28/09/2016 11:19:33', '28/09/2016 11:19:33'),
(115, 12, 50, '28/09/2016 11:20:09', '28/09/2016 11:20:09'),
(116, 12, 51, '28/09/2016 11:20:09', '28/09/2016 11:20:09'),
(117, 12, 43, '28/09/2016 11:20:09', '28/09/2016 11:20:09'),
(118, 13, 52, '28/09/2016 11:20:49', '28/09/2016 11:20:49'),
(119, 13, 53, '28/09/2016 11:20:49', '28/09/2016 11:20:49'),
(120, 13, 54, '28/09/2016 11:20:49', '28/09/2016 11:20:49'),
(121, 14, 43, '28/09/2016 11:21:37', '28/09/2016 11:21:37'),
(122, 14, 42, '28/09/2016 11:21:37', '28/09/2016 11:21:37'),
(123, 14, 45, '28/09/2016 11:21:37', '28/09/2016 11:21:37'),
(124, 14, 55, '28/09/2016 11:21:37', '28/09/2016 11:21:37');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT pour la table `usersImage`
--
ALTER TABLE `usersImage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `usersInterest`
--
ALTER TABLE `usersInterest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT pour la table `usersLocation`
--
ALTER TABLE `usersLocation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `users_usersInterest`
--
ALTER TABLE `users_usersInterest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;
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
