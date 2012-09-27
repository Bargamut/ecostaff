<?php include('top.php');?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="css/default.css" />
    <link rel="stylesheet" type="text/css" href="css/auth.css" />
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
        <?=DEBUG?>
        <pre>
        <?php
//        $values[] = isset($_GET['v']) ? $_GET['v'] : 'null';
//        $values[] = isset($_GET['v2']) ? $_GET['v2'] : 'null';
//        $values[] = isset($_GET['v3']) ? $_GET['v3'] : 'null';
//        print_r($DB->db_query('INSERT INTO table (`field1`, `field2`) VALUES (%s, %d) WHERE `field` LIKE %d:like%', $values));
//        print_r($DB->db_query('UPDATE table SET `date_lastvisit`=%s WHERE `email`=%d LIMIT %d', $values));
//        print_r($DB->db_query('DELETE FROM somelog WHERE `user` = %s AND `nickname` = %d ORDER BY `timestamp` LIMIT %d', $values));
        print_r($USER->profiles());
        ?>
        </pre>
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