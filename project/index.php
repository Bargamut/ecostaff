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
    <link rel="stylesheet" type="text/css" href="../css/ui/redmond/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="../css/default.css" />
    <link rel="stylesheet" type="text/css" href="../css/auth.css" />
    <link rel="stylesheet" type="text/css" href="../css/project.css" />
    <link rel="shortcut icon" href="<?=SITE_ICON?>" type="image/x-icon">
    <title><?=SITE_TITLE?></title>
    <script type="text/javascript" src="../js/jquery/jquery-1.8.2.js"></script>
    <script type="text/javascript" src="../js/jquery/jquery.livequery.js"></script>
    <script type="text/javascript" src="../js/jquery/jquery-ui-1.9.0.custom.min.js"></script>
    <script type="text/javascript" src="../js/jquery/jquery-ui-i18n.js"></script>
    <script type="text/javascript" src="../js/auth.js"></script>
    <script type="text/javascript" src="../js/project.js"></script>
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
            <input name="pid" type="hidden" value="<?=isset($_GET['p']) && is_numeric($_GET['p']) ? $_GET['p'] : '';?>">
            <input class="status" name="status" type="hidden" value="<?=isset($_GET['p']) && is_numeric($_GET['p']) ? 'edit' : 'new';?>" />
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

            function setPays($arrPays){
                $res = '';
                $label = 'при подписании договора';
                $n = 0;

                if (!empty($arrPays[0])) {
                    foreach($arrPays as $k => $v) {
                        if ($v['date'] > '0000-00-00') {
                            $res .= '<li><label>' . $label . '</label><input class="payed" name="oldpays[]" type="text" value="' . $v['pay'] . '"></li>';
                            $label = 'этап ' . ($k + 1);
                            $n++;
                        }
                    }
                }

                if ($n < 4) {
                    $res .= '<li><label>' . $label . '</label><input class="newpay" name="pay" type="text" value=""></li>';
                }
                return $res;
            }

            $project        = $DB->db_query('SELECT * FROM projects WHERE `id`=%d LIMIT 1', [$_GET['p']]);
            $p_pays         = $DB->db_query('SELECT `pay`, `date` FROM projects_pays WHERE `pid`=%d ORDER BY `id` LIMIT 4', [$project[0]['id']]);
            $client         = $DB->db_query('SELECT * FROM clients WHERE `id`=%d LIMIT 1', [$project[0]['clientid']]);
            $p_payvariants  = $DB->db_query('SELECT * FROM projects_payvariants',   ['']);
            $p_status       = $DB->db_query('SELECT * FROM projects_status',        ['']);
            $managers       = $DB->db_query('SELECT `id`, `fio` FROM users_bio',    ['']);
            $teachers       = $DB->db_query('SELECT `id`, `fio` FROM teachers',     ['']);
            $filials        = $DB->db_query('SELECT * FROM filial',         ['']);
            $p_forms        = $DB->db_query('SELECT * FROM projects_form',  ['']);

            $pays = setPays($p_pays);

            $teachers       = tplSelect($teachers,      $project[0]['tid'],         'fio');
            $filials        = tplSelect($filials,       $project[0]['fid'],         'name');
            $p_forms        = tplSelect($p_forms,       $project[0]['form'],        'name');
            $managers       = tplSelect($managers,      $project[0]['mid'],         'fio');
            $p_payvariants  = tplSelect($p_payvariants, $project[0]['payvariant'],  'name');
            $p_status       = tplSelect($p_status,      $project[0]['status'],      'name');
            if (isset($project[0]['date'])) { $project[0]['date'] = $SITE->dateFormat($project[0]['date'], 'd.m.Y'); }

            $edit_tpl = file_get_contents(SITE_ROOT.'/tpl/forms/projForm.html');
            $edit_tpl = str_replace('{number}',     $project[0]['number'], $edit_tpl);
            $edit_tpl = str_replace('{date}',       $project[0]['date'],   $edit_tpl);
            $edit_tpl = str_replace('{cost}',       $project[0]['cost'],   $edit_tpl);
            $edit_tpl = str_replace('{filial}',     $filials,           $edit_tpl);
            $edit_tpl = str_replace('{status}',     $p_status,          $edit_tpl);
            $edit_tpl = str_replace('{manager}',    $managers,          $edit_tpl);
            $edit_tpl = str_replace('{teacher}',    $teachers,          $edit_tpl);
            $edit_tpl = str_replace('{fio}',        $client[0]['fio'],     $edit_tpl);
            $edit_tpl = str_replace('{phone}',      $client[0]['phone'],   $edit_tpl);
            $edit_tpl = str_replace('{email}',      $client[0]['email'],   $edit_tpl);
            $edit_tpl = str_replace('{note}',       $client[0]['note'],    $edit_tpl);
            $edit_tpl = str_replace('{skype}',      $client[0]['skype'],   $edit_tpl);
            $edit_tpl = str_replace('{form}',       $p_forms,           $edit_tpl);
            $edit_tpl = str_replace('{programm}',   $project[0]['programm'],   $edit_tpl);
            $edit_tpl = str_replace('{hours}',      $project[0]['hours'],  $edit_tpl);
            $edit_tpl = str_replace('{hours2}',     $project[0]['hours2'], $edit_tpl);
            $edit_tpl = str_replace('{wagerate}',   $project[0]['wagerate'],   $edit_tpl);
            $edit_tpl = str_replace('{pays}',       $pays,              $edit_tpl);
            $edit_tpl = str_replace('{payvariant}', $p_payvariants,     $edit_tpl);
            $edit_tpl = str_replace('{return}',     $project[0]['return'], $edit_tpl);
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