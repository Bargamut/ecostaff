-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 12 2012 г., 04:07
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица клиентов' AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `clients`
--

INSERT INTO `clients` (`id`, `fio`, `phone`, `email`, `skype`, `note`) VALUES
(1, 'ФИО Клиента', '89219710656', 'bargamut@mail.ru', 'bargamut17', ''),
(2, 'Тестовый Клиент Испытателей', '8(812)7468917', 'bargamut.paul@gmail.com', 'bargamut17', ''),
(3, 'Рябкова Надежда Андреевна', '+7-(921)-971-0', 'mail@mail.ru', 'skypeacc', ''),
(4, 'Бухгальтер Вероника Викторовна', '9896008', 'director@mbcschool.ru', 'skypeacc', 'Примечание такое');

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
  `filial` int(11) NOT NULL COMMENT 'ID филиала проекта',
  `number` char(4) NOT NULL COMMENT 'Номер проекта',
  `hours` tinyint(3) NOT NULL COMMENT 'Количество часов в пакете',
  `hours2` tinyint(3) NOT NULL DEFAULT '0' COMMENT 'Количество часов отчитанных',
  `form` int(11) NOT NULL COMMENT 'ID формы обучения',
  `programm` varchar(1000) NOT NULL COMMENT 'Программа обучения',
  `payvariant` int(11) NOT NULL COMMENT 'ID варианта оплаты',
  `teacher` int(11) NOT NULL COMMENT 'ID преподавателя',
  `wagerate` int(5) NOT NULL COMMENT 'Ставка за академический час',
  `cost` mediumint(10) NOT NULL COMMENT 'Сумма договора',
  `manager` int(11) NOT NULL COMMENT 'ID менеджера',
  `date` date NOT NULL DEFAULT '0000-00-00' COMMENT 'Дата заключения договора',
  `etap1` int(10) NOT NULL COMMENT 'Сумма 1-го этапа оплаты',
  `etap2` int(10) NOT NULL COMMENT 'Сумма 2-го этапа оплаты',
  `etap3` int(10) NOT NULL COMMENT 'Сумма 3-го этапа оплаты',
  `etap4` int(10) NOT NULL COMMENT 'Сумма оплаты при подписании договора',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Статус проекта',
  `return` int(10) NOT NULL COMMENT 'Сумма возврата',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица проектов' AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `projects`
--

INSERT INTO `projects` (`id`, `clientid`, `filial`, `number`, `hours`, `hours2`, `form`, `programm`, `payvariant`, `teacher`, `wagerate`, `cost`, `manager`, `date`, `etap1`, `etap2`, `etap3`, `etap4`, `status`, `return`) VALUES
(1, 1, 2, '1234', 30, 18, 3, 'Программа обучения тестовая обновление', 3, 2, 250, 30000, 1, '2321-12-12', 9000, 5000, 6000, 10000, 1, 0),
(2, 2, 2, '1235', 127, 32, 4, 'Офигенная такая', 1, 3, 500, 45000, 2, '2012-09-29', 10000, 0, 0, 30000, 1, 0),
(3, 2, 1, '1236', 127, 100, 4, 'Ещё офигеннее', 2, 1, 1000, 50000, 3, '2012-09-29', 20000, 30000, 0, 5000, 4, 10000),
(4, 3, 1, '1237', 127, 100, 3, 'Офигенная', 2, 2, 300, 40000, 3, '2012-10-12', 0, 0, 0, 10000, 4, 10000),
(5, 4, 1, '0201', 30, 23, 1, 'Курс Путешественник', 1, 3, 320, 22800, 1, '2012-09-21', 0, 0, 0, 10000, 2, 0);

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
-- Структура таблицы `salarys`
--

DROP TABLE IF EXISTS `salarys`;
CREATE TABLE IF NOT EXISTS `salarys` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID выдачи зарплаты',
  `uid` int(11) NOT NULL COMMENT 'ID сотрудника',
  `date` date NOT NULL DEFAULT '0000-00-00' COMMENT 'Дата выдачи зарплаты',
  `salary` int(7) NOT NULL DEFAULT '0' COMMENT 'Сумма зарплаты',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Зарплаты сотрудников' AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица преподавателей' AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `teachers`
--

INSERT INTO `teachers` (`id`, `fio`, `phone`, `email`, `languages`, `grade`, `metro`) VALUES
(1, 'В ожидании', '1234567', 'teacher@test.ru', '1,3,4', 1, 1),
(2, 'Тестовый Преподаватель Полиглотович', '89219710656', 'teacher2@test.ru', '2,3,6,8', 3, 4),
(3, 'Тестовый Заумный Педагог', '4576137', 'teacher3@test.ru', '1,2,3,5', 5, 2),
(4, 'ФИО препода', '1234567', 'prepod@mail.ru', '2,4,5,7', 4, 8),
(5, 'Тестов Создания Преподавателя', '89219710779', 'prepodavatel2@test.ru', '1,3,4,5,6', 5, 4);

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
-- Структура таблицы `users_bio`
--

