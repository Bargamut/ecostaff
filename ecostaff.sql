-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 27 2012 г., 05:28
-- Версия сервера: 5.5.27-log
-- Версия PHP: 5.4.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `ecostaff`
--

-- --------------------------------------------------------

--
-- Структура таблицы `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID клиента',
  `fio` char(255) NOT NULL COMMENT 'ФИО клиента',
  `telephone` char(14) NOT NULL COMMENT 'Телефон клиента',
  `email` char(255) NOT NULL COMMENT 'E-Mail клиента',
  `skype` char(15) NOT NULL COMMENT 'Skype клиента',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Таблица клиентов' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `filial`
--

DROP TABLE IF EXISTS `filial`;
CREATE TABLE IF NOT EXISTS `filial` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID филиала',
  `name` char(50) NOT NULL COMMENT 'Название филиала',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица филиалов' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Структура таблицы `projects`
--

DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID проекта',
  `filial` int(1) NOT NULL COMMENT 'Филиал проекта',
  `number` char(255) NOT NULL COMMENT 'Номер проекта',
  `hours` int(3) NOT NULL COMMENT 'Количество часов в пакете',
  `hours2` int(3) NOT NULL COMMENT 'Количество часов отчитанных',
  `form` int(1) NOT NULL COMMENT 'Форма обучения',
  `programm` int(1) NOT NULL COMMENT 'Программа обучения',
  `payvariant` int(1) NOT NULL COMMENT 'Вариант оплаты',
  `teacher` char(255) NOT NULL COMMENT 'Преподаватель',
  `cost` int(10) NOT NULL COMMENT 'Сумма договора',
  `manager` char(255) NOT NULL COMMENT 'Менеджер',
  `data` date NOT NULL DEFAULT '0000-00-00' COMMENT 'Дата заключения договора',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Таблица проектов' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `users_bio`
--

DROP TABLE IF EXISTS `users_bio`;
CREATE TABLE IF NOT EXISTS `users_bio` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID элемента',
  `firstname` varchar(255) NOT NULL COMMENT 'Имя',
  `lastname` varchar(255) NOT NULL COMMENT 'Фамилия',
  `fathername` varchar(255) NOT NULL COMMENT 'Отчество',
  `birthday` date NOT NULL DEFAULT '0000-00-00' COMMENT 'День рождения',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Био членов Клуба' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Структура таблицы `users_lvl`
--

DROP TABLE IF EXISTS `users_lvl`;
CREATE TABLE IF NOT EXISTS `users_lvl` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID уровня',
  `lvl` char(2) NOT NULL COMMENT 'Буквенное обозначение',
  `lvlname` char(30) NOT NULL COMMENT 'Буквенное обозначение',
  `rights` varchar(100) NOT NULL COMMENT 'Наименование уровня',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Уровни полномочий пользователей' AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Структура таблицы `users_site`
--

DROP TABLE IF EXISTS `users_site`;
CREATE TABLE IF NOT EXISTS `users_site` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID пользователя',
  `email` varchar(50) NOT NULL COMMENT 'E-mail - логин пользователя',
  `password` varchar(128) NOT NULL COMMENT 'Пароль',
  `salt` varchar(250) NOT NULL COMMENT '"Соль" для пароля',
  `date_reg` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Дата регистрации',
  `date_lastvisit` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Дата последней авторизации пользователя',
  `uid` varchar(128) NOT NULL COMMENT 'UID пользователя',
  `level` char(20) NOT NULL DEFAULT 'MP' COMMENT 'Уровень полномочий пользователя',
  `filial` int(1) NOT NULL COMMENT 'Название филиала',
  `block` int(1) NOT NULL DEFAULT '0' COMMENT 'Флаг блокировки пользователя',
  `block_reason` varchar(255) NOT NULL COMMENT 'Причина блокировки',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица логин-пароль пользователей' AUTO_INCREMENT=3 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
