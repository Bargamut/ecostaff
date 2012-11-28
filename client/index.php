<?php
/**
 * User: Bargamut
 * Date: 23.11.12
 * Time: 19:56
 */
include('../top.php');?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="../css/ui/redmond/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="../css/default.css" />
    <link rel="stylesheet" type="text/css" href="../css/auth.css" />
    <link rel="stylesheet" type="text/css" href="../css/client.css" />
    <link rel="shortcut icon" href="<?=SITE_ICON?>" type="image/x-icon">
    <title><?=SITE_TITLE?></title>
    <script type="text/javascript" src="../js/jquery/jquery-1.8.3.js"></script>
    <script type="text/javascript" src="../js/jquery/jquery-ui-1.9.2.custom.min.js"></script>
    <script type="text/javascript" src="../js/jquery/jquery-ui-i18n.js"></script>
    <script type="text/javascript" src="../js/jquery/jquery.livequery.js"></script>
    <script type="text/javascript" src="../js/auth.js"></script>
    <script type="text/javascript" src="../js/client.js"></script>
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
        <form name="clientEdit" method="post" action="action.php" enctype="multipart/form-data">
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

            $clients        = $DB->db_query('SELECT `id`, `fio` FROM clients ORDER BY `id`');
            $clients_groups = $DB->db_query('SELECT `id`, `clients`, `name` FROM clients_groups ORDER BY `id`');

            $p_forms        = $DB->db_query('SELECT * FROM projects_form');
            $p_forms        = tplSelect($p_forms, false, 'name');

            $c = '<li class="new" rel="new">Создать клиента</li>';
            foreach ($clients as $k => $v) {
                $c .= '<li rel="' . $v['id'] . '">' .
                          $v['fio'] .
                          '<img class="drag" src="/img/default/drag.png" />' .
                          '<img class="delete" src="/img/default/delete.png" />' .
                      '</li>';
            }

            $c_groups = '<li class="new" rel="new">Создать группу</li>';
            foreach ($clients_groups as $k => $v) {
                $c_clients = '';
                if (!empty($v['clients'])) {
                    $arrClients = explode(',', $v['clients']);
                    foreach ($arrClients as $kc => $vc) {
                        $c_clients .= '<li rel="' . $vc['id'] . '">' .
                            $clients[$vc['id']-1]['fio'] . '<img class="delete" src="/img/default/close.png" />' .
                            '</li>';
                    }
                }
                $c_groups .= '<li rel="' . $v['id'] . '">'.
                                 $v['name'].
                                 '<ul class="ingroup">'.
                                     $c_clients.
                                 '</ul>'.
                             '</li>';
            }

            $clients_groups = '<option value="0"></option>' . tplSelect($clients_groups, false, 'name');

            $edit_tpl = file_get_contents(SITE_ROOT.'/tpl/forms/clientForm.html');
            $edit_tpl = str_replace('{clients_groups}', $c_groups, $edit_tpl);
            $edit_tpl = str_replace('{clients}', $c, $edit_tpl);
            $edit_tpl = str_replace('{form}', $p_forms, $edit_tpl);
            $edit_tpl = str_replace('{group}', $clients_groups, $edit_tpl);
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