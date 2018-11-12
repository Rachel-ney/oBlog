-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Lun 12 Novembre 2018 à 13:02
-- Version du serveur :  5.7.20-0ubuntu0.16.04.1
-- Version de PHP :  7.0.22-0ubuntu0.16.04.1

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
  `image` varchar(255) NOT NULL DEFAULT 'user.jpg',
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `author`
--

INSERT INTO `author` (`id`, `name`, `image`, `email`, `created_at`, `updated_at`) VALUES
(1, 'Rachel', 'user.jpg', 'michel.rachel@hotmail.fr', '2018-11-05 21:06:58', NULL),
(2, 'Fred', 'user.jpg', 'frederick.colas835@gmail.com', '2018-11-05 21:06:58', NULL),
(3, 'Claude', 'user.jpg', 'michelclaude831@hotmail.fr', '2018-11-05 21:12:53', NULL),
(4, 'Neyress', 'user.jpg', '58akmennra36@gmail.com', '2018-11-05 21:12:53', NULL),
(6, 'User', 'myPictureUser.jpg', 'user@email.fr', '2018-11-07 20:12:31', NULL);

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
(1, 'Ivre, il refait tous les challenges en un week-end sans dormir.', 'Ou comment j\'ai appris plein de choses en faisant une nouvelle fois tous les challenges que j\'avais loupé.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque egestas libero eu felis viverra auctor. In auctor vulputate purus et porttitor. Nullam tempus nisi quis felis euismod, vitae faucibus nunc rutrum. Phasellus commodo est sed semper suscipit. In rutrum facilisis elit eget condimentum. Etiam in orci vel ante ultrices ornare quis sit amet lorem. Sed nec blandit dolor. Ut a diam vestibulum, aliquet nibh sed, dictum libero. Curabitur fringilla sodales sapien et sollicitudin. Aliquam sagittis, ligula id porta posuere, orci orci suscipit nisi, eget fermentum nisi eros non magna. Proin placerat mi at bibendum dictum. Praesent feugiat dolor sit amet mauris malesuada tincidunt congue nec ex.', '2018-11-05 21:11:21', NULL, 1, 1),
(2, 'POO or not POO, that is the question.', 'La POO est-elle vraiment indispensable pour une architecture solide ? Etude de cas avec PHP.', 'Suspendisse potenti. Nulla quis suscipit massa, et varius sapien. Maecenas lacinia tempus arcu, vel maximus lectus dapibus id. Sed euismod lectus sit amet justo rutrum faucibus. Curabitur in lorem a urna faucibus consequat eget ac ex. Donec sollicitudin purus nec sem fringilla rhoncus. Aliquam justo quam, imperdiet vitae nunc sit amet, commodo feugiat dolor. Vestibulum aliquet efficitur eros, quis blandit leo porta et. Donec vitae tortor eget sapien dictum pellentesque.', '2018-11-05 21:14:49', NULL, 2, 3),
(3, 'Git, pour les n00bs.', 'Un p\'tit récap rapide pour tout ceux qui, comme moi, ont galéré sur ce magnifique outil de versionning.', 'Proin bibendum sodales varius. Quisque pulvinar quam mauris, sed scelerisque felis vehicula eu. Ut nec nunc arcu. Pellentesque tortor diam, consequat ac consectetur ut, consectetur at mi. Nullam tempor, arcu vel cursus tincidunt, elit ante elementum felis, nec ullamcorper elit leo sit amet turpis. Cras maximus, arcu id finibus maximus, ligula ex consectetur ipsum, a tincidunt dui dui eu mi. Pellentesque metus lectus, dapibus eget tristique vel, aliquet ut tortor. Nam lobortis dignissim vulputate. Cras ullamcorper euismod nulla, sit amet condimentum lacus consectetur at.', '2018-11-05 21:14:49', NULL, 3, 2),
(4, 'Le syndrome de la page blanche', 'Cette frustration quand le code ne vient pas, le temps passe, la deadline approche...', 'Sed lectus urna, sodales quis nisi sed, ullamcorper vestibulum sapien. Etiam tempor quis orci in eleifend. Pellentesque at tincidunt lectus, id maximus lacus. Suspendisse tempus justo ut leo lacinia, in pulvinar erat condimentum. Nulla id fringilla quam. Aenean ac urna mi. In sit amet nulla at mauris commodo pulvinar nec ut urna. Ut fermentum tellus et lacus varius consequat. Ut vitae maximus dui, a congue lectus. Cras in orci nunc. Proin ac turpis vel libero scelerisque imperdiet quis sed neque. Aliquam suscipit pharetra iaculis. Nulla facilisi. Morbi eget lobortis dui. Morbi in odio fermentum, viverra nunc ac, convallis sem.', '2018-11-05 21:16:00', NULL, 4, 2),
(6, 'Comment j\'ai ajouté un nouvel article', 'C\'était un soir de pleine lune, en arrosant mes fleurs un rayon de lune m\'a frappé !', ' Lorem ipsum dolor sit amet consectetur, adipisicing elit. Odio possimus nesciunt non et sapiente numquam minus temporibus eum corrupti perferendis! ', '2018-11-07 20:11:16', NULL, 3, 2);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
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
