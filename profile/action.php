<?php
/**
 * User: Bargamut
 * Date: 22.07.12
 * Time: 20:06
 */

include('../top.php');

$correct_pass = $USER->check_pass($userinfo['email'], $_POST['password']);

if (!empty($_POST['btnSubm']) && !empty($_POST['password']) && $correct_pass) {
    // Регулярные выражения для проверки данных
    $mail_reg   = '/^([a-z0-9])(\w|[.]|-|_)+([a-z0-9])@([a-z0-9])([a-z0-9.-]*)([a-z0-9])([.]{1})([a-z]{2,4})$/isu';
    $date_reg   = '/^([0-9]{4}-[0-9]{2}-[0-9]{2})$/isu';
    $fio_reg    = '/^([А-Яа-яЁёA-Za-z]){3,16}$/isu';

    if (!empty($_POST['newpass']) && !empty($_POST['newpass2'])) {
        if (hash('sha512', $_POST['newpass']) == hash('sha512', $_POST['newpass2'])) {
            $_POST['salt']      = $USER->generateRandString(250);
            $_POST['password']  = hash('sha512', hash('sha512', $_POST['newpass']).$_POST['salt']);
        } else {
            $SITE->err['send'][] = 'Пароли не совпадают!';
        }
    }
    $_POST['email']         = $SITE->var2send_pm($_POST['email'], $mail_reg, 'E-Mail');

    $_POST['lastname']      = $SITE->var2send_pm($_POST['lastname'], $fio_reg, 'Фамилии');
    $_POST['firstname']     = $SITE->var2send_pm($_POST['firstname'], $fio_reg, 'Имени');
    $_POST['fathername']    = $SITE->var2send_pm($_POST['fathername'], $fio_reg, 'Отчества');
    $_POST['birthday']      = $SITE->var2send_pm($_POST['birthday'], $date_reg, 'Дня рождения');

    $tbl = 'users_'.$_POST['type'];

    if ($_POST['type'] != 'site') { unset($_POST['password']); }

    unset($_POST['newpass']);
    unset($_POST['newpass2']);
    unset($_POST['btnSubm']);
    unset($_POST['type']);

    foreach($_POST as $k => $v) { if ($v == '') { unset($_POST[$k]); } }

    if (!array_key_exists('send', $SITE->err)) {
        if ($USER->updProfile($tbl, $_POST, $userinfo['uid'])) {
            echo '<b>ОК!</b> Профиль обновлён!';
        } else {
            echo '<b>ОШИБКА!</b> Профиль не был обновлён!';
        }
    } else {
        $r = '';
        foreach($SITE->err['send'] as $k => $v) { $r .= '<b>Ошибка!</b> Некорректное значение: ' . $v . '!<br />'; }
        echo $r;
    };
} else {
    echo !empty($_POST['btnSubm']).' && '.!empty($_POST['password']).' && '.$correct_pass;
}