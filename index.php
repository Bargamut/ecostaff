<?php include('top.php');?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="css/default.css" />
    <link rel="stylesheet" type="text/css" href="css/auth.css" />
    <link rel="stylesheet" type="text/css" href="css/main.css" />
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
        <?php
        $projects       = $DB->db_query('SELECT * FROM projects ORDER BY `id` DESC LIMIT 50', ['']);
        $filials        = $DB->db_query('SELECT * FROM filial',     ['']);
        $clients        = $DB->db_query('SELECT * FROM clients',    ['']);
        $p_forms        = $DB->db_query('SELECT * FROM projects_form',          ['']);
        $p_payvariants  = $DB->db_query('SELECT * FROM projects_payvariants',   ['']);
        $teachers       = $DB->db_query('SELECT `id`, `fio` FROM teachers',     ['']);
        $managers       = $DB->db_query('SELECT `id`, `lastname`, `firstname`, `fathername` FROM users_bio', ['']);


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
                    '<td>Часов в пакете</td>'.
                    '<td>Отчитано</td>'.
                    '<td>Ставка за ак.час</td>'.
                    '<td>Статус</td>'.
                    '<td>Возврат</td>'.
                    '</tr>';
            }
            $v['complete'] = $v['complete'] ? 'Завершено' : 'В процессе';

            $p_result .= '<tr>'.
                '<td><a href="/project/edit.php?p='.$v['number'].'">[ред]</a></td>'.
                '<td class="date">'.$v['date'].'</td>'.
                '<td>'.$v['number'].'</td>'.
                '<td>'.$filials[$v['filial'] - 1]['name'].'</td>'.
                '<td>'.$managers[$v['manager'] - 1]['lastname'].'</td>'.
                '<td>'.$teachers[$v['teacher'] - 1]['fio'].'</td>'.
                '<td>'.$clients[$v['clientid'] - 1]['fio'].'</td>'.
                '<td>'.$v['cost'].'</td>'.
                '<td>'.$v['hours'].'</td>'.
                '<td>'.$v['hours2'].'</td>'.
                '<td>'.$v['wagerate'].'</td>'.
                '<td>'.$v['complete'].'</td>'.
                '<td>'.$v['return'].'</td>'.
                '</tr>';
        }
        $p_result .= '</table>';
        $main_tpl = file_get_contents(SITE_ROOT.'/tpl/mainPage.html');
        $main_tpl = str_replace('{projects}', $p_result, $main_tpl);
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
<?php include('bottom.php');?>