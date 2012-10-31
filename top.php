<?php include('eng/site.conf.php');

$db_index = $DB->db_connect('idb2.majordomo.ru', 'u134474', 'CP4awWNd6G');
$DB->db_select_db('b134474_ec', $db_index);
mysql_set_charset('utf8', $db_index);

if ($USER->already_login()) {
    $userinfo = $_SESSION['USER'];
    $userinfo['logined'] = true;
} else {
    if ($_SERVER['REQUEST_URI'] != '/auth/') {
        header('Location: http://' . $_SERVER['SERVER_NAME'] . '/auth/');
    }
}
?>