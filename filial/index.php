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
        <form name="filiEdit" method="post" action="action.php" enctype="multipart/form-data">
            <?php
            /**
             * Функция формирования массива значений в <div>
             * @param $needle array - массив значений
             * @param $key - значение для селекта
             * @return string - возвращает <opt...><opt...><opt...>
             */
            function tplDiv($needle) {
                $r = '';
                foreach ($needle as $k => $v) {
                    $r .= '<div class="filial" rel="' . $v['id'] . '">' . $v['name'] . '</div>';
                }
                return $r;
            }

            $filials = $DB->db_query('SELECT * FROM filial ORDER BY `id`');

            $filials = tplDiv($filials);

            $edit_tpl = file_get_contents(SITE_ROOT.'/tpl/forms/filiForm.html');
            $edit_tpl = str_replace('{filials}', $filials, $edit_tpl);
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