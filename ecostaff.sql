-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 19 2012 г., 12:02
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
  `note` varchar(250) NOT NULL COMMENT 'Примечание',
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

--
-- Дамп данных таблицы `filial`
--

INSERT INTO `filial` (`id`, `name`) VALUES
(1, 'Лиговский'),
(2, 'Комендантский');

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

--
-- Дамп данных таблицы `languages`
--

INSERT INTO `languages` (`id`, `name`) VALUES
(1, 'английский'),
(2, 'французский'),
(3, 'немеций'),
(4, 'итальянский'),
(5, 'испанский'),
(6, 'финский'),
(7, 'латышский'),
(8, 'РКИ');

-- --------------------------------------------------------

--
-- Структура таблицы `projects`
--

DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID проекта',
  `clientid` int(11) NOT NULL COMMENT 'ID клиента',
  `fid` int(11) NOT NULL COMMENT 'ID филиала проекта',
  `number` int(4) unsigned zerofill NOT NULL DEFAULT '0000' COMMENT 'Номер проекта',
  `hours` smallint(3) NOT NULL COMMENT 'Количество часов в пакете',
  `hours2` smallint(3) NOT NULL DEFAULT '0' COMMENT 'Количество часов отчитанных',
  `form` int(11) NOT NULL COMMENT 'ID формы обучения',
  `programm` varchar(1000) NOT NULL COMMENT 'Программа обучения',
  `payvariant` int(11) NOT NULL COMMENT 'ID варианта оплаты',
  `tid` int(11) NOT NULL COMMENT 'ID преподавателя',
  `wagerate` int(5) NOT NULL COMMENT 'Ставка за академический час',
  `cost` mediumint(10) NOT NULL COMMENT 'Сумма договора',
  `payed` mediumint(10) NOT NULL COMMENT 'Оплаченная сумма',
  `mid` int(11) NOT NULL COMMENT 'ID менеджера',
  `date` date NOT NULL DEFAULT '0000-00-00' COMMENT 'Дата заключения договора',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Статус проекта',
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

--
-- Дамп данных таблицы `projects_form`
--

INSERT INTO `projects_form` (`id`, `name`) VALUES
(1, 'индивидуальная'),
(2, 'корпоративная'),
(3, 'групповая'),
(4, 'лагерь');

-- --------------------------------------------------------

--
-- Структура таблицы `projects_pays`
--

DROP TABLE IF EXISTS `projects_pays`;
CREATE TABLE IF NOT EXISTS `projects_pays` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID платежа',
  `mid` int(11) NOT NULL DEFAULT '0' COMMENT 'ID менеджера',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT 'ID проекта',
  `pay` mediumint(10) NOT NULL DEFAULT '0' COMMENT 'Сумма платежа',
  `payvariant` int(11) NOT NULL DEFAULT '0' COMMENT 'Способ оплаты',
  `date` date NOT NULL DEFAULT '0000-00-00' COMMENT 'Дата платежа',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Таблица платежей по проектам' AUTO_INCREMENT=1 ;

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

--
-- Дамп данных таблицы `projects_payvariants`
--

INSERT INTO `projects_payvariants` (`id`, `name`) VALUES
(1, 'Касса'),
(2, 'НОУ Стади (б/н)'),
(3, 'МВС Скул (б/н)');

-- --------------------------------------------------------

--
-- Структура таблицы `projects_status`
--

