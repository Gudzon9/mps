-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Ноя 04 2016 г., 17:25
-- Версия сервера: 5.5.25
-- Версия PHP: 5.4.40

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
-- Структура таблицы `kagent`
--

CREATE TABLE IF NOT EXISTS `kagent` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `kindKagent` int(11) NOT NULL,
  `typeKagent` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `posada` varchar(20) NOT NULL,
  `birthday` varchar(10) NOT NULL,
  `kuindActivity` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
