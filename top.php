<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bargamut
 * Date: 29.06.12
 * Time: 4:17
 */
include_once('eng/site.conf.php');

$db_index = $DB->db_connect('idb2.majordomo.ru', 'ecostaff', 'ecostaff');
$DB->db_select_db('ecostaff', $db_index);
mysql_set_charset('utf8', $db_index);

if ($USER->already_login()) {
    $userinfo = $_SESSION['USER'];
    $userinfo['logined'] = true;
} else {
//    $userinfo = $USER->userinfo('bargamut@mail.ru');
    $userinfo['logined'] = false;
}
?>