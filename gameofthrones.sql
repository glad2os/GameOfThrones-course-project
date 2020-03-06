-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Мар 06 2020 г., 21:48
-- Версия сервера: 10.4.12-MariaDB
-- Версия PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `gameofthrones`
--

-- --------------------------------------------------------

--
-- Структура таблицы `threads`
--

CREATE TABLE `threads` (
  `id` int(11) NOT NULL,
  `title` text COLLATE utf8_bin NOT NULL,
  `text` text COLLATE utf8_bin NOT NULL,
  `date_post` timestamp NOT NULL DEFAULT current_timestamp(),
  `img` text COLLATE utf8_bin DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `threads`
--

INSERT INTO `threads` (`id`, `title`, `text`, `date_post`, `img`, `verified`) VALUES
(1, 'Game of Thrones Season 8 Alternate Endings Debunked by Maisie Williams', 'It’s been a rumor before the final season of Game of Thrones even began filming: “they’ll shoot alternate finale scenes so the real ending doesn’t leak!” There wasn’t much reason to believe this, but showrunner David Benioff added fuel to the flames by implying as much, and a few cast members said it outright–though, as it turns out, they were either misdirecting the press for fun or misinformed themselves. Whatever their reasons, if there were still any doubts, Maisie Williams is here to put them to rest.', '2020-03-06 16:36:03', 'http://10.14.88.5/assets/img/Arya-Stark-Unsullied-Kings-Landing-Season-8-806.jpg', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `threads_links`
--

CREATE TABLE `threads_links` (
  `user_id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `threads_links`
--

INSERT INTO `threads_links` (`user_id`, `thread_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `tokens`
--

CREATE TABLE `tokens` (
  `user_id` int(11) NOT NULL,
  `token` varchar(32) COLLATE utf8_bin NOT NULL,
  `expiration` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `tokens`
--

INSERT INTO `tokens` (`user_id`, `token`, `expiration`) VALUES
(2, 'SRbI3e5F9JLGPS7NzxFlauBBf97KOFq7', '2020-03-03 05:00:53'),
(1, 'BEG6H2i6Iy0IkAlFNZkBaQUkGgUPIsQ5', '2020-03-06 09:55:55'),
(1, 'UkVvpZUlNlzEIqu83MWofIpsRTSlSwHN', '2020-03-06 10:38:27'),
(1, 'EXcdXd8pCLYcJUIhgXl5A3ABfMXRrDwn', '2020-03-07 09:14:03'),
(1, 'nLTEKmZuegP49F0sNFXDfhOqPWeaJSmx', '2020-03-07 15:58:13');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` text COLLATE utf8_bin NOT NULL,
  `password_hash` text COLLATE utf8_bin NOT NULL,
  `permissions` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password_hash`, `permissions`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1),
(2, 'qwer', '962012d09b8170d912f0669f6d7d9d07', 1),
(3, 'admin1', 'e00cf25ad42683b3df678c61f42c6bda', 1),
(4, 'a', '0cc175b9c0f1b6a831c399e269772661', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `threads`
--
ALTER TABLE `threads`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `threads_links`
--
ALTER TABLE `threads_links`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `thread_id` (`thread_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `threads`
--
ALTER TABLE `threads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `threads_links`
--
ALTER TABLE `threads_links`
  ADD CONSTRAINT `threads_links_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `threads_links_ibfk_2` FOREIGN KEY (`thread_id`) REFERENCES `threads` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
