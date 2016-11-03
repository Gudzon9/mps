-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Ноя 03 2016 г., 02:39
-- Версия сервера: 5.5.25
-- Версия PHP: 5.4.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `mps`
--

-- --------------------------------------------------------

--
-- Структура таблицы `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_klient` int(11) NOT NULL,
  `id_type` int(11) NOT NULL,
  `allDay` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `prim` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `klient` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `id_klient` (`id_klient`),
  KEY `id_type` (`id_type`),
  KEY `start` (`start`),
  KEY `status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `event`
--

INSERT INTO `event` (`id`, `id_klient`, `id_type`, `allDay`, `start`, `end`, `prim`, `status`, `klient`, `type`, `color`, `title`) VALUES
(1, 1, 1, 'false', '2016-11-02 10:00:00', '2016-11-02 12:00:00', 'primitka', 0, 'klient', 'call', '#F0AD4E', 'uhriutyiurhnvckjsdnv');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
