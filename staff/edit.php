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
                    $r .= '<option '.$s.' value="'.$v['id'].'">'.$v['name'].'</option>';
                }
                return $r;
            }

            $edit_tpl = file_get_contents(SITE_ROOT.'/tpl/staffEdit.html');

            $teachers   = $DB->db_query('SELECT * FROM teachers WHERE `id`=%d LIMIT 1', [$_GET['s']]);
            $languages  = $DB->db_query('SELECT * FROM languages', ['']);
            $stations   = $DB->db_query('SELECT * FROM stations', ['']);
            $grades     = $DB->db_query('SELECT * FROM teachers_grades', ['']);

            $r_lang     = '';
            $t_lang     = explode(',', $teachers['languages']);
            foreach ($languages as $k => $v) {
                $s = in_array($v['id'], $t_lang) ? 'checked' : '';
                $r_lang .= '<li><label>'.$v['name'].'</label> <input type="checkbox" name="languages[]" '.$s.' value="'.$v['id'].'"></li>';
            }
            $stations = tplSelect($stations, $teachers['metro']);
            $grades = tplSelect($grades, $teachers['grade']);

            $edit_tpl = str_replace('{id}',         $teachers['id'],        $edit_tpl);
            $edit_tpl = str_replace('{fio}',        $teachers['fio'],       $edit_tpl);
            $edit_tpl = str_replace('{phone}',      $teachers['phone'],     $edit_tpl);
            $edit_tpl = str_replace('{email}',      $teachers['email'],     $edit_tpl);
            $edit_tpl = str_replace('{grade}',      $grades,                $edit_tpl);
            $edit_tpl = str_replace('{metro}',      $stations,              $edit_tpl);
            $edit_tpl = str_replace('{languages}',  $r_lang,                $edit_tpl);
            $edit_tpl = str_replace('{wagerate}',   $teachers['wagerate'],  $edit_tpl);
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