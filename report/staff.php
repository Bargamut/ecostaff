<?php include('../top.php');?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="../css/default.css" />
    <link rel="stylesheet" type="text/css" href="../css/staff.css" />
    <link rel="stylesheet" type="text/css" href="../css/auth.css" />
    <link rel="stylesheet" type="text/css" href="../css/main.css" />
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
        <?php
        function arrayAttr($mainarr, $needle) {
            $arr = array();
            $needle = explode(',', $needle);
            foreach ($mainarr as $kl => $vl) {
                foreach ($needle as $kvl => $vvl) {
                    if ($vl['id'] == $vvl) {
                        $arr[] = $vl['name'];
                    }
                }
            }
            return implode(', ', $arr);
        }

        $accounts   = $DB->db_query('SELECT us.`id`, us.`level`, ub.`fio` FROM users_bio AS ub LEFT JOIN users_site AS us ON ub.`id` = us.`id` ORDER BY us.`id');
        $lvls       = $DB->db_query('SELECT `lvl`, `lvlname` FROM users_lvl ORDER BY `id`');

        $s_result = '<table border="0" cellspadding="0" cellspacing="0">';
        foreach ($accounts as $k => $v) {
            if ($k == 0) {
                $s_result .= '<tr class="caption">'.
                    '<td></td>'.
                    '<td>ФИО</td>'.
                    '<td>Должность</td>'.
                    '</tr>';
            }

            foreach ($lvls as $kl => $vl) {
                if ($vl['lvl'] == $v['level']) { $v['lvlname'] = $vl['lvlname']; }
            }

            $s_result .= '<tr>'.
                '<td><a href="/staff/?s='.$v['id'].'">[ред]</a></td>'.
                '<td>'.$v['fio'].'</td>'.
                '<td>'.$v['lvlname'].'</td>'.
                '</tr>';
        }
        $s_result .= '</table>';
        $main_tpl = file_get_contents(SITE_ROOT.'/tpl/reports/staffPage.html');
        $main_tpl = str_replace('{staff}', $s_result, $main_tpl);
        echo $main_tpl;
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