DROP TABLE IF EXISTS `projects_status`;
CREATE TABLE IF NOT EXISTS `projects_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID статуса',
  `name` char(50) NOT NULL COMMENT 'Наименование статуса',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Статус проектов' AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `projects_status`
--

INSERT INTO `projects_status` (`id`, `name`) VALUES
(1, 'Учится'),
(2, 'Приостановлен'),
(3, 'Оплачен б/ запуска'),
(4, 'Завершён');

-- --------------------------------------------------------

--
-- Структура таблицы `stations`
--

DROP TABLE IF EXISTS `stations`;
CREATE TABLE IF NOT EXISTS `stations` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID станции метро',
  `name` char(50) NOT NULL COMMENT 'Название станции метро',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица станций метро' AUTO_INCREMENT=18 ;

--
-- Дамп данных таблицы `stations`
--

INSERT INTO `stations` (`id`, `name`) VALUES
(1, 'Адмиралтейская'),
(2, 'Академическая'),
(3, 'Балтийская'),
(4, 'Владимирская'),
(5, 'Волковская'),
(7, 'Горьковская'),
(8, 'Девяткино'),
(9, 'Елизаровская'),
(10, 'Звенигородская'),
(11, 'Звёздная'),
(12, 'Кировский завод'),
(13, 'Комендантский проспект'),
(14, 'Купчино'),
(15, 'Ленинский проспект'),
(16, 'Лесная'),
(17, 'Ломоносовская'),
(6, 'Выборгская');

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

--
-- Дамп данных таблицы `teachers_grades`
--

INSERT INTO `teachers_grades` (`id`, `name`) VALUES
(1, 'Beginners'),
(2, 'Elementary'),
(3, 'Pre-Int'),
(4, 'Intermediate'),
(5, 'Upper-Int'),
(6, 'Advanced'),
(7, 'Professional'),
(8, 'Native');

-- --------------------------------------------------------

--
-- Структура таблицы `teachers_hours`
--

DROP TABLE IF EXISTS `teachers_hours`;
CREATE TABLE IF NOT EXISTS `teachers_hours` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID записи',
  `tid` int(11) NOT NULL DEFAULT '0' COMMENT 'ID преподавателя',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT 'ID проекта',
  `hours` int(11) NOT NULL DEFAULT '0' COMMENT 'Количество отчитанных часов',
  `wagerate` int(11) NOT NULL DEFAULT '0' COMMENT 'Ставка за ак.час',
  `date` date NOT NULL DEFAULT '0000-00-00' COMMENT 'Дата записи',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Таблица записей отчитанных часов по проектам.' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `users_bio`
--

DROP TABLE IF EXISTS `users_bio`;
CREATE TABLE IF NOT EXISTS `users_bio` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID элемента',
  `fio` varchar(255) NOT NULL COMMENT 'ФИО пользователя',
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Уровни полномочий пользователей' AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `users_lvl`
--

INSERT INTO `users_lvl` (`id`, `lvl`, `lvlname`, `rights`, `wagerate`, `salary`) VALUES
(1, 'A', 'Директор', 'AN:rw, AP:rw, AS:rw, AC:rw, AF:rw, AE:rw, N:rc, P:rwm, S:rwc, C:rwc, F:rc, E:rc, U:rw', 0, 0),
(3, 'AF', 'Руководитель филиала', 'AN:rw, AP:rw, AS:rw, AC:rw, AF:rw, AE:rw, N:rc, P:rwm, S:rwc, C:rwc, F:rc, E:rc, U:rw', 0, 25000),
(4, 'MF', 'Старший менеджер', 'AN:rw, AP:rw, AS:rw, AC:rw, AF:rw, AE:rw, N:rc, P:rwm, S:rwc, C:rwc, F:rc, E:rc, U:rw', 0, 22000),
(5, 'MP', 'Менеджер', 'AN:rw, AP:rw, AS:rw, AC:rw, AF:rw, AE:rw, N:rc, P:rwm, S:rwc, C:rwc, F:rc, E:rc, U:rw', 0, 20000),
(6, 'M', 'Методист', 'AN:rw, AP:rw, AS:rw, AC:rw, AF:rw, AE:rw, N:rc, P:rwm, S:rwc, C:rwc, F:rc, E:rc, U:rw', 0, 0),
(2, 'AI', 'Исполнительный директор', 'AN:rw, AP:rw, AS:rw, AC:rw, AF:rw, AE:rw, N:rc, P:rwm, S:rwc, C:rwc, F:rc, E:rc, U:rw', 0, 0),
(7, 'T', 'Преподаватель', '', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `users_site`
--

DROP TABLE IF EXISTS `users_site`;
CREATE TABLE IF NOT EXISTS `users_site` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID пользователя',
  `email` varchar(50) NOT NULL COMMENT 'E-mail пользователя',
  `login` varchar(50) NOT NULL COMMENT 'Логин пользователя',
  `password` varchar(128) NOT NULL COMMENT 'Пароль',
  `salt` varchar(250) NOT NULL COMMENT '"Соль" для пароля',
  `date_reg` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Дата регистрации',
  `date_lastvisit` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Дата последней авторизации пользователя',
  `uid` varchar(128) NOT NULL COMMENT 'UID пользователя',
  `level` char(2) NOT NULL DEFAULT 'MP' COMMENT 'Уровень полномочий пользователя',
  `fid` int(11) NOT NULL COMMENT 'ID филиала',
  `block` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Флаг блокировки пользователя',
  `block_reason` varchar(255) NOT NULL COMMENT 'Причина блокировки',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Таблица логин-пароль пользователей' AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
