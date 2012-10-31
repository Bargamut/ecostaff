-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 01 2012 г., 03:11
-- Версия сервера: 5.5.27-log
-- Версия PHP: 5.3.16

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `b134474_ec`
--

-- --------------------------------------------------------

--
-- Структура таблицы `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID клиента',
  `fio` char(255) NOT NULL COMMENT 'ФИО клиента',
  `phone` char(18) NOT NULL COMMENT 'Телефон клиента',
  `email` char(50) NOT NULL COMMENT 'E-Mail клиента',
  `skype` char(15) NOT NULL COMMENT 'Skype клиента',
  `note` varchar(250) NOT NULL COMMENT 'Примечание',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица клиентов' AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `clients`
--

INSERT INTO `clients` (`id`, `fio`, `phone`, `email`, `skype`, `note`) VALUES
(1, 'Петров Павел Алексеевич', '89219710656', 'bargamut@mail.ru', 'bargamut17', 'Примечание такое');

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
-- Структура таблицы `metodists_hours`
--

DROP TABLE IF EXISTS `metodists_hours`;
CREATE TABLE IF NOT EXISTS `metodists_hours` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID записи',
  `tid` int(11) NOT NULL DEFAULT '0' COMMENT 'ID преподавателя',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT 'ID проекта',
  `hours` int(11) NOT NULL DEFAULT '0' COMMENT 'Количество отчитанных часов',
  `wagerate` int(11) NOT NULL DEFAULT '0' COMMENT 'Ставка за ак.час',
  `date` date NOT NULL DEFAULT '0000-00-00' COMMENT 'Дата записи',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='Таблица записей отчитанных часов по проектам.' AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица проектов' AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `projects`
--

INSERT INTO `projects` (`id`, `clientid`, `fid`, `number`, `hours`, `hours2`, `form`, `programm`, `payvariant`, `tid`, `wagerate`, `cost`, `payed`, `mid`, `date`, `status`, `return`) VALUES
(1, 1, 2, 0101, 70, 15, 1, 'Программа зашибись', 2, 1, 250, 70000, 18000, 2, '2012-10-01', 1, 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица платежей по проектам' AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `projects_pays`
--

INSERT INTO `projects_pays` (`id`, `mid`, `pid`, `pay`, `payvariant`, `date`) VALUES
(1, 2, 1, 18000, 0, '2012-10-31');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица преподавателей' AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `teachers`
--

INSERT INTO `teachers` (`id`, `fio`, `phone`, `email`, `languages`, `grade`, `metro`) VALUES
(1, 'Иванов Иван Иванович', '1234567', 'teacher@test.ru', '1,3,4,6', 8, 7),
(2, 'Алексеев Алексей Алексеевич', '7654321', 'teacher2@test.ru', '4,6', 4, 4);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица записей отчитанных часов по проектам.' AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `teachers_hours`
--

INSERT INTO `teachers_hours` (`id`, `tid`, `pid`, `hours`, `wagerate`, `date`) VALUES
(1, 1, 1, 15, 250, '2012-10-31');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Био членов Клуба' AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `users_bio`
--

INSERT INTO `users_bio` (`id`, `fio`, `birthday`) VALUES
(1, 'Иванова Ивана Ивановна', '0000-00-00'),
(2, 'Олегов Олег Олегович', '0000-00-00'),
(3, 'Иринова Ирина Ириновна', '0000-00-00'),
(4, 'Андреев Андрей Андреевич', '0000-00-00'),
(5, 'Неизвестное Летающее Оттак', '0000-00-00'),
(6, 'Иванцова Любовь Викторовна', '0000-00-00');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица логин-пароль пользователей' AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `users_site`
--

INSERT INTO `users_site` (`id`, `email`, `login`, `password`, `salt`, `date_reg`, `date_lastvisit`, `uid`, `level`, `fid`, `block`, `block_reason`) VALUES
(1, 'metodist@test.ru', 'metodist', 'feac05e12c7279d7afcc406012ad146ab251a75505f1fe6f366aaec906ceb3f8c3b0e185b82cddc6d1f3fa0c47ed6b94fdbd9481698d3c54681f0c5175c30916', 'N5zn2N42:a25:nh222:4TfiBFy7kDTy2Kz8yQ52tb7d7s8RdA8TaHfR4kQ_AN52s8Q7d:iYe3FY76eTayk2Kit2bQdYdY2;f5hBe2Y._Fa._RS3:35sfr2Da2.;rbeKhdHa4azYSY6r6e8fD43frYySZ8b349n5;GTQkfSdnHT.Fi:nE;;bRTzbfd5:5Hhn:YG;7DYfTQDZKfAyzsDeYhY4ENT4y8AtF;73B2;GnFBn8BBD42itYast3y3', '2012-10-23 03:08:14', '2012-10-23 03:08:14', 'a61626761f751f6cf058356b574f7dac2fb32316062e8fd712ccf75c3cb14e1e732b681d2e7f52036bef111efb55ab8a3f5224031a872a82c9ce891b89fac2d0', 'M', 1, 0, ''),
(2, 'manager@test.ru', 'manager', 'ed26e15426dad1dba8998bad17694052ed7ffec0512183fe990f06971b4780af22a6c317c7c7295cc706c4789b08aa7716b61318ebfb06bee591fce5214bcf13', '2;i99YsNah6HkyRTTeYT5kG4aQSnte;E9ntGY4QNFfRhRk9.e442;bz36sfRGrdbbQAi8_sFir6RDQSr6kYiak8GS6FB9KYariT9;tf:YnREEN7AGAtskY3:8h:f9th5;NNyn4brsk757sd9b733iQnFYh:HHbS:Rbf:hSr5er:BH8ssf9E5QbQBA2byrz35;.RZS8Q;_72Yk:Fdd34KrA5yBfDeGSG9NNAa4zkkdBESb38_dt65yh:8a_', '2012-10-23 03:09:11', '2012-10-31 05:33:15', '0b0c208232c37a9df37b87c8568b349967b94f8f015dbee387f4162d5612b930b014d84fa8beb7ce6e3b636ee683430c9de438ff8438c83371bc9abcdb59b58f', 'MP', 1, 0, ''),
(3, 'highmanager@test.ru', 'highmanager', '1613df41ead8ffc31e9c42325690010cfce770a50b560b6bd03a2e2b90711af5723ceeb60a886957e17b487fed33f4e260d734e9aa134fcc081182f7f39ad3a1', 'dRkKefFzEaeR9h3Aa7Yfzh;5d6:Tt;NDifr9:.879b4zHED3s52Gn76iA7DAnbZGk6ii3fsZe4Ty2K77r4dtD7ED:;A23yTfD4kKYd6_S;r9dQ_T9YR4Aa6KNf5aR_ia.YQyhTfGiTEArYzZ5dFeyFh4EHQRhtDQb3RbDffd23;YZki5HnN42bhz6nQ4:rbn7FAtiYfies7A.Zf4Q_d8hQ46EiQ9r3Gi79_Rfsh5f3SH99ZtDf;2RSa_GY', '2012-10-23 03:10:49', '2012-10-23 03:10:49', '0bdbd2440da6ebb4f5124eeaf43eaf8349aa0ac94d44cd23656c66d95d8898cc1a9184099984e41ec34c6a19b1b45778ecc81d719ecda4c343cf2ad443caa1cc', 'MF', 1, 0, ''),
(4, 'filialdirector@test.ru', 'filialdirector', '6998f8b56779e5460671db31a8e713d5fa527fe43ef21feae1b3acd6228c3dc92041a120a55f3dc1a0a8a8f6e846a295b05ab9eadc6e9ec4f6eac3b961a743a8', '3:r4Y_aQYZDseKTf7FK7t2:tKT2tsa2..66b4dh2dBfhNRy4hRT3N5bKKa:;4AK3;yiEYsrYFr7aekdeD2K6ZDbKNfRQ5kNT8K_AH2:;BrDT9e:DrSGBBQk:kfEnBBhiEhdT:5._a4D2dA4Z35_K_fnYSa9yB4SZ7REtR8d:4H2tZQ8idiYfR5;EyT6hetnksT4SZKtRRZ3deTnbBk3BY4Sk:_Tshk7fRy4DDfdyf.A9hk39NHNbaQbtb;', '2012-10-23 03:12:03', '2012-10-23 03:12:03', '25a9919a6b480eee73f8ef8c11e81105e5e45e5a6a912b333adb3e635006cdf6a4032a882fdacb4bf13858d911399b2bc9319f5a4244721de42e59556064786e', 'AF', 2, 0, ''),
(5, 'initdiretor@test.ru', 'initdiretor', '53d43510297d6a90e7afd6c6adfa38acd604e17480365acc695121681e772c78234271da21c0a40351aefb3eb8b1950fcbe869ee29a730759e2d38da38d1e638', 'ZG2;Yi:tZEsa:i5h_6_Y4h9:G3iKTFza;biB7bdn.E:fGrZiF9AtT7nadRF;yf9DS_YFBQ7KdzG72B;AfsDT_533Q:dkG4B;K5Rt7K.Y.bE.iQAbF2e2fZe99h6GHNQ32iQhShZ;Rt_KTz9z.H9zsZQSnT__FHkbSSDQeyzeG4Rdz2nZrRDFNBBK5nRQGKaQ935rNQHAtykb.HzY;8brH:Qa;E9b6HBF92ztNN2EY.ThasEYdE;d.Z.h8G', '2012-10-23 03:13:14', '2012-10-23 03:13:14', 'fa62f98ed9c4ec51578fdaa6518939e85511ed19e09a6154edc159ec9911aad639d5b24c78b0c3a5a419d09b3c08e56556c1d94c19d18d62bf7b0379615be1e3', 'AI', 1, 0, ''),
(6, 'bigboss@test.ru', 'bigboss', 'b858d279cabbfe45582c71932b9fdfbd26811718d197a848e579c578282d0c804300d4d6ac0c3c94cbcf0c41e5f42a3915f05887b86a507d87d82d29869541f5', 'izzf5Gn88TFzBFi;7ERiZ8YnbnGEby4kRhF7iBK7rR3hhAGfAB9ZH2bRyB3kkQ:bGh_raznazt9QbrGhz25hSEA;3y9ED.5F:dE_bA9HAb4Y.z34A_szrkR5yYZYrEs;ysSn:aa3KT2aZQZ3NtQKd:Q:tSN2zy63Q8GSEt8YkTfF4bnf:kesn86e:62nfbhH;ad;fd_iSHbF:YBQ__:Q3BNE5ean;zGEGfhnaBae4H.beds5t:bna.sQ7y', '2012-10-23 03:14:47', '2012-10-23 03:14:47', '44a905f710d511392091b905b2198b2e210c1747ad52edef0d51bb828de2b552ed1c8daf6e281f877206cec2c39fcd9d6d8e4a1423a753491372e74378788c7f', 'A', 2, 0, '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
