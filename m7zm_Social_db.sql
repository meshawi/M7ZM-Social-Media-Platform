SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `m7zm_Social_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `m7zm_Social_db`;

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `video_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `video_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `games2rate` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `release_date` date NOT NULL,
  `image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `games2rate` (`id`, `name`, `release_date`, `image_url`) VALUES
(1, 'Overwatch 2', '2022-10-04', '../assets/games2rate images/Ow2.png'),
(2, 'Fortnite', '2017-07-21', '../assets/games2rate images/brawll.png'),
(3, 'Minecraft', '2011-11-18', '../assets/games2rate images/min.png'),
(4, 'Fortnite', '2024-05-05', '../assets/games2rate images/fortnite.png'),
(5, 'Valorant', '2020-06-02', '../assets/games2rate images/valo.png'),
(6, 'Call of Duty', '1000-01-01', '../assets/games2rate images/cod.png');

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `creator_id` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `image_tags` (
  `image_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `owtags` (
  `tag_id` int(11) NOT NULL,
  `tag_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `owtags` (`tag_id`, `tag_name`) VALUES
(1, '1 vs 1'),
(2, 'Gun Game'),
(3, '7bshah'),
(4, 'Fun'),
(5, 'challenging '),
(6, 'Training ');

CREATE TABLE `ow_custom` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT '../assets/overwatch.png',
  `date_of_upload` date DEFAULT NULL,
  `creator_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `ow_custom` (`id`, `title`, `description`, `code`, `thumbnail`, `date_of_upload`, `creator_id`) VALUES
(1, '1v1 Arena', '1v1 Arena silverdeath version', 'B27TY', '../assets/overwatch.png', '2024-05-05', NULL),
(2, '1v1 genji only', '1v1 genji only arena', 'D1CSW', '../assets/overwatch.png', '2024-05-05', NULL),
(3, '1v1 Widow ', '1v1 Widow Arena', 'aaa', '../assets/overwatch.png', '2024-05-05', NULL),
(4, '1v1 Pharah', '1v1 Pharah Arena', 'aaa', '../assets/overwatch.png', '2024-05-05', NULL),
(5, '1v1 Aimbot', '1v1 Aimbot arena', '1XRZM', '../assets/overwatch.png', '2024-05-05', NULL),
(6, '1v1 Rein', '1v1 Reinhart', 'DXSM1', '../assets/overwatch.png', '2024-05-05', NULL),
(7, 'GUN GAME Aimbot', 'GUN GAME NO CD with Aimbot', 'R94EB', '../assets/overwatch.png', '2024-05-05', NULL),
(8, 'GUN GAME', 'GUN GAME NO CD silverdeath version', 'EZVRY', '../assets/overwatch.png', '2024-05-05', NULL),
(9, '7bshh', '7bshh defualt', 'WXM2K', '../assets/overwatch.png', '2024-05-05', NULL),
(10, '7bshh Ball', '7bshh Ball overPowered', '5CN4', '../assets/overwatch.png', '2024-05-05', NULL),
(11, '7bshh no Rein', '7bshh without Reinhart', 'q4ym8', '../assets/overwatch.png', '2024-05-05', NULL),
(12, '4v4 Nano', '4v4 nano genji,ana,rein,mcree', '5PG53', '../assets/overwatch.png', '2024-05-05', NULL),
(13, '4v4 all', '4v4 all heros', 'KCVSP', '../assets/overwatch.png', '2024-05-05', NULL),
(14, 'Aim training', 'Aim training / wormup', 'VAXTA', '../assets/overwatch.png', '2024-05-05', NULL),
(15, 'Practice Range', 'Advanced Practice Range', '8M72A', '../assets/overwatch.png', '2024-05-05', NULL),
(16, 'Kill to Grow', 'Kill to Grow mod', 'R0NRY', '../assets/overwatch.png', '2024-05-05', NULL),
(17, 'Genji Dodge ball', 'Genji Dodgeball new', '5Y71E', '../assets/overwatch.png', '2024-05-05', NULL),
(18, 'Prop Hunt', 'Prop Hunt mod', 'AWQQR', '../assets/overwatch.png', '2024-05-05', NULL),
(19, 'Genji Training', 'Genji Blade/Dash Training', 'NN0VZ', '../assets/overwatch.png', '2024-05-05', NULL),
(20, 'Black Hole', 'Run from the Black Hole', '9STJG', '../assets/overwatch.png', '2024-05-05', NULL),
(21, 'Ramattra Boxing', 'Ramattra Boxing mod', 'HFPQZB', '../assets/overwatch.png', '2024-05-05', NULL),
(22, 'cassidy oneshot', 'mcree oneshot mod', '3PAWR', '../assets/overwatch.png', '2024-05-05', NULL),
(23, '500%', '500% of all abilities', 'P3QQD', '../assets/overwatch.png', '2024-05-05', NULL),
(24, '2D', '2D Overwatch', 'HA7M4', '../assets/overwatch.png', '2024-05-05', NULL),
(25, '12 Hooks 1 Hole', '12 Hooks 1 Hole mod', '02Q8B', '../assets/overwatch.png', '2024-05-05', NULL),
(26, 'Freindly fire', 'matchup game with Freindly fire enabled', 'aaa', '../assets/overwatch.png', '2024-05-05', NULL),
(27, 'Sigma doge', 'Sigma doge rock', '8P769', '../assets/overwatch.png', '2024-05-05', NULL),
(28, 'Fog', 'Fog mod', 'HHHPHB', '../assets/overwatch.png', '2024-05-05', NULL),
(29, 'car crach', 'car crach game', 'AND2Y', '../assets/overwatch.png', '2024-05-05', NULL);

CREATE TABLE `ow_custom_tags` (
  `custom_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `ow_custom_tags` (`custom_id`, `tag_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 2),
(8, 2),
(9, 3),
(10, 3),
(11, 3),
(12, 5),
(13, 5),
(14, 6),
(15, 6),
(16, 4),
(17, 5),
(18, 4),
(19, 6),
(20, 4),
(21, 5),
(22, 5),
(23, 4),
(24, 4),
(25, 4),
(26, 5),
(27, 5),
(28, 4),
(29, 4);

CREATE TABLE `restorekeys` (
  `id` int(11) NOT NULL,
  `restore_key` varchar(255) NOT NULL,
  `valid` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `restorekeys` (`id`, `restore_key`, `valid`) VALUES
(1, 'test', 1);

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tags` (`id`, `name`) VALUES
(3, 'Brawlhalla'),
(1, 'Cod'),
(7, 'Funny clip'),
(6, 'M3R8'),
(5, 'oShoyo'),
(2, 'OverWatch'),
(8, 'POTG'),
(4, 'Sanshro');

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_image` text DEFAULT NULL,
  `accessibility` tinyint(1) DEFAULT 0,
  `userType` varchar(50) DEFAULT 'user',
  `bio` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('online','offline') DEFAULT 'offline',
  `last_seen` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `video_path` varchar(255) NOT NULL,
  `thumbnail_path` varchar(255) DEFAULT NULL,
  `view_count` int(11) DEFAULT 0,
  `creator_id` int(11) DEFAULT NULL,
  `visibility` enum('public','private','unlisted') DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `video_likes` (
  `id` int(11) NOT NULL,
  `video_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `liked` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `video_tags` (
  `video_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `video_id` (`video_id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `video_id` (`video_id`);

ALTER TABLE `games2rate`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creator_id` (`creator_id`);

ALTER TABLE `image_tags`
  ADD PRIMARY KEY (`image_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

ALTER TABLE `owtags`
  ADD PRIMARY KEY (`tag_id`);

ALTER TABLE `ow_custom`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ow_custom_tags`
  ADD PRIMARY KEY (`custom_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

ALTER TABLE `restorekeys`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `game_id` (`game_id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creator_id` (`creator_id`);

ALTER TABLE `video_likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `video_id` (`video_id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `video_tags`
  ADD PRIMARY KEY (`video_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `games2rate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `owtags`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `ow_custom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

ALTER TABLE `restorekeys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `video_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`);

ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`);

ALTER TABLE `image_tags`
  ADD CONSTRAINT `image_tags_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`),
  ADD CONSTRAINT `image_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`);

ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`);

ALTER TABLE `ow_custom_tags`
  ADD CONSTRAINT `ow_custom_tags_ibfk_1` FOREIGN KEY (`custom_id`) REFERENCES `ow_custom` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ow_custom_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `owtags` (`tag_id`) ON DELETE CASCADE;

ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `games2rate` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `videos`
  ADD CONSTRAINT `videos_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`);

ALTER TABLE `video_likes`
  ADD CONSTRAINT `video_likes_ibfk_1` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`),
  ADD CONSTRAINT `video_likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `video_tags`
  ADD CONSTRAINT `video_tags_ibfk_1` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `video_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`);
COMMIT;
