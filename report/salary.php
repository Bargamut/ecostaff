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
    <link rel="stylesheet" type="text/css" href="../css/salary.css" />
    <link rel="shortcut icon" href="<?=SITE_ICON?>" type="image/x-icon">
    <title><?=SITE_TITLE?></title>
    <script type="text/javascript" src="../js/jquery/jquery-1.8.2.js"></script>
    <script type="text/javascript" src="../js/jquery/jquery-ui-1.9.0.custom.min.js"></script>
    <script type="text/javascript" src="../js/jquery/jquery-ui-i18n.js"></script>
    <script type="text/javascript" src="../js/jquery/jquery.livequery.js"></script>
    <script type="text/javascript" src="../js/report_salarys.js"></script>
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

//        $status         = $DB->db_query('SELECT `name` FROM projects_status ORDER BY `id`');
//        $filials        = $DB->db_query('SELECT * FROM filial');
//        $clients        = $DB->db_query('SELECT * FROM clients');
//        $p_pays         = $DB->db_query('SELECT `pay1`, `pay2`, `pay3`, `pay4` FROM projects_pays ORDER BY `id`');
        $p_forms        = $DB->db_query('SELECT * FROM projects_form');
        $p_payvariants  = $DB->db_query('SELECT * FROM projects_payvariants');
        $teachers       = $DB->db_query('SELECT `id`, `fio` FROM teachers');
        $managers       = $DB->db_query('SELECT ub.`id`, ub.`fio`, us.`level` FROM users_bio AS ub LEFT JOIN users_site AS us ON ub.`id` = us.`id` ORDER BY ub.`id`');

        foreach($managers as $k => $v) {
            $managers[$k]['fio'] = $SITE->fioFormat($v['fio']);
        }

//        unset($teachers[0]);
        $teachers = array_values($teachers);

        if (!empty($teachers[0])) {
            $p_result = '<table border="0" cellspadding="0" cellspacing="0">';

            foreach ($teachers as $k => $v) {
                if ($k == 0) {
                    $p_result .= '<tr class="caption">'.
                        '<td>№ п/п</td>'.
                        '<td>Преподаватель</td>'.
                        '<td>К выплате</td>'.
                        '</tr>';
                }
                $where = array();
                $vals = array();

                $where[] = '`date` >= %s';
                $where[] = '`date` <= %s';
                $where[] = '`tid` = %d';

                $vals['datebeg'] = (!empty($_GET['datebeg'])) ? $_GET['datebeg'] : date('Y-m-t', strtotime('last month'));
                $vals['dateend'] = (!empty($_GET['dateend'])) ? $_GET['dateend'] : date('Y-m-d');
                $vals['tid'] = $v['id'];

                $where = count($where) > 0 ? 'WHERE ' . implode(' AND ', $where) : '';
                $hours =   $DB->db_query('SELECT `hours`, `wagerate` FROM teachers_hours ' . $where . ' ORDER BY `id`', $vals);
//                $projects       = $DB->db_query('SELECT `wagerate` FROM projects ' . $where . ' ORDER BY `date` DESC', $vals);

                $salary = 0;
                foreach($hours as $kh => $vh) {
                    $salary += $ECON->salTeacher($vh['hours'], $vh['wagerate']);
                }

                $p_result .= '<tr>'.
                    '<td>'.$v['id'].'</td>'.
                    '<td>'.$SITE->fioFormat($v['fio']).'</td>'.
                    '<td>'.$salary.'</td>'.
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

        $main_tpl = file_get_contents(SITE_ROOT.'/tpl/reports/salPage.html');

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
        $main_tpl = str_replace('{salarys}',    $p_result,          $main_tpl);
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