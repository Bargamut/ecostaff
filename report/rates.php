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
    <link rel="stylesheet" type="text/css" href="../css/ui/redmond/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="../css/default.css" />
    <link rel="stylesheet" type="text/css" href="../css/auth.css" />
    <link rel="stylesheet" type="text/css" href="../css/rates.css" />
    <link rel="shortcut icon" href="<?=SITE_ICON?>" type="image/x-icon">
    <title><?=SITE_TITLE?></title>
    <script type="text/javascript" src="../js/jquery/jquery-1.8.2.js"></script>
    <script type="text/javascript" src="../js/jquery/jquery-ui-1.9.0.custom.min.js"></script>
    <script type="text/javascript" src="../js/jquery/jquery-ui-i18n.js"></script>
    <script type="text/javascript" src="../js/jquery/jquery.livequery.js"></script>
    <script type="text/javascript" src="../js/report_rates.js"></script>
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
        /**
         * Функция формирования массива значений в <option>
         * @param $needle array - массив значений
         * @param $key - значение для селекта
         * @return string - возвращает <opt...><opt...><opt...>
         */
        function tplSelect($needle, $key, $ind) {
            $r = '';
            foreach ($needle as $k => $v) {
                $s = $v['id'] == $key ? 'selected' : '';
                $r .= '<option '.$s.' value="'.$v['id'].'">'.$v[$ind].'</option>';
            }
            return $r;
        }

        $where = array();
        $vals = array();

        if (!empty($_GET['datebeg']))   { $where[] = '`date` >= %s'; $vals['datebeg'] = $_GET['datebeg']; }
        if (!empty($_GET['dateend']))   { $where[] = '`date` <= %s'; $vals['dateend'] = $_GET['dateend']; }
        if (!empty($_GET['payvariant'])){ $where[] = '`payvariant` = %d'; $vals['payvariant'] = $_GET['payvariant']; }
        if (!empty($_GET['manager']))   { $where[] = '`manager` = %d'; $vals['manager'] = $_GET['manager']; }

        $where = count($where) > 0 ? 'WHERE ' . implode(' AND ', $where) : '';

        $projects       = $DB->db_query('SELECT * FROM projects ' . $where . ' ORDER BY `date` DESC', $vals);
        $p_forms        = $DB->db_query('SELECT * FROM projects_form ORDER BY `id`');
        $p_payvariants  = $DB->db_query('SELECT * FROM projects_payvariants ORDER BY `id`');
        $p_status       = $DB->db_query('SELECT * FROM projects_status ORDER BY `id`');

        $clients        = $DB->db_query('SELECT * FROM clients');
        $managers       = $DB->db_query('SELECT ub.`id`, ub.`fio`, us.`level` FROM users_bio AS ub LEFT JOIN users_site AS us ON ub.`id` = us.`id` ORDER BY ub.`id`');

        if (!empty($projects[0])) {
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
            if (isset($_GET['manager'])) {
                foreach($managers as $mk => $mv) {
                    if ($mv['id'] == $_GET['manager']) {
                        switch ($mv['level']) {
                            case 'M': break;
                            case 'MP': $result .= 'Итого: '.$ECON->salManager($projects); break;
                            case 'MF': $result .= 'Итого: '.$ECON->salBigManager($projects); break;
                            case 'AF': $result .= 'Итого: '.$ECON->salFilialDirector($projects); break;
                            case 'AI': $result .= 'Итого: '.$ECON->salInitDirector($projects); break;
                            case 'A': break;
                            default: break;
                        }
                    }
                }
            }
        } else { $result = 'Не найдено ни одного проекта!'; }

            $p_payvariant   = '<option value="0">Все</option>' . tplSelect($p_payvariants, $_GET['payvariant'], 'name');
            $manager        = '<option value="0">Все</option>' . tplSelect($managers, $_GET['manager'], 'fio');

            $main_tpl = file_get_contents(SITE_ROOT.'/tpl/reports/ratePage.html');
            $main_tpl = str_replace('{datebeg}',    $vals['datebeg'],   $main_tpl);
            $main_tpl = str_replace('{dateend}',    $vals['dateend'],   $main_tpl);
            $main_tpl = str_replace('{payvariant}', $p_payvariant,      $main_tpl);
            $main_tpl = str_replace('{manager}',    $manager,           $main_tpl);
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