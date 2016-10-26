-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 26 Octobre 2016 à 15:05
-- Version du serveur :  5.7.11
-- Version de PHP :  7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
set global sql_mode='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
set session sql_mode='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `matcha`
--

-- --------------------------------------------------------

--
-- Structure de la table `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `id_auteur` int(11) NOT NULL,
  `id_receiver` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `updated_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `id_users_visited` int(11) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `updated_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `likable`
--

CREATE TABLE `likable` (
  `id` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `id_users_like` int(11) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `updated_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `id_users_send` int(11) NOT NULL,
  `reading` tinyint(1) NOT NULL DEFAULT '0',
  `loaded` tinyint(4) NOT NULL DEFAULT '0',
  `message` varchar(255) NOT NULL,
  `href` varchar(255) DEFAULT NULL,
  `created_at` varchar(255) NOT NULL,
  `updated_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `reported`
--

CREATE TABLE `reported` (
  `id` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `id_users_reported` int(11) NOT NULL,
  `updated_at` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `last_seen` varchar(255) DEFAULT NULL,
  `isConnected` tinyint(1) NOT NULL DEFAULT '0',
  `salt` varchar(255) DEFAULT NULL,
  `created_at` varchar(255) NOT NULL,
  `updated_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `usersblocked`
--

CREATE TABLE `usersblocked` (
  `id` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `id_users_block` int(11) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `updated_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Index pour les tables exportées
--

--
-- Index pour la table `chat`
--
ALTER TABLE `chat`
  ADD KEY `id_auteur` (`id_auteur`),
  ADD KEY `id_receiver` (`id_receiver`),
  ADD KEY `id` (`id`);

--
-- Index pour la table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_users` (`id_users`),
  ADD KEY `id_users_visited` (`id_users_visited`);

--
-- Index pour la table `likable`
--
ALTER TABLE `likable`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_users_like` (`id_users_like`),
  ADD KEY `id_users` (`id_users`);

--
-- Index pour la table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_users` (`id_users`),
  ADD KEY `id_users_send` (`id_users_send`);

--
-- Index pour la table `reported`
--
ALTER TABLE `reported`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_users` (`id_users`),
  ADD KEY `id_users_reported` (`id_users_reported`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mail` (`mail`);

--
-- Index pour la table `usersblocked`
--
ALTER TABLE `usersblocked`
  ADD KEY `id_users` (`id_users`),
  ADD KEY `id_users_block` (`id_users_block`),
  ADD KEY `id` (`id`);

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
-- AUTO_INCREMENT pour la table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;
--
-- AUTO_INCREMENT pour la table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;
--
-- AUTO_INCREMENT pour la table `likable`
--
ALTER TABLE `likable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
--
-- AUTO_INCREMENT pour la table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=252;
--
-- AUTO_INCREMENT pour la table `reported`
--
ALTER TABLE `reported`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT pour la table `usersblocked`
--
ALTER TABLE `usersblocked`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `usersImage`
--
ALTER TABLE `usersImage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT pour la table `usersInterest`
--
ALTER TABLE `usersInterest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;
--
-- AUTO_INCREMENT pour la table `usersLocation`
--
ALTER TABLE `usersLocation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT pour la table `users_usersInterest`
--
ALTER TABLE `users_usersInterest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `userS_auteur` FOREIGN KEY (`id_auteur`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `users_receiver` FOREIGN KEY (`id_receiver`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `userS_visited` FOREIGN KEY (`id_users_visited`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `users_history` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `likable`
--
ALTER TABLE `likable`
  ADD CONSTRAINT `users_like` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `users_like_like` FOREIGN KEY (`id_users_like`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notif_users` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `notif_users_send` FOREIGN KEY (`id_users_send`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `reported`
--
ALTER TABLE `reported`
  ADD CONSTRAINT `users-users-report` FOREIGN KEY (`id_users_reported`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `users_report` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `usersblocked`
--
ALTER TABLE `usersblocked`
  ADD CONSTRAINT `id_users` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `id_users_block` FOREIGN KEY (`id_users_block`) REFERENCES `users` (`id`);

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
