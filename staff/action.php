<?php
/**
 * User: Bargamut
 * Date: 28.09.12
 * Time: 1:33
 */

include('../top.php');

if (!empty($_POST['btnSubm']) || !empty($_POST['btnEdit']) || !empty($_POST['btnClose'])) {
    if (!empty($_POST['btnClose'])) {
        // Регулярные выражения для проверки данных
        $mail_reg   = '/^([a-z0-9])(\w|[.]|-|_)+([a-z0-9])@([a-z0-9])([a-z0-9.-]*)([a-z0-9])([.]{1})([a-z]{2,4})$/isu';
        $phone_reg  = '/^([\+\(\)\-0-9]{7,18})$/isu';

        $SITE->var2send_pm($_POST['email'],     $mail_reg,      'E-Mail');
        $SITE->var2send_pm($_POST['phone'],     $phone_reg,     'Телефон преподавателя');
    }

    if (!array_key_exists('send', $SITE->err)) {
        if (!empty($_POST['languages'])) {$_POST['languages'] = implode(',', $_POST['languages']); }
        if (!empty($_POST['btnSubm'])) { $type = 'create'; }
        if (!empty($_POST['btnEdit'])) { $type = 'update'; }
        if (!empty($_POST['btnClose'])) { $type = 'close'; }
        switch ($type) {
            case 'create':
                switch ($_POST['lvl']) {
                    case 'T':
                        $staff_params = array(
                            $_POST['fio'],
                            $_POST['phone'],
                            $_POST['email'],
                            $_POST['languages'],
                            $_POST['grade'],
                            $_POST['metro']
                        );
                        $DB->db_query('INSERT INTO teachers (`fio`, `phone`, `email`, `languages`, `grade`, `metro`) VALUES (%s, %s, %s, %s, %d, %d)', $staff_params);
                        break;
                    default:
                        $post = array(
                            'fio'       => $_POST['fio'],
                            'login'     => $_POST['login'],
                            'email'     => $_POST['email'],
                            'pass'      => $_POST['pass'],
                            'pass2'     => $_POST['pass'],
                            'filial'    => $_POST['filial'],
                            'lvl'       => $_POST['lvl']
                        );
                        $USER->registration($_POST['btnSubm'], $post);
                        break;
                }
                break;
            case 'update':
                switch ($_POST['lvl']) {
                    case 'T':
                        $teacher = $DB->db_query('SELECT `id` FROM teachers WHERE `id`=%d', $_POST['id']);
                        if (count($teacher) == 1) {
                            $staff_params = array(
                                $_POST['fio'],
                                $_POST['phone'],
                                $_POST['email'],
                                $_POST['languages'],
                                $_POST['grade'],
                                $_POST['metro'],
                                $_POST['id']
                            );
                            $DB->db_query('UPDATE teachers SET `fio`=%s, `phone`=%s, `email`=%s, `languages`=%s, `grade`=%d, `metro`=%d WHERE `id`=%d', $staff_params);
                        }
                        break;
                    default: break;
                }
                break;
//            case 'close':
//                $DB->db_query('UPDATE teachers SET `complete`=%d WHERE `id`=%d', [1, $_POST['id']]);
//                break;
            default: break;
        }
        header('Location: /report/staff.php');
    } else {
        $r = '';
        foreach($SITE->err['send'] as $k => $v) { $r .= '<b>Ошибка!</b> Некорректное значение: ' . $v . '!<br />'; }
        echo $r;
    };
}