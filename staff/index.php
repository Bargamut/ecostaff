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
        <form name="projEdit" method="post" action="action.php" enctype="multipart/form-data">
            <input name="type" type="hidden" value="<?=$_GET['t']?>">
            <?php
            $staff_tpl  = file_get_contents(SITE_ROOT.'/tpl/staffCreate.html');
            $languages  = $DB->db_query('SELECT * FROM languages', ['']);
            $stations   = $DB->db_query('SELECT * FROM stations', ['']);
            $grades     = $DB->db_query('SELECT * FROM teachers_grades', ['']);
            $r_lang     = '';
            $r_stat     = '';
            $r_grade    = '';
            foreach ($languages as $k => $v) {
                $r_lang .= '<li><label>'.$v['name'].'</label> <input type="checkbox" name="languages[]" value="'.$v['id'].'"></li>';
            }
            foreach ($stations as $k => $v) {
                $r_stat .= '<option value="'.$v['id'].'"> '.$v['name'];
            }
            foreach ($grades as $k => $v) {
                $r_grade .= '<option value="'.$v['id'].'"> '.$v['name'];
            }
            $staff_tpl = str_replace('{languages}', $r_lang,    $staff_tpl);
            $staff_tpl = str_replace('{metro}',     $r_stat,    $staff_tpl);
            $staff_tpl = str_replace('{grade}',    $r_grade,   $staff_tpl);
            echo $staff_tpl;
            ?>
        </form>
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