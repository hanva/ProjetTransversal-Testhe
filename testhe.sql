-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 04 juin 2018 à 21:19
-- Version du serveur :  5.7.19
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
-- Base de données :  `testhe`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET latin1 NOT NULL,
  `user_id` int(10) NOT NULL,
  `pic` varchar(255) CHARACTER SET latin1 NOT NULL,
  `content` text CHARACTER SET latin1 NOT NULL,
  `creation` datetime NOT NULL,
  `is_recette` smallint(1) NOT NULL,
  `recette_ingredients` varchar(255) COLLATE utf8_bin NOT NULL,
  `likes` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=146 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `title`, `user_id`, `pic`, `content`, `creation`, `is_recette`, `recette_ingredients`, `likes`) VALUES
(145, 'dazazdazd', 179, '0f6d75b68fefb9403baa3f52073648a5.jpg', '<p>adzadzazdadz</p>', '2018-05-31 07:58:08', 1, 'dazdazazdadz ,adzadzadz', 0),
(139, 'Camellia Assamica', 179, '27-Benefits-Of-Rooibos-Tea-For-Your-Health-1.jpg', '<p>La variÃ©tÃ© Ã  grandes feuilles Camellia Sinensis variÃ©tÃ© Assamica, Bien quâ€™en terme de rendement cette variÃ©tÃ© soit plus productive,elle contient une grande concentration de tanins (goÃ»t amer) et offre des bienfaits pour la santÃ© infÃ©rieurs Ã  son homologue, la variÃ©tÃ© Sinensis.</p>', '2018-05-30 11:53:02', 0, '', 0),
(142, 'tg', 179, '8327518-13043435.jpg', '<p>dsffhfasdgbfgdsfsSQ</p>', '2018-05-30 12:13:46', 0, '', 0),
(143, 'dazazdazd', 179, '0f6d75b68fefb9403baa3f52073648a5.jpg', '<p>adzadzazdadz</p>', '2018-05-31 07:58:01', 1, 'dazdazazdadz ', 0),
(144, 'dazazdazd', 179, '0f6d75b68fefb9403baa3f52073648a5.jpg', '<p>adzadzazdadz</p>', '2018-05-31 07:58:03', 1, 'dazdazazdadz ,adzadzadz', 0),
(141, 'Rooibos', 179, 'Black-Tea-is-Red-When-Brewed-700x325.jpg', '<p>En Afrique du Sud, câ€™est la boisson reine gÃ©nÃ©ralement consommÃ©e avec du lait. On rÃ©colte les rameaux avec ses feuilles, on les passe dans des rouleuses pour y casser les fibres et ainsi commencer la fermentation. </p>', '2018-05-30 11:54:06', 0, '', 1);

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `article_id` int(10) NOT NULL,
  `content` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=74 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `article_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=258 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `article_id`) VALUES
(257, 179, 141);

-- --------------------------------------------------------

--
-- Structure de la table `operations`
--

DROP TABLE IF EXISTS `operations`;
CREATE TABLE IF NOT EXISTS `operations` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_username` varchar(10) NOT NULL,
  `action` varchar(255) NOT NULL,
  `type` set('log','error') NOT NULL,
  `content` varchar(255) NOT NULL,
  `creation` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=189 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `operations`
--

