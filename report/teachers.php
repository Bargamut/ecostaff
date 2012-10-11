<?php include('../top.php');?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="../css/default.css" />
    <link rel="stylesheet" type="text/css" href="../css/auth.css" />
    <link rel="stylesheet" type="text/css" href="../css/main.css" />
    <link rel="shortcut icon" href="<?=SITE_ICON?>" type="image/x-icon">
    <title><?=SITE_TITLE?></title>
    <script type="text/javascript" src="../js/jquery/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="../js/auth.js"></script>
</head>

<style>
    .teachers table tr td { padding: 5px; border: 1px #eee dotted; }
    .teachers table tr.caption { text-align: center; font-size: 18px; font-weight: bold; background-color: #ddd; }
</style>

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

        $teachers       = $DB->db_query('SELECT * FROM teachers',           ['']);
        $languages      = $DB->db_query('SELECT * FROM languages ORDER BY `id`',        ['']);
        $t_grades       = $DB->db_query('SELECT * FROM teachers_grades ORDER BY `id`',  ['']);
        $stations       = $DB->db_query('SELECT * FROM stations ORDER BY `id`',         ['']);

        unset($teachers[0]);
        $teachers = array_values($teachers);

        $t_result = '<table border="0" cellspadding="0" cellspacing="0">';
        foreach ($teachers as $k => $v) {
            if ($k == 0) {
                $t_result .= '<tr class="caption">'.
                    '<td></td>'.
                    '<td>ФИО</td>'.
                    '<td>Телефон</td>'.
                    '<td>E-Mail</td>'.
                    '<td>Языки</td>'.
                    '<td>Уровень</td>'.
                    '<td>Метро</td>'.
                    '</tr>';
            }

            $langs = arrayAttr($languages, $v['languages']);


            $t_result .= '<tr>'.
                '<td><a href="/staff/edit.php?s='.$v['id'].'">[ред]</a></td>'.
                '<td>'.$v['fio'].'</td>'.
                '<td>'.$v['phone'].'</td>'.
                '<td>'.$v['email'].'</td>'.
                '<td>'.$langs.'</td>'.
                '<td>'.$t_grades[$v['grade'] - 1]['name'].'</td>'.
                '<td>'.$stations[$v['metro'] - 1]['name'].'</td>'.
                '</tr>';
        }
        $t_result .= '</table>';
        $main_tpl = file_get_contents(SITE_ROOT.'/tpl/reports/teachPage.html');
        $main_tpl = str_replace('{teachers}', $t_result, $main_tpl);
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