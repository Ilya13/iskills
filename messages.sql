-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Авг 17 2016 г., 22:08
-- Версия сервера: 5.6.26
-- Версия PHP: 5.5.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `iskills`
--

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `masterId` int(11) NOT NULL,
  `orderId` int(11) NOT NULL,
  `text` text NOT NULL,
  `date` datetime NOT NULL,
  `author` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Сообщения пользователей';

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `userId`, `masterId`, `orderId`, `text`, `date`, `author`) VALUES
(1, 7, 5, 1, 'Здравствуйте!\nУточните размеры картины\nШирину\nВысоту\nДлину', '2016-08-03 23:59:04', 5),
(2, 7, 6, 1, 'Я сделаю дешевле!', '2016-08-02 10:21:18', 6),
(3, 7, 5, 1, 'Я сделаю быстрее', '2016-07-30 07:29:44', 5),
(4, 7, 5, 1, 'Хорошо, я буду с вами работать', '2016-07-30 17:19:25', 7);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orderId` (`orderId`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