INSERT INTO `operations` (`id`, `user_username`, `action`, `type`, `content`, `creation`) VALUES
(110, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 106', '2018-05-28 21:10:52'),
(109, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 107', '2018-05-28 21:10:52'),
(108, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 108', '2018-05-28 21:10:52'),
(107, 'hanva100', 'writeCommentAction', 'log', 'New Comment : ', '2018-05-28 18:33:00'),
(106, 'hanva100', 'writeCommentAction', 'log', 'New Comment : ', '2018-05-28 18:32:52'),
(105, 'hanva100', 'writeCommentAction', 'log', 'New Comment : ', '2018-05-28 18:32:10'),
(104, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-28 18:10:50'),
(103, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-28 17:59:25'),
(102, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-28 17:59:10'),
(101, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-28 17:58:43'),
(100, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-28 17:58:36'),
(99, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-28 17:57:41'),
(98, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-28 17:45:00'),
(97, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-28 17:44:53'),
(96, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-28 17:44:50'),
(95, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-28 17:44:37'),
(94, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-28 17:44:31'),
(93, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-28 17:44:22'),
(92, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-28 17:44:06'),
(91, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-28 17:44:00'),
(90, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-28 17:43:54'),
(89, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-28 17:43:49'),
(88, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-28 17:43:45'),
(87, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-28 17:43:34'),
(86, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-28 17:33:41'),
(85, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-28 17:33:35'),
(84, 'Hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-28 14:55:34'),
(83, 'Hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-28 14:55:25'),
(82, 'Hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-28 14:49:09'),
(81, 'Hanva100', 'writeCommentAction', 'log', 'New Comment : ', '2018-05-28 14:48:40'),
(80, 'Hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-28 14:48:26'),
(79, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-28 14:42:53'),
(78, 'hanva100', 'addArticleAction', 'error', 'Tried to add Article as User', '2018-05-28 13:28:48'),
(77, 'hanva100', 'boAction', 'error', 'Tried to acces to the back-office ', '2018-05-28 13:28:45'),
(76, 'hanva100', 'modifyDataBaseAction', 'log', 'Modified  user : 179', '2018-05-28 13:28:44'),
(75, 'hanva100', 'modifyDataBaseAction', 'log', 'Modified  user : 180', '2018-05-28 13:28:36'),
(74, 'hanva100', 'modifyDataBaseAction', 'log', 'Modified  user : 179', '2018-05-28 13:27:00'),
(73, 'hanva100', 'deleteUserAction', 'log', 'Deleted  user : 181', '2018-05-28 13:19:51'),
(72, 'hanva100', 'addArticleAction', 'error', 'Tried to add Article as User', '2018-05-28 13:18:14'),
(71, 'hanva100', 'addArticleAction', 'error', 'Tried to add Article as User', '2018-05-28 13:18:06'),
(70, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-28 13:14:01'),
(69, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-28 11:54:13'),
(68, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 80', '2018-05-25 21:03:23'),
(67, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 81', '2018-05-25 21:03:22'),
(66, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-25 19:07:37'),
(65, 'hanva100', 'writeCommentAction', 'log', 'New Comment : ', '2018-05-25 18:55:27'),
(64, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-25 18:55:00'),
(63, 'hanva100', 'deleteUserAction', 'log', 'Deleted  user : 182', '2018-05-25 18:54:39'),
(62, 'hanva100', 'deleteUserAction', 'log', 'Deleted  user : 183', '2018-05-25 18:54:38'),
(61, 'hanva100', 'deleteUserAction', 'log', 'Deleted  user : 194', '2018-05-25 18:54:38'),
(60, 'hanva100', 'deleteUserAction', 'log', 'Deleted  user : 195', '2018-05-25 18:54:38'),
(111, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 105', '2018-05-28 21:10:52'),
(112, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 104', '2018-05-28 21:10:52'),
(113, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 103', '2018-05-28 21:10:52'),
(114, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 102', '2018-05-28 21:10:53'),
(115, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 101', '2018-05-28 21:10:53'),
(116, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 100', '2018-05-28 21:10:53'),
(117, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 99', '2018-05-28 21:10:53'),
(118, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 98', '2018-05-28 21:10:53'),
(119, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 97', '2018-05-28 21:10:54'),
(120, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 96', '2018-05-28 21:10:54'),
(121, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 95', '2018-05-28 21:10:54'),
(122, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 94', '2018-05-28 21:10:54'),
(123, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 93', '2018-05-28 21:10:54'),
(124, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 92', '2018-05-28 21:10:54'),
(125, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 91', '2018-05-28 21:10:55'),
(126, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 90', '2018-05-28 21:10:55'),
(127, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 89', '2018-05-28 21:10:55'),
(128, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 88', '2018-05-28 21:10:55'),
(129, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 87', '2018-05-28 21:10:55'),
(130, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 86', '2018-05-28 21:10:56'),
(131, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 85', '2018-05-28 21:10:56'),
(132, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 84', '2018-05-28 21:10:56'),
(133, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 83', '2018-05-28 21:10:56'),
(134, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 82', '2018-05-28 21:10:56'),
(135, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-28 21:58:03'),
(136, 'hanva100', 'addArticleAction', 'error', 'Tried to pass ../ in file', '2018-05-29 14:19:25'),
(137, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-29 21:15:27'),
(138, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-29 21:15:44'),
(139, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-29 21:16:38'),
(140, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-29 21:18:42'),
(141, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-29 21:19:03'),
(142, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-29 21:21:18'),
(143, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-29 21:21:56'),
(144, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-29 21:25:54'),
(145, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-29 21:32:35'),
(146, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-29 21:33:05'),
(147, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-29 21:33:13'),
(148, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-29 21:33:51'),
(149, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-29 21:34:26'),
(150, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-29 21:35:00'),
(151, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-29 21:35:07'),
(152, 'hanva100', 'addArticleAction', 'log', 'Created a Recipe', '2018-05-29 21:35:49'),
(153, 'hanva100', 'addArticleAction', 'log', 'Created a Recipe', '2018-05-29 21:35:55'),
(154, 'hanva100', 'addArticleAction', 'log', 'Created a Recipe', '2018-05-29 21:36:33'),
(155, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 126', '2018-05-29 21:36:50'),
(156, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-29 21:43:50'),
(157, 'hanva100', 'addArticleAction', 'log', 'Created a Recipe', '2018-05-29 21:43:57'),
(158, 'hanva100', 'addArticleAction', 'log', 'Created a Recipe', '2018-05-29 21:44:34'),
(159, 'hanva100', 'addArticleAction', 'log', 'Created a Recipe', '2018-05-29 21:48:27'),
(160, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-29 21:49:25'),
(161, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-29 21:49:27'),
(162, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-29 21:49:31'),
(163, 'hanva100', 'addArticleAction', 'log', 'Created a Recipe', '2018-05-29 21:49:36'),
(164, 'hanva100', 'addArticleAction', 'log', 'Created a Recipe', '2018-05-29 21:49:50'),
(165, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-30 08:25:09'),
(166, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 133', '2018-05-30 08:26:59'),
(167, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 132', '2018-05-30 08:27:00'),
(168, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 131', '2018-05-30 08:27:00'),
(169, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 127', '2018-05-30 08:27:01'),
(170, 'hanva100', 'addArticleAction', 'log', 'Created a Recipe', '2018-05-30 10:05:31'),
(171, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 137', '2018-05-30 10:12:20'),
(172, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 136', '2018-05-30 10:12:20'),
(173, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 135', '2018-05-30 10:12:20'),
(174, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 134', '2018-05-30 10:12:21'),
(175, 'hanva100', 'deleteArticleAction', 'log', 'Deleted  article : 130', '2018-05-30 10:12:22'),
(176, 'hanva100', 'modifyArticleAction', 'log', 'modified an article', '2018-05-30 10:14:21'),
(177, 'hanva100', 'modifyArticleAction', 'log', 'modified an article', '2018-05-30 10:14:43'),
(178, 'hanva100', 'modifyArticleAction', 'log', 'modified an article', '2018-05-30 10:23:56'),
(179, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-30 11:18:41'),
(180, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-30 11:21:19'),
(181, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-30 11:43:32'),
(182, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-30 11:43:39'),
(183, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-30 11:44:54'),
(184, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-30 11:54:06'),
(185, 'hanva100', 'addArticleAction', 'log', 'Created an article', '2018-05-30 12:13:46'),
(186, 'Hanva100', 'addArticleAction', 'log', 'Created a Recipe', '2018-05-31 07:58:01'),
(187, 'Hanva100', 'addArticleAction', 'log', 'Created a Recipe', '2018-05-31 07:58:03'),
(188, 'Hanva100', 'addArticleAction', 'log', 'Created a Recipe', '2018-05-31 07:58:08');

-- --------------------------------------------------------

--
-- Structure de la table `rubriques`
--

DROP TABLE IF EXISTS `rubriques`;
CREATE TABLE IF NOT EXISTS `rubriques` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `rubrique` varchar(255) CHARACTER SET latin1 NOT NULL,
  `tag` varchar(255) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `rubriques`
--

INSERT INTO `rubriques` (`id`, `article_id`, `rubrique`, `tag`) VALUES
(69, 145, 'Plats', 'Plats cuisinÃ©s'),
(68, 144, 'Plats', 'Plats cuisinÃ©s'),
(67, 143, 'Plats', 'Plats cuisinÃ©s');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) CHARACTER SET latin1 NOT NULL,
  `lastname` varchar(255) CHARACTER SET latin1 NOT NULL,
  `birthday` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 NOT NULL,
  `username` varchar(255) CHARACTER SET latin1 NOT NULL,
  `creation` datetime NOT NULL,
  `cle` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `valid` smallint(1) NOT NULL,
  `moderator` smallint(1) NOT NULL,
  `superadmin` smallint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=196 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `birthday`, `email`, `description`, `password`, `username`, `creation`, `cle`, `valid`, `moderator`, `superadmin`) VALUES
(179, 'nico', 'lemeilleur', '27 septembre 2000', 'Nicolas_tran@live.fr', 'jtm bb', '1eb0f77975621f26a4f73c83a66a7b3d6effd3c1', 'Hanva100', '2018-05-24 14:51:31', '80823903de7241b7ebb8256ae659a1a3', 1, 1, 1),
(180, 'dazazd', '', '', 'Hanva100@live.Fr', '', '1eb0f77975621f26a4f73c83a66a7b3d6effd3c1', 'dazdza', '2018-05-24 22:30:10', '98f2bb7a1a07c4a48fd32bde8e7b4bb2', 0, 0, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
