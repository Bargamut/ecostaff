<?php
session_start();

include_once('common.php');                 // Общий файл настроек
include_once('lang/ru/default.php');        // Общий языковой файл RU
include_once('lang/ru/registration.php');   // Языковой файл для регистрации RU
include_once('lang/ru/auth.php');           // Языковой файл для авторизации RU

include_once('api/api.site.php');           // API Общий
include_once('api/api.database.php');       // API Базы Данных
include_once('api/api.users.php');          // API Пользователей
include_once('api/api.economic.php');       // API Экономических действий

$SITE   = new Site();
$DB     = new Database();
$USER   = new Users($DB);
$ECON   = new Economic($DB);
?>