<?php
/**
 * User: Bargamut
 * Date: 28.09.12
 * Time: 1:32
 */
include('../top.php');?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="../css/default.css" />
    <link rel="stylesheet" type="text/css" href="../css/auth.css" />
    <link rel="stylesheet" type="text/css" href="../css/staff.css" />
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
            <?=$userinfo['logined'] ? $USER->userTab($userinfo['UNAME']) : $USER->mAuthForm();?>
        </div>
    </div>
    <div class="content">

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