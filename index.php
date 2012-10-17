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
    </div>
    <div class="usertab">
        <?php if ($userinfo['logined']) { echo $USER->userTab($userinfo['UNAME']); }?>
    </div>
    <div class="content">
        <ul>
            <li><a href="/project/index.php">Создать проект</a></li>
            <li><a href="/report/projects.php">Текущие проекты</a></li>
            <li><a href="/staff/edit.php">Новый сотрудник</a></li>
            <li><a href="/report/teachers.php">База преподавателей</a></li>
            <li><a href="#">Персонал</a></li>
            <li><a href="/report/rates.php">Плановый показатель</a></li>
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