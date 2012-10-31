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
    <link rel="stylesheet" type="text/css" href="../css/ui/redmond/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="../css/default.css" />
    <link rel="stylesheet" type="text/css" href="../css/auth.css" />
    <link rel="stylesheet" type="text/css" href="../css/project.css" />
    <link rel="shortcut icon" href="<?=SITE_ICON?>" type="image/x-icon">
    <title><?=SITE_TITLE?></title>
    <script type="text/javascript" src="../js/jquery/jquery-1.8.2.js"></script>
    <script type="text/javascript" src="../js/jquery/jquery-ui-1.9.0.custom.min.js"></script>
    <script type="text/javascript" src="../js/jquery/jquery-ui-i18n.js"></script>
    <script type="text/javascript" src="../js/jquery/jquery.livequery.js"></script>
    <script type="text/javascript" src="../js/report_projects.js"></script>
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
        if (!empty($_GET['numbeg']))    { $where[] = '`number` >= %d'; $vals['numbeg'] = $_GET['numbeg']; }
        if (!empty($_GET['numend']))    { $where[] = '`number` <= %d'; $vals['numend'] = $_GET['numend']; }
        if (!empty($_GET['form']))      { $where[] = '`form` = %d'; $vals['form'] = $_GET['form']; }
        if (!empty($_GET['payvariant'])){ $where[] = '`payvariant` = %d'; $vals['payvariant'] = $_GET['payvariant']; }
        if (!empty($_GET['manager']))   { $where[] = '`mid` = %d'; $vals['manager'] = $_GET['manager']; }
        if (!empty($_GET['debt']))      { $where[] = $_GET['debt'] == 1 ? '`cost` > `payed`' : '`cost` <= `payed`'; }
        if (!empty($_GET['return']))    { $where[] = $_GET['return'] == 1 ? '`return` > 0' : '`return` = 0'; }

        $where = count($where) > 0 ? 'WHERE ' . implode(' AND ', $where) : '';

        $projects       = $DB->db_query('SELECT * FROM projects ' . $where . ' ORDER BY `date` DESC LIMIT 50', $vals);
        $status         = $DB->db_query('SELECT `name` FROM projects_status ORDER BY `id`');
        $filials        = $DB->db_query('SELECT * FROM filial');
        $clients        = $DB->db_query('SELECT * FROM clients');
//        $p_pays         = $DB->db_query('SELECT `pay`, FROM projects_pays ORDER BY `id`');
        $p_forms        = $DB->db_query('SELECT * FROM projects_form');
        $p_payvariants  = $DB->db_query('SELECT * FROM projects_payvariants');
        $teachers       = $DB->db_query('SELECT `id`, `fio` FROM teachers');
        $managers       = $DB->db_query('SELECT ub.`id`, ub.`fio`, us.`level` FROM users_bio AS ub LEFT JOIN users_site AS us ON ub.`id` = us.`id` ORDER BY ub.`id`');

        foreach($managers as $k => $v) {
//            if (!preg_match('/MF|MP/', $v['level'])) {
//                unset($managers[$k]);
//            } else {
                $managers[$k]['fio'] = $SITE->fioFormat($v['fio']);
//            }
        }

        if (!empty($projects[0])) {
            $p_result = '<table border="0" cellspadding="0" cellspacing="0">';

            foreach ($projects as $k => $v) {
                if ($k == 0) {
                    $p_result .= '<tr class="caption">'.
                        '<td></td>'.
                        '<td class="date">Дата</td>'.
                        '<td>№</td>'.
                        '<td>Филиал</td>'.
                        '<td>Менеджер</td>'.
                        '<td>Преподаватель</td>'.
                        '<td>Клиент</td>'.
                        '<td>Сумма</td>'.
                        '<td>Остаток</td>'.
                        '<td>Часов в пакете</td>'.
                        '<td>Отчитано</td>'.
                        '<td>Ставка за ак.час</td>'.
                        '<td>Статус</td>'.
                        '<td>Возврат</td>'.
                        '</tr>';
                }

                $teach_fio  = $SITE->fioFormat($teachers[$v['tid'] - 1]['fio']);
                $client_fio = $SITE->fioFormat($clients[$v['clientid'] - 1]['fio']);
                $debt = $v['cost'] - $v['payed'];

                $p_result .= '<tr>'.
                    '<td><a href="/project/index.php?p='.$v['id'].'">[ред]</a></td>'.
                    '<td class="date">'.date('d.m.y', strtotime($v['date'])) .'</td>'.
                    '<td>'.$v['number'].'</td>'.
                    '<td>'.$filials[$v['fid'] - 1]['name'].'</td>'.
                    '<td>'.$managers[$v['mid'] - 1]['fio'].'</td>'.
                    '<td>'.$teach_fio.'</td>'.
                    '<td>'.$client_fio.'</td>'.
                    '<td>'.$v['cost'].'</td>'.
                    '<td>'.$debt.'</td>'.
                    '<td>'.$v['hours'].'</td>'.
                    '<td>'.$v['hours2'].'</td>'.
                    '<td>'.$v['wagerate'].'</td>'.
                    '<td>'.$status[$v['status'] - 1]['name'].'</td>'.
                    '<td>'.$v['return'].'</td>'.
                    '</tr>';
            }

            $p_result .= '</table>';
        } else { $p_result = 'Не найдено ни одного проекта!'; }

        $p_returns = array(0 => array('id' => 1, 'name' => 'Есть'), 1 => array('id' => 2, 'name' => 'Нет'));
        $p_debts = $p_returns;

        $p_form         = '<option value="0">Все</option>' . tplSelect($p_forms, $_GET['form'], 'name');
        $p_payvariant   = '<option value="0">Все</option>' . tplSelect($p_payvariants, $_GET['payvariant'], 'name');
        $p_return       = '<option value="0">Не важно</option>' . tplSelect($p_returns, $_GET['return'], 'name');
        $p_debt         = '<option value="0">Не важно</option>' . tplSelect($p_debts, $_GET['debt'], 'name');
        $manager        = '<option value="0">Все</option>' . tplSelect($managers, $_GET['manager'], 'fio');

        $main_tpl = file_get_contents(SITE_ROOT.'/tpl/reports/projPage.html');

        $main_tpl = str_replace('{datebeg}',    $vals['datebeg'],   $main_tpl);
        $main_tpl = str_replace('{dateend}',    $vals['dateend'],   $main_tpl);
        $main_tpl = str_replace('{numbeg}',     $vals['numbeg'],    $main_tpl);
        $main_tpl = str_replace('{numend}',     $vals['numend'],    $main_tpl);
        $main_tpl = str_replace('{form}',       $p_form,            $main_tpl);
        $main_tpl = str_replace('{payvariant}', $p_payvariant,      $main_tpl);
        $main_tpl = str_replace('{form}',       $p_form,            $main_tpl);
        $main_tpl = str_replace('{manager}',    $manager,           $main_tpl);
        $main_tpl = str_replace('{debt}',       $p_debt,            $main_tpl);
        $main_tpl = str_replace('{return}',     $p_return,          $main_tpl);
        $main_tpl = str_replace('{projects}',   $p_result,          $main_tpl);
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