DROP TABLE IF EXISTS `users_bio`;
CREATE TABLE IF NOT EXISTS `users_bio` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID элемента',
  `fio` varchar(255) NOT NULL COMMENT 'ФИО пользователя',
  `birthday` date NOT NULL DEFAULT '0000-00-00' COMMENT 'День рождения',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Био членов Клуба' AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `users_bio`
--

INSERT INTO `users_bio` (`id`, `fio`, `birthday`) VALUES
(1, 'metodist', '0000-00-00'),
(2, 'manager', '0000-00-00'),
(3, 'bigmanager', '0000-00-00'),
(4, 'filialboss', '0000-00-00'),
(5, 'initdirector', '0000-00-00'),
(6, 'director', '0000-00-00'),
(7, 'Тест Менеджера Собака', '0000-00-00');

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
  `filial` int(11) NOT NULL COMMENT 'ID филиала',
  `block` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Флаг блокировки пользователя',
  `block_reason` varchar(255) NOT NULL COMMENT 'Причина блокировки',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица логин-пароль пользователей' AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `users_site`
--

INSERT INTO `users_site` (`id`, `email`, `login`, `password`, `salt`, `date_reg`, `date_lastvisit`, `uid`, `level`, `filial`, `block`, `block_reason`) VALUES
(1, 'metodist@test.ru', 'metodist', '6a3be811acc973a9b6ff168316d82f076e4123dde87a21ade132a3660bb00f67fb50e1e02e2aca65a3c5cbe8e47b425feaaf7ddd1aa3e80b37562df5140bb403', 'earS5d7:7:NTaYkH3TYfYsDN.Z;.fsDkzzA8.Z.5_d2FKYb__Rha.NzHdzQnZtfdrN_783kf7aF2YdSiZGsF;GDGRb9QK5484iNrkG4f3h3FeEr:D5abZF_.ZrsdKHF76b2b:;dDrT_t;NRnh3Htd_2RF54_Y9Z8Ti3Qk3a:YEbG7HaGfY:8Y.:RstREB_GHDQRNah;HES;6kHG8.k5zF4zKBeEY77FNY5D4nbHG69i4t7Q79Fa4_si7fF', '2012-10-06 03:45:03', '2012-10-06 03:45:03', '37e8fd093c111db9ccaec6143722dca954f5097e5809c38596086dfad9921e676ed5fda1c3c3967b5662fb0f47d5bcae46f41f256c836ff4127fdd909b0cafa7', 'M', 1, 0, ''),
(2, 'manager@test.ru', 'manager', '63a9c15eec875530da9b3d96ab2f7b2b6fa4e5e59785d26cafe6f71b905c3db435018f37b9e31662a2f90a61663b87468cea615b86b172fc2390d28123bbdfbf', 'ya.;QtbkGNdH4;.ZhB6iEFFrGBHa.75nKsZ4Qy8snA3a:RKZ:8KB9ND7iaSSG3:.B_B6634R_AE;BABYFG_k5ZhnAzSQ;BrrAT9zRKyk.Faie5s:hSik7B8dGtFN7h468NYbf:;yTsiG7T8htnryY7dy2R:TYb4Yr8F53yt7YH2s;ei53i;:T_Q9hn_44Q2EG7GndS_6fZyy9dnfy_eyGBhtHNA4b4tNn3Fb_NkBbZSK;7Y4_FrFi;_Zt;', '2012-10-06 03:45:17', '2012-10-11 02:27:48', 'c51bbc247504ffe3e926533502ef14e4f607c534ceda6b5010974888b1a0861d091093da4d61bf18d2948a312dfb61efe132a54a64a92d5f8dfef6b20a605c88', 'MP', 1, 0, ''),
(3, 'bigmanager@test.ru', 'bigmanager', '34e03c007e88503de9f03ebcd2d66c64da998531cc5ea6206748950f76f3917f07e5174098430900060416bd7ca3c33e84217f8d211fa3b29fe50e86efd120c9', 'rRr5nYaQHb9dSTGdRKTb73Sf3Y3NE;fTT4Qnz:Q:SRQ_7_F63dtQfdNF3TDkzzaitt4z2Ah38kd7NS._Y4KBHQQDNtQRbKRNQ:B:7hTTb;B4.KSQr:7KFRHtn;b7R2ThAnY66;yiEy777HFs:rG3Ey4DEB3se5By:QKzHrnz87T8S3hkQStAbFEdy;.tFKe:Ntr4kykTk6YHeRy3T9Zy_z5.Ere4QRsdht2KGQN9n.znARHard4YFKtERz', '2012-10-06 03:45:33', '2012-10-06 03:45:33', 'd90e8e273a99c834e62fbab62824df0d2fd74a4ff2b2ae3c4b022a76eec5cb5adcced99d21ac6f0611a45991afc40c80db90368627b166b08461091a2730b7b5', 'MF', 1, 0, ''),
(4, 'filialboss@test.ru', 'filialboss', '3ce0182de891598d4b52965063ef3e4d1335956563cc394c3c9065949b252fa92f04102c5923827eb6478a0ec126c7d56d0198c2033dcb48b4a29a836316dc3e', 'rY7aSddT9zfYNhEGSak4HS4KKh4srEyN42FDGSrr34EsZ_y4;.f_tf4H;8.Nbd8Nkt3SykK_Yy27;ATA5Qa6ESSTfTe6QKD6nFSe_nAEhe_kyF_AzKf99d86ENhRhsFEa5555_i3RBbsQebKd4itYGN_thfTai:YnfSy4sYHDa.Z5sGe8hEf4fFRrH:7b5:3dYRtFQ2t4ziDtHAArdZZZY8z5SfAKE6d95BQZ;Az;ky3afKyH:e;z3nyys', '2012-10-06 03:45:52', '2012-10-06 03:45:52', '22e4163d8aa88d83713ab861275e392daa64d76cc0a345905105cfe1b76a5048dc3cd772f5a499a1222f8be3ea5ed98668cfaaed233616ee600fcf209fc6d3a8', 'AF', 1, 0, ''),
(5, 'initdirector@test.ru', 'initdirector', 'a92dc734001dbcbdf062aee74869aa95940dd3fd2947f9595e786995d87fd09b1c4e2d13b37cef06df8e54b121f61e5dae605d1bff191752d015f540ead58e89', '9Fh_;Ny::4ZhK4G:S9bY3.9hNZTzYA6H8:9iHRG9NNyzy4eT48bBt7:AKK6FYf4debKydTK9kD456THdR9Sz5Q7SNzTbZ4f;6H2Q5Gd5y5_:rb;e2y7rD_.3B6AN4rfSybf3dnfEdfdf53BtFYirz93SZ.i9r6z2ihkH4A3;zeirYR_KK3sSQ:y_BnRhQ6YHhQnFz2YS3d_TtQbN9zBad34bN2thsEnBeSDnN.5;9R.y7i6yiTSA7KhaSf', '2012-10-06 03:46:09', '2012-10-06 03:46:09', '092a58f53f2a4eb067c7d65f7ea4ab35c1e8f82b7dde279e9845e7647d66ec70bbd2afeb6ab529892a1c3f1142fe41c5d569a25c171cdabbcfbb4a20439eda96', 'AI', 1, 0, ''),
(6, 'director@test.ru', 'director', '9626a0fca90331989084f168ae6128e8cb58f1ab39af4d150f526f640ba98662f0bb5aa80ad74fba13f31a8f8b305531240cb95d3ea1dc91cd382dfe9b76b8d9', 'nstdEH6;GNbze4.4F.f4b_..QSKzzeh5G9Nhh29_fbY5T3bRd6DEnAnahhN8ar43:NykkYY3DYRa8bsEbQe6G;BksdkEkKerGHkG.dR6TsbtT8y7tdrsG5Kf8dns34KHGGQKtK7B8dD65358ARK3zH:T_68_5EGyrn7zy34A7y66Qia.BT3YeiS9nB2GSAB;B63DnGa.zrNtfThdNfrz6DRB95T5K9r:aQ7HbzNH__zhFbd7Ks_5hnAE_H', '2012-10-06 03:46:25', '2012-10-06 03:47:00', '05eb2b536609dee528d47c7113e7dbf5c3f90eade3d3746ce4e565a21eb90eb6a57628901194907fae7bd0cdb9d563743b0d23fd4adb284261565cf303f273b0', 'A', 1, 0, ''),
(7, 'testmanager@test.ru', 'TesterMan', 'ef1f45b858c098d3df006d97bc7b90218ce9beabb982f4ebbe2e0e0e13efdc77f19459f4872e13713a2d32a87a0d6547cb42723b425dffcd761d3ef5a73daaf4', 'nbd7eZ_7A4Y6HDb:9ayty9E9rZ_4zdNBt2__5NGAnyNZBb48:K.yHb_2GiFbitzb688KTz:56AbrZn4NNSrhnirGssEdK2_FDenaSNnkDQrzdRE4S_.8354zZ:YyEiYd42aEtf4NH_G7Hy:;49HEQknQk447aYQDhNHDY3tAnT.QTfErZ_h:G;aAdn96kS8ik73e6Nban2TArk6SnGs.DfDQ;;:Bsd3T8dEb7eQa2iBZD2QQDkZdnYhBHb', '2012-10-09 01:08:14', '2012-10-09 01:10:22', 'd79da8c79c5e6d097cc592d18ba8483040b40217bd84d0a13694f49ccc06a2f49805fd4c2d9e9c13bd8b40d6c921293a53c4fa2375c1d718033a011c24f0deb9', 'MP', 2, 0, '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
