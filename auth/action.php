<?php include_once('../top.php');

$_SESSION['USER'] = $USER->auth($_POST['authSubm'], $_POST['login'], $_POST['pass']);
?>