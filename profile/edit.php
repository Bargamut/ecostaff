<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bargamut
 * Date: 22.07.12
 * Time: 18:58
 */
include('../top.php');?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="../css/default.css" />
    <link rel="stylesheet" type="text/css" href="../css/auth.css" />
    <link rel="stylesheet" type="text/css" href="../css/user.css" />
    <link rel="shortcut icon" href="<?=SITE_ICON?>" type="image/x-icon">
    <title><?=SITE_TITLE?></title>
    <script type="text/javascript" src="../js/jquery/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="../js/auth.js"></script>
</head>

<body>
<div class="main ">
    <div class="header">
        <?=SITE_LOGO?>
        <div id="login_auth">
            <?php
            $userinfo['logined'] ?
                $htmlMAuth = $USER->userTab($userinfo['UNAME'])
            :   $htmlMAuth = $USER->mAuthForm();
            echo $htmlMAuth;
            ?>
        </div>
    </div>
    <div class="content">
        <?php
        if ($USER->check_rights('P:w', $userinfo['rights'])) {
            $profile = $USER->profile($userinfo['email']);
            ?>
            <div class="profile">
                <div id="site" class="info">
                    <h2>Аккаунт</h2>
                    <form action="/profile/action.php" method="post" enctype="multipart/form-data">
                        <span>Уровень:</span> <?=$profile['lvlname'];?><br />
                        <span>E-Mail:</span> <input name="email" type="text" value="<?=$profile['email'];?>" /><br />
                        <span>Новый пароль:</span> <input name="newpass" type="password" value="" /><br />
                        <span>Подтверждение:</span> <input name="newpass2" type="password" value="" />
                        <div class="tool">
                            <span>Старый пароль:</span> <input name="password" type="password" value="" />
                            <input name="type" type="hidden" value="site" />
                            <input name="btnSubm" type="submit" value="Ок" />
                        </div>
                    </form>
                </div>
                <div id="bio" class="info">
                    <h2>БИО</h2>
                    <form action="/profile/action.php" method="post" enctype="multipart/form-data">
                        <span>Фамилия:</span> <input name="lastname" type="text" value="<?=$profile['lastname'];?>" /><br />
                        <span>Имя:</span> <input name="firstname" type="text" value="<?=$profile['firstname'];?>" /><br />
                        <span>Отчество:</span> <input name="fathername" type="text" value="<?=$profile['fathername'];?>" /><br />
                        <span>ДР:</span> <input name="birthday" type="text" value="<?=$profile['birthday'];?>" />
                        <div class="tool">
                            <span>Старый пароль:</span> <input name="password" type="password" value="" />
                            <input name="type" type="hidden" value="bio" />
                            <input name="btnSubm" type="submit" value="Ок" />
                        </div>
                    </form>
                </div>
            </div>
        <?php
        } else {
        ?>
            <div class="error">
                Нет доступа
            </div>
        <?php
        }
        ?>
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
<?php include('../bottom.php');?>