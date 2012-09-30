<?php
/**
 * User: Bargamut
 * Date: 28.09.12
 * Time: 1:33
 */
include('../top.php');?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="../css/default.css" />
    <link rel="stylesheet" type="text/css" href="../css/auth.css" />
    <link rel="stylesheet" type="text/css" href="../css/project.css" />
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
            <?php
            /**
             * Функция формирования массива значений в <option>
             * @param $needle array - массив значений
             * @param $key - значение для селекта
             * @return string - возвращает <opt...><opt...><opt...>
             */
            function tplSelect($needle, $key) {
                $r = '';
                foreach ($needle as $k => $v) {
                        $s = $v['id'] == $key ? 'selected' : '';
                        $r .= '<option '.$s.' value="'.$v['id'].'">'.$v['fio'].'</option>';
                }
                return $r;
            }

            $project        = $DB->db_query('SELECT * FROM projects WHERE `number`=%d LIMIT 1', [$_GET['p']]);
            $filial         = $DB->db_query('SELECT `name` FROM filial WHERE `id`=%d',          [$project['filial']]);
            $client         = $DB->db_query('SELECT * FROM clients WHERE `id`=%d LIMIT 1',      [$project['clientid']]);
            $p_form         = $DB->db_query('SELECT `name` FROM projects_form WHERE `id`=%d',           [$project['form']]);
            $p_payvariants  = $DB->db_query('SELECT `name` FROM projects_payvariants WHERE `id`=%d',    [$project['payvariant']]);
            $teachers       = $DB->db_query('SELECT `id`, `fio` FROM teachers',                                   ['']);
            $manager        = $DB->db_query('SELECT `lastname`, `firstname`, `fathername` FROM users_bio WHERE `id`=%d', [$project['manager']]);

            $teachers = tplSelect($teachers, $project['teacher']);
            $manager['fio'] = $manager['lastname'].' '.$manager['firstname'].' '.$manager['fathername'];

            $edit_tpl = file_get_contents(SITE_ROOT.'/tpl/projEdit.html');
            $edit_tpl = str_replace('{number}',     $project['number'], $edit_tpl);
            $edit_tpl = str_replace('{date}',       $project['date'],   $edit_tpl);
            $edit_tpl = str_replace('{cost}',       $project['cost'],   $edit_tpl);
            $edit_tpl = str_replace('{filial}',     $filial['name'],    $edit_tpl);
            $edit_tpl = str_replace('{manager}',    $manager['fio'],    $edit_tpl);
            $edit_tpl = str_replace('{teacher}',    $teachers,          $edit_tpl);
            $edit_tpl = str_replace('{fio}',        $client['fio'],     $edit_tpl);
            $edit_tpl = str_replace('{phone}',      $client['phone'],   $edit_tpl);
            $edit_tpl = str_replace('{email}',      $client['email'],   $edit_tpl);
            $edit_tpl = str_replace('{skype}',      $client['skype'],   $edit_tpl);
            $edit_tpl = str_replace('{form}',       $p_form['name'],    $edit_tpl);
            $edit_tpl = str_replace('{programm}',   $project['programm'],   $edit_tpl);
            $edit_tpl = str_replace('{hours}',      $project['hours'],  $edit_tpl);
            $edit_tpl = str_replace('{hours2}',     $project['hours2'], $edit_tpl);
            $edit_tpl = str_replace('{wagerate}',   $project['wagerate'],   $edit_tpl);
            $edit_tpl = str_replace('{etap4}',      $project['etap4'],  $edit_tpl);
            $edit_tpl = str_replace('{etap1}',      $project['etap1'],  $edit_tpl);
            $edit_tpl = str_replace('{etap2}',      $project['etap2'],  $edit_tpl);
            $edit_tpl = str_replace('{etap3}',      $project['etap3'],  $edit_tpl);
            $edit_tpl = str_replace('{payvariant}', $p_payvariants['name'], $edit_tpl);
            $edit_tpl = str_replace('{return}',     $project['return'], $edit_tpl);
            echo $edit_tpl;
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