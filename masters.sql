-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Сен 28 2016 г., 23:47
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
-- Структура таблицы `masters`
--

CREATE TABLE IF NOT EXISTS `masters` (
  `id` int(11) NOT NULL,
  `about` text NOT NULL,
  `shipping` text NOT NULL,
  `policies` text NOT NULL,
  `rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `masters`
--

INSERT INTO `masters` (`id`, `about`, `shipping`, `policies`, `rating`) VALUES
(5, 'Background\r\nOrganic style handmade jewelry - I love personalizing my jewelry for you. \r\nEach piece of handmade jewelry is made with lots of love and care. Not to mention the cute organic style pouches they come in. Take a wonderful piece of jewelry back with you all the way from lovely San Diego!', 'Domestic: 8$\nCanada: 12$\nAnywhere else: 15$', 'Jewelry that takes 7 days or more to make are custom made and can not be returned.\nHowever I can try to change the design or fix the item for you. Just let me know before hand if it is possible.', 4),
(6, 'Background\r\nOrganic style handmade jewelry - I love personalizing my jewelry for you. \r\nEach piece of handmade jewelry is made with lots of love and care. Not to mention the cute organic style pouches they come in. Take a wonderful piece of jewelry back with you all the way from lovely San Diego!', 'Domestic: 8$\nCanada: 12$\nAnywhere else: 15$', 'Jewelry that takes 7 days or more to make are custom made and can not be returned.\nHowever I can try to change the design or fix the item for you. Just let me know before hand if it is possible.', 5);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `masters`
--
ALTER TABLE `masters`
  ADD PRIMARY KEY (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
