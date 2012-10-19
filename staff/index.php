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
    <link rel="stylesheet" type="text/css" href="../css/staff.css" />
    <link rel="shortcut icon" href="<?=SITE_ICON?>" type="image/x-icon">
    <title><?=SITE_TITLE?></title>
    <script type="text/javascript" src="../js/jquery/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="../js/jquery/jquery.livequery.js"></script>
    <script type="text/javascript" src="../js/auth.js"></script>
    <script type="text/javascript" src="../js/staff.js"></script>
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
        <form name="projEdit" method="post" action="action.php" enctype="multipart/form-data">
            <input class="status" name="status" type="hidden" value="<?=isset($_GET['s']) && is_numeric($_GET['s']) ? 'edit' : 'new';?>" />
            <?php
            /**
             * Функция формирования массива значений в <option>
             * @param $needle array - массив значений
             * @param $key - значение для селекта
             * @return string - возвращает <opt...><opt...><opt...>
             */
            function tplSelect($needle, $vkey, $ind, $key) {
                $r = '';
                foreach ($needle as $k => $v) {
                    $s = $v[$vkey] == $key ? 'selected' : '';
                    $r .= '<option '.$s.' value="'.$v[$vkey].'">'.$v[$ind].'</option>';
                }
                return $r;
            }

            $edit_tpl = file_get_contents(SITE_ROOT.'/tpl/forms/staffForm.html');

            if ($_GET['m'] == 't') {
                $teacher    = $DB->db_query('SELECT * FROM teachers WHERE `id`=%d LIMIT 1',     [$_GET['s']]);
            } else {
                $user       = $DB->db_query('SELECT * FROM users_bio WHERE `id`=%d LIMIT 1',    [$_GET['s']]);
                $account    = $DB->db_query('SELECT * FROM users_site WHERE `id`=%d LIMIT 1',   [$_GET['s']]);
            }
            $languages  = $DB->db_query('SELECT * FROM languages',  ['']);
            $stations   = $DB->db_query('SELECT * FROM stations',   ['']);
            $grades     = $DB->db_query('SELECT * FROM teachers_grades',    ['']);
            $filials    = $DB->db_query('SELECT `id`, `name` FROM filial',  ['']);
            $lvls       = $DB->db_query('SELECT `lvl`, `lvlname` FROM users_lvl ORDER BY `id` DESC', ['']);

            $fio        = $teacher[0]['fio']   ? $teacher[0]['fio']   : $user[0]['fio'];
            $email      = $teacher[0]['email'] ? $teacher[0]['email'] : $account[0]['email'];
            $id         = $teacher[0]['id']    ? $teacher[0]['id']    : $user[0]['id'];

            $filials    = tplSelect($filials,   'id',   'name',     $account[0]['fid']);
            $lvls       = tplSelect($lvls,      'lvl',  'lvlname',  $account[0]['level']);
            $stations   = tplSelect($stations,  'id',   'name',     $teacher[0]['metro']);
            $grades     = tplSelect($grades,    'id',   'name',     $teacher[0]['grade']);

            $r_lang     = '';
            $t_lang     = explode(',', $teacher[0]['languages']);
            foreach ($languages as $k => $v) {
                $s = in_array($v['id'], $t_lang) ? 'checked' : '';
                $r_lang .= '<li class="langs"><label>'.$v['name'].'</label> <input type="checkbox" name="languages[]" '.$s.' value="'.$v['id'].'"></li>';
            }

            $edit_tpl = str_replace('{id}',         $id,                $edit_tpl);
            $edit_tpl = str_replace('{fio}',        $fio,               $edit_tpl);
            $edit_tpl = str_replace('{login}',      $account[0]['login'],  $edit_tpl);
            $edit_tpl = str_replace('{phone}',      $teacher[0]['phone'],  $edit_tpl);
            $edit_tpl = str_replace('{email}',      $email,             $edit_tpl);
            $edit_tpl = str_replace('{filial}',     $filials,           $edit_tpl);
            $edit_tpl = str_replace('{lvlname}',    $lvls,              $edit_tpl);
            $edit_tpl = str_replace('{grade}',      $grades,            $edit_tpl);
            $edit_tpl = str_replace('{metro}',      $stations,          $edit_tpl);
            $edit_tpl = str_replace('{languages}',  $r_lang,            $edit_tpl);
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