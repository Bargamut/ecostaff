-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 28 2012 г., 02:33
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
  `phone` char(14) NOT NULL COMMENT 'Телефон клиента',
  `email` char(50) NOT NULL COMMENT 'E-Mail клиента',
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
-- Структура таблицы `languages`
--

DROP TABLE IF EXISTS `languages`;
CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID языка',
  `name` char(50) NOT NULL COMMENT 'Название языка',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица языков' AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Структура таблицы `projects`
--

DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID проекта',
  `filial` int(11) NOT NULL COMMENT 'ID филиала проекта',
  `number` tinyint(4) NOT NULL COMMENT 'Номер проекта',
  `hours` tinyint(3) NOT NULL COMMENT 'Количество часов в пакете',
  `hours2` tinyint(3) NOT NULL DEFAULT '0' COMMENT 'Количество часов отчитанных',
  `form` int(11) NOT NULL COMMENT 'ID формы обучения',
  `programm` varchar(1000) NOT NULL COMMENT 'Программа обучения',
  `payvariant` int(11) NOT NULL COMMENT 'ID варианта оплаты',
  `teacher` int(11) NOT NULL COMMENT 'ID преподавателя',
  `wagerate` smallint(5) NOT NULL COMMENT 'Ставка за академический час',
  `cost` mediumint(10) NOT NULL COMMENT 'Сумма договора',
  `manager` int(11) NOT NULL COMMENT 'ID менеджера',
  `data` date NOT NULL DEFAULT '0000-00-00' COMMENT 'Дата заключения договора',
  `etap1` int(10) NOT NULL COMMENT 'Сумма 1-го этапа оплаты',
  `etap2` int(10) NOT NULL COMMENT 'Сумма 2-го этапа оплаты',
  `etap3` int(10) NOT NULL COMMENT 'Сумма 3-го этапа оплаты',
  `etap4` int(10) NOT NULL COMMENT 'Сумма оплаты при подписании договора',
  `complete` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Курс закрыт',
  `return` int(10) NOT NULL COMMENT 'Сумма возврата',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Таблица проектов' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `projects_form`
--

DROP TABLE IF EXISTS `projects_form`;
CREATE TABLE IF NOT EXISTS `projects_form` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID формы обучения',
  `name` char(50) NOT NULL COMMENT 'Название формы обучения',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица форм обучения' AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Структура таблицы `projects_payvariants`
--

DROP TABLE IF EXISTS `projects_payvariants`;
CREATE TABLE IF NOT EXISTS `projects_payvariants` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID варианта оплаты',
  `name` char(50) NOT NULL COMMENT 'Название варианта оплаты',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица вариантов оплаты' AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Структура таблицы `teachers`
--

DROP TABLE IF EXISTS `teachers`;
CREATE TABLE IF NOT EXISTS `teachers` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID преподавателя',
  `fio` char(50) NOT NULL COMMENT 'ФИО преподавателя',
  `phone` char(14) NOT NULL COMMENT 'Телефона преподавателя',
  `email` char(50) NOT NULL COMMENT 'E-Mail преподавателя',
  `languages` char(50) NOT NULL COMMENT 'Массив ID языков преподавателя',
  `grade` int(11) NOT NULL COMMENT 'ID уровня преподавателя',
  `metro` int(11) NOT NULL COMMENT 'ID станции метро',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Таблица преподавателей' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `teachers_grades`
--

DROP TABLE IF EXISTS `teachers_grades`;
CREATE TABLE IF NOT EXISTS `teachers_grades` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID уровня преподавателя',
  `name` char(50) NOT NULL COMMENT 'Название уровня преподавания',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица уровней преподавания' AUTO_INCREMENT=9 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Био членов Клуба' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `users_lvl`
--

DROP TABLE IF EXISTS `users_lvl`;
CREATE TABLE IF NOT EXISTS `users_lvl` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID уровня',
  `lvl` char(2) NOT NULL COMMENT 'Буквенное обозначение должности',
  `lvlname` char(30) NOT NULL COMMENT 'Должность',
  `rights` varchar(100) NOT NULL COMMENT 'Права на данной должности',
  `wagerate` smallint(5) NOT NULL COMMENT 'Ставка в час',
  `salary` mediumint(7) NOT NULL COMMENT 'Оклад',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Уровни полномочий пользователей' AUTO_INCREMENT=6 ;

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
  `filial` int(11) NOT NULL COMMENT 'ID филиала',
  `block` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Флаг блокировки пользователя',
  `block_reason` varchar(255) NOT NULL COMMENT 'Причина блокировки',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Таблица логин-пароль пользователей' AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
