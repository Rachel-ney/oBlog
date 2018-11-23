-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Ven 23 Novembre 2018 à 17:11
-- Version du serveur :  5.7.20-0ubuntu0.16.04.1
-- Version de PHP :  7.2.12-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `oblog`
--

-- --------------------------------------------------------

--
-- Structure de la table `author`
--

CREATE TABLE `author` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL DEFAULT 'userpassword',
  `email` varchar(100) NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `author`
--

INSERT INTO `author` (`id`, `name`, `password`, `email`, `status`, `created_at`, `updated_at`) VALUES
(38, 'Neyress', '$2y$10$m9dRU5CB/30NULsaxEiMje7Ls.gSOxBSIoubx.6pTYrKjmnSaOFAS', 'michel.rachel@hotmail.fr', 1, '2018-11-15 19:59:40', NULL),
(39, 'Riri', '$2y$10$5NiyFsbCIW0NkAWXjSnt9eK40q2RV1BmpSnJ67/GxBF1j7mDO0pWO', 'donald@gmail.com', 0, '2018-11-15 20:44:45', NULL),
(40, 'Fifi', '$2y$10$xGCSXeCrj82Ojfq0SSAr0.Se4oESJCodsWv4lv5WBPxZKKUd.rbc.', 'daffy@gmail.com', 0, '2018-11-22 13:06:43', NULL),
(41, 'Loulou', '$2y$10$hax8t8IEA2dru.SMw1QmkOSdDst0K7rLkqzjRB4Bbo.9e6wrpbmsq', 'duck@gmail.com', 0, '2018-11-22 13:43:27', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `category`
--

INSERT INTO `category` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Ma Vie De Dev', '2018-11-05 21:07:54', NULL),
(2, 'Team Front', '2018-11-05 21:07:54', NULL),
(3, 'Team Back', '2018-11-05 21:08:10', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(150) NOT NULL,
  `resume` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `author_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `post`
--

INSERT INTO `post` (`id`, `title`, `resume`, `content`, `created_at`, `updated_at`, `author_id`, `category_id`) VALUES
(1, 'Ivre, il refait tous les challenges en un week-end sans dormir.', 'Ou comment j\'ai appris plein de choses en faisant une nouvelle fois tous les challenges que j\'avais loupé.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque egestas libero eu felis viverra auctor. In auctor vulputate purus et porttitor. Nullam tempus nisi quis felis euismod, vitae faucibus nunc rutrum. Phasellus commodo est sed semper suscipit. In rutrum facilisis elit eget condimentum. Etiam in orci vel ante ultrices ornare quis sit amet lorem. Sed nec blandit dolor. Ut a diam vestibulum, aliquet nibh sed, dictum libero. Curabitur fringilla sodales sapien et sollicitudin. Aliquam sagittis, ligula id porta posuere, orci orci suscipit nisi, eget fermentum nisi eros non magna. Proin placerat mi at bibendum dictum. Praesent feugiat dolor sit amet mauris malesuada tincidunt congue nec ex.', '2018-11-05 21:11:21', NULL, 38, 1),
(2, 'POO or not POO, that is the question.', 'La POO est-elle vraiment indispensable pour une architecture solide ? Etude de cas avec PHP.', 'Suspendisse potenti. Nulla quis suscipit massa, et varius sapien. Maecenas lacinia tempus arcu, vel maximus lectus dapibus id. Sed euismod lectus sit amet justo rutrum faucibus. Curabitur in lorem a urna faucibus consequat eget ac ex. Donec sollicitudin purus nec sem fringilla rhoncus. Aliquam justo quam, imperdiet vitae nunc sit amet, commodo feugiat dolor. Vestibulum aliquet efficitur eros, quis blandit leo porta et. Donec vitae tortor eget sapien dictum pellentesque.', '2018-11-05 21:14:49', NULL, 38, 3),
(3, 'Git, pour les n00bs.', 'Un p\'tit récap rapide pour tout ceux qui, comme moi, ont galéré sur ce magnifique outil de versionning.', 'Proin bibendum sodales varius. Quisque pulvinar quam mauris, sed scelerisque felis vehicula eu. Ut nec nunc arcu. Pellentesque tortor diam, consequat ac consectetur ut, consectetur at mi. Nullam tempor, arcu vel cursus tincidunt, elit ante elementum felis, nec ullamcorper elit leo sit amet turpis. Cras maximus, arcu id finibus maximus, ligula ex consectetur ipsum, a tincidunt dui dui eu mi. Pellentesque metus lectus, dapibus eget tristique vel, aliquet ut tortor. Nam lobortis dignissim vulputate. Cras ullamcorper euismod nulla, sit amet condimentum lacus consectetur at.', '2018-11-05 21:14:49', NULL, 39, 2),
(4, 'Le syndrome de la page blanche', 'Cette frustration quand le code ne vient pas, le temps passe, la deadline approche...', 'Sed lectus urna, sodales quis nisi sed, ullamcorper vestibulum sapien. Etiam tempor quis orci in eleifend. Pellentesque at tincidunt lectus, id maximus lacus. Suspendisse tempus justo ut leo lacinia, in pulvinar erat condimentum. Nulla id fringilla quam. Aenean ac urna mi. In sit amet nulla at mauris commodo pulvinar nec ut urna. Ut fermentum tellus et lacus varius consequat. Ut vitae maximus dui, a congue lectus. Cras in orci nunc. Proin ac turpis vel libero scelerisque imperdiet quis sed neque. Aliquam suscipit pharetra iaculis. Nulla facilisi. Morbi eget lobortis dui. Morbi in odio fermentum, viverra nunc ac, convallis sem.', '2018-11-05 21:16:00', NULL, 38, 2),
(6, 'Comment j\'ai ajouté un nouvel article', 'C\'était un soir de pleine lune, en arrosant mes fleurs un rayon de lune m\'a frappé !', ' Lorem ipsum dolor sit amet consectetur, adipisicing elit. Odio possimus nesciunt non et sapiente numquam minus temporibus eum corrupti perferendis! ', '2018-11-07 20:11:16', NULL, 39, 2);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_post_author_idx` (`author_id`),
  ADD KEY `fk_post_category1_idx` (`category_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `author`
--
ALTER TABLE `author`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
