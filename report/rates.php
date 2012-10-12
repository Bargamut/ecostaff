<?php
/**
 * User: Bargamut
 * Date: 11.10.12
 * Time: 23:01
 */
include('../top.php');?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="../css/default.css" />
    <link rel="stylesheet" type="text/css" href="../css/auth.css" />
    <link rel="stylesheet" type="text/css" href="../css/rates.css" />
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
        $lastmonth = $SITE->dateFormat('last day of -1 month', 'Y-m-d');
        $projects       = $DB->db_query('SELECT * FROM projects WHERE `date` > %s ORDER BY `date` DESC', [$lastmonth]);
        $p_forms        = $DB->db_query('SELECT `name` FROM projects_form ORDER BY `id`');
        $p_payvariants  = $DB->db_query('SELECT `name` FROM projects_payvariants ORDER BY `id`');
        $p_status       = $DB->db_query('SELECT `name` FROM projects_status ORDER BY `id`');

        $clients        = $DB->db_query('SELECT `fio` FROM clients');
        $managers       = $DB->db_query('SELECT `id`, `fio` FROM users_bio');

        echo 'Показатель с ' . $SITE->dateFormat($lastmonth) . ' по ' . date('d.m.y');
        $result = '<table border="0" cellspadding="0" cellspacing="0">';

        foreach ($projects as $k => $v) {
            if ($k == 0) {
                $result .= '<tr class="caption">'.
                    '<td class="date">Дата</td>'.
                    '<td>№</td>'.
                    '<td>Клиент</td>'.
                    '<td>Форма обучения</td>'.
                    '<td>Статус</td>'.
                    '<td>Сумма</td>'.
                    '<td>Способ оплаты</td>'.
                    '<td>Менеджер</td>'.
                    '</tr>';
            }

            $man_fio    = $SITE->fioFormat($managers[$v['manager'] - 1]['fio']);
            $client_fio = $SITE->fioFormat($clients[$v['clientid'] - 1]['fio']);

            $result .= '<tr>'.
                '<td class="date">' . $SITE->dateFormat($v['date']) . '</td>'.
                '<td>'.$v['number'].'</td>'.
                '<td>'.$client_fio.'</td>'.
                '<td>'.$p_forms[$v['form'] - 1]['name'].'</td>'.
                '<td>'.$p_status[$v['status'] - 1]['name'].'</td>'.
                '<td>'.$v['cost'].'</td>'.
                '<td>'.$p_payvariants[$v['payvariant'] - 1]['name'].'</td>'.
                '<td>'.$man_fio.'</td>'.
                '</tr>';
        }

        $result .= '</table>';
        $projects_f = $DB->db_query('SELECT * FROM projects WHERE `date` > %s AND `filial` = %d ORDER BY `date` DESC', [$lastmonth, 1]);
        $result .= 'Итого к выплате Мн: ' . $ECON->salManager($projects_f) . ' (Тест по филиалу)<br />';
        $result .= 'Итого к выплате СМ: ' . $ECON->salBigManager($projects_f) . ' (Тест по филиалу)<br />';
        $result .= 'Итого к выплате РФ: ' . $ECON->salFilialDirector($projects_f) . ' (Тест по филиалу)<br />';
        $result .= 'Итого к выплате ИД: ' . $ECON->salInitDirector($projects) . ' (С двух филиалов)';

        $main_tpl = file_get_contents(SITE_ROOT.'/tpl/reports/ratePage.html');
        $main_tpl = str_replace('{rates}', $result, $main_tpl);
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