<?php include('top.php');?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="css/default.css" />
    <link rel="stylesheet" type="text/css" href="css/auth.css" />
    <link rel="stylesheet" type="text/css" href="css/main.css" />
    <link rel="shortcut icon" href="<?=SITE_ICON?>" type="image/x-icon">
    <title><?=SITE_TITLE?></title>
    <script type="text/javascript" src="js/jquery/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="js/auth.js"></script>
</head>

<body>
<div class="main ">
    <div class="header">
        <?=SITE_LOGO?>
        <div id="login_auth">
            <?=$userinfo['logined'] ? $USER->userTab($userinfo['UNAME']) : $USER->mAuthForm();?>
        </div>
    </div>
    <div class="content">
        <ul>
            <li><a href="/project/edit.php">Создать проект</a></li>
            <li><a href="/project/">Текущие проекты</a></li>
            <li><a href="/staff/">Новый преподаватель</a></li>
            <li><a href="#">База преподавателей</a></li>
            <li><a href="/registration/">Новый сотрудник</a></li>
            <li><a href="#">Персонал</a></li>
        </ul>
    </div>
    <div class="push"></div>
</div>
<div class="footer">
    <hr />
    <?=CREDITS?>
    <?=DEVELOPERS?>
</div>
</body>
</html>
<?php include('bottom.php');?>