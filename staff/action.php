<?php
/**
 * User: Bargamut
 * Date: 28.09.12
 * Time: 1:33
 */

include('../top.php');
echo '<pre>';
print_r($_POST);
echo '</pre>';

if (!empty($_POST['btnSubm']) || !empty($_POST['btnEdit']) || !empty($_POST['btnClose'])) {
    echo 'TEST';
    if (!empty($_POST['btnClose'])) {
        // Регулярные выражения для проверки данных
        $mail_reg   = '/^([a-z0-9])(\w|[.]|-|_)+([a-z0-9])@([a-z0-9])([a-z0-9.-]*)([a-z0-9])([.]{1})([a-z]{2,4})$/isu';
        $phone_reg  = '/^([\+\(\)\-0-9]{7,18})$/isu';

        $SITE->var2send_pm($_POST['email'],     $mail_reg,      'E-Mail');
        $SITE->var2send_pm($_POST['phone'],     $phone_reg,     'Телефон преподавателя');
    }

    if (!array_key_exists('send', $SITE->err)) {
        $_POST['languages'] = implode(',', $_POST['languages']);
        if (!empty($_POST['btnSubm'])) { $type = 'create'; }
        if (!empty($_POST['btnEdit'])) { $type = 'update'; }
        if (!empty($_POST['btnClose'])) { $type = 'close'; }
        switch ($type) {
            case 'create':
                $staff_params = array(
                    $_POST['fio'],
                    $_POST['phone'],
                    $_POST['email'],
                    $_POST['languages'],
                    $_POST['grade'],
                    $_POST['metro']
                );
                echo '<pre>';
                print_r($staff_params);
                echo '</pre>';
                $DB->db_query('INSERT INTO teachers (`fio`, `phone`, `email`, `languages`, `grade`, `metro`) VALUES (%s, %s, %s, %s, %d, %d)', $staff_params);
                break;
            case 'update':
                $teacher = $DB->db_query('SELECT `id` FROM teachers WHERE `fio`=%s', [$_POST['fio']]);
                if (count($client) == 0) {}

                $staff_params = array(
                    $_POST['fio'],
                    $_POST['phone'],
                    $_POST['email'],
                    $_POST['languages'],
                    $_POST['grade'],
                    $_POST['metro'],
                    $_POST['id']
                );
                echo '<pre>';
                print_r($staff_params);
                echo '</pre>';
                $DB->db_query('UPDATE teachers SET `fio`=%s, `phone`=%s, `email`=%s, `languages`=%s, `grade`=%d, `metro`=%d WHERE `id`=%d', $staff_params);
                break;
//            case 'close':
//                $DB->db_query('UPDATE teachers SET `complete`=%d WHERE `id`=%d', [1, $_POST['id']]);
//                break;
            default: break;
        }
    } else {
        $r = '';
        foreach($SITE->err['send'] as $k => $v) { $r .= '<b>Ошибка!</b> Некорректное значение: ' . $v . '!<br />'; }
        echo $r;
    };

    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
}