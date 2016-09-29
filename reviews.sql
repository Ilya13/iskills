-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Сен 29 2016 г., 13:57
-- Версия сервера: 5.6.21
-- Версия PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `iskills`
--

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE IF NOT EXISTS `reviews` (
`id` int(11) NOT NULL,
  `masterId` int(11) NOT NULL,
  `projectId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `text` varchar(2000) NOT NULL,
  `value` int(1) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `reviews`
--

INSERT INTO `reviews` (`id`, `masterId`, `projectId`, `userId`, `text`, `value`, `date`) VALUES
(1, 6, 2, 7, 'I am pleased with the cutting board. It was not as beautiful as the one he shows online, but I do understand that every board is different. But it is very heavy & does have a beautiful pattern. I am a very personable person & would expect more out of the communication department. But everyone is different & I will order from him again. This was a gift, but the next one will be for me. Thank you very much Nick.', 5, '2016-09-29'),
(2, 6, 3, 7, 'I am pleased with the cutting board. It was not as beautiful as the one he shows online, but I do understand that every board is different. But it is very heavy & does have a beautiful pattern. I am a very personable person & would expect more out of the communication department. But everyone is different & I will order from him again. This was a gift, but the next one will be for me. Thank you very much Nick.', 4, '2016-09-29'),
(3, 6, 4, 7, 'I am pleased with the cutting board. It was not as beautiful as the one he shows online, but I do understand that every board is different. But it is very heavy & does have a beautiful pattern. I am a very personable person & would expect more out of the communication department. But everyone is different & I will order from him again. This was a gift, but the next one will be for me. Thank you very much Nick.', 5, '2016-09-29'),
(4, 6, 3, 7, 'I am pleased with the cutting board. It was not as beautiful as the one he shows online, but I do understand that every board is different. But it is very heavy & does have a beautiful pattern. I am a very personable person & would expect more out of the communication department. But everyone is different & I will order from him again. This was a gift, but the next one will be for me. Thank you very much Nick.', 4, '2016-09-29'),
(5, 6, 5, 7, 'I am pleased with the cutting board. It was not as beautiful as the one he shows online, but I do understand that every board is different. But it is very heavy & does have a beautiful pattern. I am a very personable person & would expect more out of the communication department. But everyone is different & I will order from him again. This was a gift, but the next one will be for me. Thank you very much Nick.', 5, '2016-09-29'),
(6, 6, 3, 7, 'I am pleased with the cutting board. It was not as beautiful as the one he shows online, but I do understand that every board is different. But it is very heavy & does have a beautiful pattern. I am a very personable person & would expect more out of the communication department. But everyone is different & I will order from him again. This was a gift, but the next one will be for me. Thank you very much Nick.', 4, '2016-09-29'),
(7, 6, 6, 7, 'I am pleased with the cutting board. It was not as beautiful as the one he shows online, but I do understand that every board is different. But it is very heavy & does have a beautiful pattern. I am a very personable person & would expect more out of the communication department. But everyone is different & I will order from him again. This was a gift, but the next one will be for me. Thank you very much Nick.', 5, '2016-09-29'),
(8, 6, 3, 7, 'I am pleased with the cutting board. It was not as beautiful as the one he shows online, but I do understand that every board is different. But it is very heavy & does have a beautiful pattern. I am a very personable person & would expect more out of the communication department. But everyone is different & I will order from him again. This was a gift, but the next one will be for me. Thank you very much Nick.', 4, '2016-09-29'),
(9, 6, 7, 7, 'I am pleased with the cutting board. It was not as beautiful as the one he shows online, but I do understand that every board is different. But it is very heavy & does have a beautiful pattern. I am a very personable person & would expect more out of the communication department. But everyone is different & I will order from him again. This was a gift, but the next one will be for me. Thank you very much Nick.', 5, '2016-09-29'),
(10, 6, 3, 7, 'I am pleased with the cutting board. It was not as beautiful as the one he shows online, but I do understand that every board is different. But it is very heavy & does have a beautiful pattern. I am a very personable person & would expect more out of the communication department. But everyone is different & I will order from him again. This was a gift, but the next one will be for me. Thank you very much Nick.', 4, '2016-09-29'),
(11, 6, 8, 7, 'I am pleased with the cutting board. It was not as beautiful as the one he shows online, but I do understand that every board is different. But it is very heavy & does have a beautiful pattern. I am a very personable person & would expect more out of the communication department. But everyone is different & I will order from him again. This was a gift, but the next one will be for me. Thank you very much Nick.', 5, '2016-09-29'),
(12, 6, 3, 7, 'I am pleased with the cutting board. It was not as beautiful as the one he shows online, but I do understand that every board is different. But it is very heavy & does have a beautiful pattern. I am a very personable person & would expect more out of the communication department. But everyone is different & I will order from him again. This was a gift, but the next one will be for me. Thank you very much Nick.', 4, '2016-09-29'),
(13, 6, 9, 7, 'I am pleased with the cutting board. It was not as beautiful as the one he shows online, but I do understand that every board is different. But it is very heavy & does have a beautiful pattern. I am a very personable person & would expect more out of the communication department. But everyone is different & I will order from him again. This was a gift, but the next one will be for me. Thank you very much Nick.', 5, '2016-09-29'),
(14, 6, 3, 7, 'I am pleased with the cutting board. It was not as beautiful as the one he shows online, but I do understand that every board is different. But it is very heavy & does have a beautiful pattern. I am a very personable person & would expect more out of the communication department. But everyone is different & I will order from him again. This was a gift, but the next one will be for me. Thank you very much Nick.', 4, '2016-09-29'),
(15, 6, 10, 7, 'I am pleased with the cutting board. It was not as beautiful as the one he shows online, but I do understand that every board is different. But it is very heavy & does have a beautiful pattern. I am a very personable person & would expect more out of the communication department. But everyone is different & I will order from him again. This was a gift, but the next one will be for me. Thank you very much Nick.', 5, '2016-09-29'),
(16, 6, 3, 7, 'I am pleased with the cutting board. It was not as beautiful as the one he shows online, but I do understand that every board is different. But it is very heavy & does have a beautiful pattern. I am a very personable person & would expect more out of the communication department. But everyone is different & I will order from him again. This was a gift, but the next one will be for me. Thank you very much Nick.', 4, '2016-09-29');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`), ADD KEY `masterId` (`masterId`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
