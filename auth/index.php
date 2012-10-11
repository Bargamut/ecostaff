<?php include('../top.php');?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="../css/default.css" />
    <link rel="stylesheet" type="text/css" href="../css/auth.css" />
    <link rel="shortcut icon" href="<?=SITE_ICON?>" type="image/x-icon">
    <title><?=SITE_TITLE?></title>
    <script type="text/javascript" src="../js/jquery/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="../js/auth.js"></script>
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
    <?php if (!$userinfo['logined']) {?>
        <form id="fAuth" name="fAuth" action="/auth/action.php" method="post" enctype="multipart/form-data">
            <h2><?=AUTH_CAPTION?></h2>
            <input id="email" name="email" type="text" value="<?=AUTH_EMAIL?>" />
            <input id="pass" name="pass" type="password" value="<?=AUTH_PASSWORD?>" />

            <input id="authSubm" name="authSubm" class="button" type="submit" value="<?=AUTH_SUBMIT?>"><br />
            <a href="/registration/">Регистрация</a>
        </form>
    <?php } else { ?>
        <div class="error">
            <div><?=AUTH_CAPTION?></div>
            Вы уже авторизованы!
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